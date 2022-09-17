<?php

namespace App\Controller\Admin;

use App\Config\Gender;
use App\Entity\Position;
use App\Entity\Applicant;
use App\Repository\PositionRepository;
use Vich\UploaderBundle\Form\Type\VichFileType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Symfony\Component\Validator\Constraints\NotBlank;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ApplicantCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Applicant::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setEntityLabelInPlural('Applicants');
    }

    
    public function configureFields(string $pageName): iterable
    {
        $genders = [Gender::Male, Gender::Female];

        return [
            IdField::new('id')->onlyOnIndex(),
            ChoiceField::new('gender')
                ->setFormType(EnumType::class)
                ->setFormTypeOptions([
                    'class' => Gender::class
                ])
                ->setChoices($genders)
                ->renderExpanded()
                ->onlyOnForms(),
            TextField::new('firstName')->setFormTypeOptions([
                    'required' => true
                ]),
            TextField::new('lastName')->setFormTypeOptions([
                    'required' => true
                ]),
            EmailField::new('email')->setFormTypeOptions([
                    'required' => true,
                ]),
            TelephoneField::new('phone')
            ->onlyOnForms(),
            AssociationField::new('position')
                ->setFormType(EntityType::class)
                ->setFormTypeOptions([
                    'class' => Position::class,
                    'choice_label' => 'name',
                    'placeholder' => 'For which position do you wish to apply?',
                    'query_builder' => fn(PositionRepository $positionRepo) => $positionRepo->createQueryBuilder('p')->orderBy('p.name', 'ASC')
                ]),
            IntegerField::new('experienceYears'),
            TextField::new('resumeFile')
                ->setFormType(VichFileType::class)
                ->setFormTypeOptions([
                    'required' => true,
                    'allow_delete' => false,
                    'asset_helper' => false,
                    'constraints' => [
                        new NotBlank(message: 'Please upload your resume')
                    ]
                ])
                ->onlyOnForms(),
            TextField::new('resume')
                ->setFormType(VichFileType::class)
                ->setFormTypeOptions([
                    'data_class' => Applicant::class
                ])
                ->setTemplatePath('resume.html.twig')
                ->onlyOnIndex(),
        ];
    }
   
}
