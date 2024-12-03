<?php

namespace App\Controller;

use App\Entity\Examination;
use App\Form\ExaminationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ExaminationController extends AbstractController
{

    #[Route('/add-examination', name: 'add_examination')]
    #[isGranted('ROLE_ADMIN')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $examination = new Examination();
        $form = $this->createForm(ExaminationType::class, $examination);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($examination);
            $em->flush();

            $this->addFlash('success', 'Examination added successfully.');
            return $this->redirectToRoute('dashboard');
        }
        return $this->render('examination/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
