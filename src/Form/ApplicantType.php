<?php

namespace App\Form;

use App\Config\Gender;
use App\Entity\Applicant;
use App\Entity\Position;
use App\Repository\PositionRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\PositiveOrZero;
use Symfony\Component\Validator\Constraints\Regex;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ApplicantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('gender', EnumType::class, [
                'class' => Gender::class
            ])
            ->add('firstname', TextType::class, [
                'constraints' => [
                    new NotBlank(message: 'This field is required'),
                    new Length(min: 3, minMessage: 'Must contains at least {{ limit }} carchters')
                ]
            ])
            ->add('lastname', TextType::class, [
                'constraints' => [
                    new NotBlank(message: 'This field is required'),
                    new Length(min: 2, minMessage: 'Must contains at least {{ limit }} carchters')
                ]
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank(message: 'This field is required'),
                    new Email(message: 'Set a valid email')
                ]
            ])
            ->add('phone', TelType::class, [
                'constraints' => [
                    new NotBlank(message: 'This field is required'),
                    new Regex([
                        'pattern' => '/^[0-9]+$/',
                        'htmlPattern' => '^[0-9]+$', 
                        'match' => true, 
                        'message' => 'Only numbers']),
                    new Length(
                        min: 9, 
                        max: 9, 
                        minMessage: 'At least {{ limit }} carchters',
                        maxMessage: 'At most {{ limit }} carchters',
                    )
                ]
            ])
            ->add('position', EntityType::class, [
                'class' => Position::class,
                'choice_label' => 'name',
                'constraints' => [
                    new NotBlank(message: 'Please choose a position')
                ],
                'placeholder' => 'For which position do you wish to apply?',
                'query_builder' => fn(PositionRepository $positionRepo) => $positionRepo->createQueryBuilder('p')->orderBy('p.name', 'ASC')
            ])
            ->add('experienceYears', IntegerType::class, [
                'constraints' => [
                    new NotBlank(message: 'This field is required'),
                    new PositiveOrZero,
                ]
            ])
            ->add('resumeFile', VichFileType::class, [
                'required' => true,
                'allow_delete' => false,
                'asset_helper' => true,
                'constraints' => [
                    new NotBlank(message: 'Please upload your resume')
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Applicant::class,
        ]);
    }
}
