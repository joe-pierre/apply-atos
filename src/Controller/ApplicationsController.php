<?php

namespace App\Controller;

use App\Form\ApplicantType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApplicationsController extends AbstractController
{
    #[Route('/', name: 'app_applications')]
    public function index(): Response
    {
        $form = $this->createForm(ApplicantType::class);

        // dd($form);

        return $this->renderForm('applications/index.html.twig', compact("form"));
    }
}
