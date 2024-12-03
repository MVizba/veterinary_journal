<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Patient;
use App\Entity\PatientExamination;
use App\Entity\Examination;
use App\Entity\Drug;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppointmentController extends AbstractController
{
    #[Route('/new_appointment', name: 'add_appointment')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        // Step 1: Create forms for Client, Patient, and Examination
        $form = $this->createFormBuilder()
            // Client Selection or Creation
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'name',
                'placeholder' => 'Select an existing client',
                'required' => false,
            ])
            ->add('new_client_name', TextType::class, [
                'label' => 'New Client Name',
                'required' => false,
            ])
            ->add('new_client_lastname', TextType::class, [
                'label' => 'New Client Last Name',
                'required' => false,
            ])
            // Patient Selection or Creation
            ->add('patient', EntityType::class, [
                'class' => Patient::class,
                'choice_label' => 'name',
                'placeholder' => 'Select an existing patient',
                'required' => false,
            ])
            ->add('new_patient_name', TextType::class, [
                'label' => 'New Patient Name',
                'required' => false,
            ])
            ->add('new_patient_type', TextType::class, [
                'label' => 'New Patient Type',
                'required' => false,
            ])
            // Examination Selection and Results
            ->add('examination', EntityType::class, [
                'class' => Examination::class,
                'choice_label' => 'examinationName',
                'label' => 'Select Examination',
            ])
            ->add('result', TextareaType::class, [
                'label' => 'Examination Results',
            ])
            // Drug Assignment
            ->add('drugs', EntityType::class, [
                'class' => Drug::class,
                'choice_label' => 'documentName',
                'multiple' => true,
                'expanded' => true,
                'label' => 'Assign Drugs',
            ])
            ->add('drug_amount', IntegerType::class, [
                'label' => 'Drug Amount',
            ])
            ->add('save', SubmitType::class, ['label' => 'Save Appointment'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Step 2: Process Data
            $data = $form->getData();

            // Handle Client
            $client = $data['client'];
            if (!$client) {
                $client = new Client();
                $client->setName($data['new_client_name']);
                $client->setLastName($data['new_client_lastname']);
                $em->persist($client);
            }

            // Handle Patient
            $patient = $data['patient'];
            if (!$patient) {
                $patient = new Patient();
                $patient->setName($data['new_patient_name']);
                $patient->setType($data['new_patient_type']);
                $patient->setClient($client);
                $em->persist($patient);
            }

            // Handle PatientExamination
            $examination = $data['examination'];
            $result = $data['result'];

            $patientExamination = new PatientExamination();
            $patientExamination->setPatient($patient);
            $patientExamination->setExamination($examination);
            $patientExamination->setDate(new \DateTime());
            $patientExamination->setResult($result);

            $em->persist($patientExamination);

            // Handle Drug Assignment
            $drugs = $data['drugs'];
            $drugAmount = $data['drug_amount'];

            foreach ($drugs as $drug) {
                if ($drug->getAmount() < $drugAmount) {
                    $this->addFlash('error', "Not enough stock for drug: {$drug->getDocumentName()}");
                    return $this->redirectToRoute('add_appointment');
                }
                $drug->setAmount($drug->getAmount() - $drugAmount);
                $em->persist($drug);
            }

            // Save to Database
            $em->flush();

            $this->addFlash('success', 'Appointment created successfully!');
            return $this->redirectToRoute('dashboard');
        }

        // Render Form
        return $this->render('appointment/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
