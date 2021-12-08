<?php
// src/Form/Type/RssFeed.php
namespace App\Form\Type;

use App\Entity\RssFeed;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class RssFeedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class, [
            'attr' => [
                'placeholder' => 'Feed name'
            ]
        ])
        ->add('url', TextType::class, [
            'attr' => [
                'placeholder' => 'Feed URL',
            ],            
        ])
        ->add('lang', ChoiceType::class, [
            'choices' => [
                'Select' => null,
                'English' => 'en',
                'Spanish' => 'es'   
            ],
        ])
        ->add('active', ChoiceType::class, [
            'choices' => [
                'Yes' => '1',
                'No' => '0'   
            ],
            'expanded' => true
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Save RSS',
            'attr' =>[
                'class' => 'btn-outline-dark btn-block'
            ],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RssFeed::class,
        ]);
    }
}

?>