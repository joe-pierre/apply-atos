<?php

namespace App\Form;

use App\Config\Gender;
use App\Entity\Applicant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ApplicantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('gender', EnumType::class, [
                'class' => Gender::class
            ])
            ->add('firstname', TextType::class, [])
            ->add('lastname', TextType::class, [])
            ->add('email', EmailType::class, [])
            ->add('phone', TextType::class, [])
            ->add('experienceYears', IntegerType::class, [])
            ->add('resume', TextType::class, [])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Applicant::class,
        ]);
    }
}
