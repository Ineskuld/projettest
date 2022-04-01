<?php

namespace App\Controller;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Student;

class StudentController extends AbstractController
{
    /**
     * @Route("/student/{numEtud}", methods={"GET","HEAD"})
     */
    public function viewStudent($numEtud) {
        $student = $this->getDoctrine()->getRepository(Student::class);
        $student = $student->find($numEtud);

        if (!$student) {
            throw $this->createNotFoundException(
                'Aucun etudiant pour le numero : ' . $numEtud
            );
        }

        return $this->render(
            'student/view.html.twig',
            array('student' => $student)
        );

    }

    /**
     * @Route("/student/new", methods={"POST","HEAD"})
     */
    public function createStudent(Request $request) {

        $student = new Student();

        $form = $this->createFormBuilder($student)
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('numEtud', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Valider'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $student = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($student);
            $em->flush();

            echo 'Envoyé';
        }

        return $this->render('student/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/student/all", name="students_all")
     */
    public function viewAllStudents() {

        $students = $this->getDoctrine()->getRepository(Student::class);
        $students = $students->findAll();

        return $this->render(
            'student/list.html.twig',
            array('students' => $students)
        );
    }

    /**
     * @Route("/delete/{numEtud}")
     */
    public function deleteStudent($numEtud) {

        $em = $this->getDoctrine()->getManager();
        $student = $this->getDoctrine()->getRepository(Student::class);
        $student = $student->find($numEtud);

        if (!$student) {
            throw $this->createNotFoundException(
                'Pas d\'etudiant pour le numero: ' . $numEtud
            );
        }

        $em->remove($student);
        $em->flush();

        return $this->redirect($this->generateUrl('students_all'));

    }

    /**
     * @Route("/edit/{numEtud}", name="student_edit")
     */
    public function updateAction(Request $request, $numEtud) {

        $student = $this->getDoctrine()->getRepository(Student::class);
        $student = $student->find($numEtud);

        if (!$student) {
            throw $this->createNotFoundException(
                'Pas d\'etudiant pour le numero suivant: ' . $numEtud
            );
        }

        $form = $this->createFormBuilder($student)
            ->add('titre', TextType::class)
            ->add('auteur', TextType::class)
            ->add('description', TextareaType::class)
            ->add('save', SubmitType::class, array('label' => 'Editer'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $student = $form->getData();
            $em->flush();

            return $this->redirect($this->generateUrl('students_all'));

        }

        return $this->render(
            'student/edit.html.twig',
            array('form' => $form->createView())
        );

    }



}