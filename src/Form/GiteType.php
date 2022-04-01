<?php

namespace App\Form;

use App\Entity\Gite;
use App\Entity\Contact;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class GiteType extends AbstractType
{
    private $token;

    public function __construct(TokenStorageInterface $token)
    {
        $this->token = $token;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $this->token->getToken()->getUser();
        
        $builder
            ->add('title')
            ->add('description')
            ->add('image')
            ->add('ville', ChoiceType::class, [
                'attr' => [
                    'class' => 'js-get-cities'
                ],
                'mapped' => false,
                "help" => "Saisissez la ville de votre logement OU son code postal"
            ])
            ->add('surface')
            ->add('nbCouchage', IntegerType::class,[
                "attr" => ["min" => 0]
            ])
            ->add('nbChambre', IntegerType::class,[
                "attr" => ["min" => 0]
            ])
            ->add('isAnimalAccepted')
            ->add('prixAnimal')
            ->add('prixHauteSaison')
            ->add('prixBasseSaison')
            ->add('contact', EntityType::class, [
               "class" => Contact::class,
               'query_builder' => function (EntityRepository $er) use ($user){
                return $er->createQueryBuilder('c')
                    ->where('c.giteOwner = :giteOwner')
                    ->setParameter('giteOwner', $user->getId());
            },
            ])
        ;
        $builder->get('ville')->resetViewTransformers();
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Gite::class,
        ]);
    }
}
