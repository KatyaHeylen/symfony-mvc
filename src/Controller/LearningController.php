<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class LearningController extends AbstractController
{
    #[Route('/about-me', name: 'aboutMe')]
    public function aboutMe(): Response
    {
        return $this->render('learning/aboutMe.html.twig', [
            'name' => 'LearningController',
        ]);

    }

    #[Route('/', name: 'showMyName')]
    public function showMyName(Request $request): Response
    {
        $form = $this->createFormBuilder()
            ->add('name', TextType::class)
            ->add('send', SubmitType::class, ['label' => 'Send'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $name = $task['name'];
            $session = $this->requestStack->getSession();
            $session->set('name', $name);

            return $this->render('learning/showMyName.html.twig', [
                'name' => $name,
                'form' => $form->createView(),]);
        }
        return $this->render('learning/showMyName.html.twig', ['name' => 'unknown',
            'form' => $form->createView(),
        ]);
    }
}
