<?php

namespace App\Controller;

use App\Entity\Applicant;
use App\Form\ApplicantType;
use App\Repository\ApplicantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApplicationsController extends AbstractController
{
    #[Route('/', name: 'app_applications')]
    public function index(Request $request, ApplicantRepository $applicantRepo): Response
    {
        $applicant = new Applicant;
        $form = $this->createForm(ApplicantType::class, $applicant);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // dd($applicant);

            $applicantRepo->add($applicant, flush: true);

            return $this->redirectToRoute('app_applications');
        }

        // dd($form);

        return $this->renderForm('apply.html.twig', compact('form', 'applicant'));
    }
}
