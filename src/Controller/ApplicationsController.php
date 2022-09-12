<?php

namespace App\Controller;

use App\Entity\Applicant;
use App\Form\ApplicantType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApplicationsController extends AbstractController
{
    #[Route('/', name: 'app_applications')]
    public function index(): Response
    {
        $applicant = new Applicant;
        $form = $this->createForm(ApplicantType::class, $applicant);

        // dd($form);

        return $this->renderForm('apply.html.twig', compact("form"));
    }
}
