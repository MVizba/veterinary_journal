<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Patient;
use App\Form\ClientType;
use App\Form\PatientType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientPatientController extends AbstractController
{
    #[Route('/add-client', name: 'add_client')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $client = new Client();
        $patient = new Patient();

        $clientForm = $this->createForm(ClientType::class, $client);
        $clientForm->handleRequest($request);

        $patientForm = $this->createForm(PatientType::class, $patient, [
            'action' => $this->generateUrl('add_client'),
        ]);
        $patientForm->add('client', EntityType::class, [
            'class' => Client::class,
            'choice_label' => 'name',
            'required' => false,
        ]);
        $patientForm->handleRequest($request);

        if ($clientForm->isSubmitted() && $clientForm->isValid()) {
            $em->persist($client);
            $em->flush();
            $this->addFlash('success', 'Client added successfully!');
            return $this->redirectToRoute('add_client');
        }

        if ($patientForm->isSubmitted() && $patientForm->isValid()) {
            $client = $patientForm->get('client')->getData();
            if (!$client) {
                $this->addFlash('error', 'You must select or create a Client first.');
                return $this->redirectToRoute('add_client');
            }

            $patient->setClient($client);
            $em->persist($patient);
            $em->flush();

            $this->addFlash('success', 'Patient added successfully!');
            return $this->redirectToRoute('add_client');
        }

        return $this->render('client_patient/add.html.twig', [
            'client_form' => $clientForm->createView(),
            'patient_form' => $patientForm->createView(),
        ]);
    }
}
