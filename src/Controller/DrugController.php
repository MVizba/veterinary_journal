<?php

namespace App\Controller;

use App\Entity\Drug;
use App\Form\DrugType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DrugController extends AbstractController
{

    #[Route('/add-drug', name: 'add_drug')]
    #[isGranted('ROLE_ADMIN')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $drug = new Drug();
        $form = $this->createForm(DrugType::class, $drug);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($drug);
            $em->flush();

            $this->addFlash('success', 'drug added successfully.');
            return $this->redirectToRoute('dashboard');
        }
        return $this->render('drug/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
