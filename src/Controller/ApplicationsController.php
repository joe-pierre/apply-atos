<?php

namespace App\Controller;

use App\Entity\Applicant;
use App\Form\ApplicantType;
use App\Repository\ApplicantRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApplicationsController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function home()
    {
        return $this->render('home.html.twig');
    }
    
    #[Route('/apply-for-job', name: 'app_application')]
    public function index(Request $request, ApplicantRepository $applicantRepo, MailerInterface $mailer): Response
    {
        $applicant = new Applicant;
        $form = $this->createForm(ApplicantType::class, $applicant);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $applicantRepo->add($applicant, flush: true);

            $this->addFlash('success', 'Your application have been sent!');

            $receiver = $form->get('email')->getData();
            $sender = $this->getParameter('app.enterprise_email');

            $email = (new TemplatedEmail())
                ->from($sender)
                ->to($receiver)
                ->subject('Acknowledgment of receipt')

                // path of the Twig template to render
                ->htmlTemplate('emails/acknowledgment_of_receipt.html.twig');

            $mailer->send($email);

            return $this->redirectToRoute('app_home');
        }

        return $this->renderForm('apply.html.twig', compact('form', 'applicant'));
    }
}
