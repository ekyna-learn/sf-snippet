<?php

namespace SnippetBundle\Controller;

use SnippetBundle\Entity\Technology;
use SnippetBundle\Form\TechnologyType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;

class TechnologyController extends AbstractController
{
    public function indexAction()
    {
        $snippets = $this
            ->getDoctrine()
            ->getRepository('SnippetBundle:Snippet')
            ->findBy([], ['createdAt' => 'DESC']);

        return $this->render('SnippetBundle:Technology:index.html.twig', [
            'snippets' => $snippets,
        ]);
    }

    public function readAction($technologyId)
    {
        $technology = $this->findTechnologyById($technologyId);

        $snippets = $this
            ->getDoctrine()
            ->getRepository('SnippetBundle:Snippet')
            ->findBy(
                ['technology' => $technology]
            );

        return $this->render('SnippetBundle:Technology:read.html.twig', [
            'technology' => $technology,
            'snippets' => $snippets,
        ]);
    }

    public function createAction(Request $request)
    {
        $technology = new Technology();

        $form = $this
            ->createForm(new TechnologyType(), $technology, [
                'cancel_path' => $this->generateUrl('technology_index'),
            ])
            ->add('submit', 'submit', [
                'label' => 'Créer',
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($technology);
            $em->flush();

            $this->addFlash('success', 'Le technologie a bien été créée.');

            return $this->redirectToRoute('technology_read', [
                'technologyId' => $technology->getId(),
            ]);
        }

        return $this->render('SnippetBundle:Technology:create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function updateAction(Request $request)
    {
        $technology = $this->findTechnologyByRequest($request);

        $cancelPath = $this->generateUrl('technology_read', [
            'technologyId' => $technology->getId(),
        ]);

        $form = $this
            ->createForm(new TechnologyType(), $technology, [
                'cancel_path' => $cancelPath,
            ])
            ->add('submit', 'submit', [
                'label' => 'Modifier',
                'attr' => [
                    'class' => 'btn btn-warning'
                ]
            ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($technology);
            $em->flush();

            $this->addFlash('success', 'Le technologie a bien été modifiée.');

            return $this->redirect($cancelPath);
        }

        return $this->render('SnippetBundle:Technology:update.html.twig', [
            'technology' => $technology,
            'form' => $form->createView(),
        ]);
    }

    public function deleteAction(Request $request)
    {
        $technology = $this->findTechnologyByRequest($request);

        $form = $this->createDeleteConfirmationForm($technology, [
            'cancel_path' => $this->generateUrl('technology_read', [
                'technologyId' => $technology->getId(),
            ]),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->remove($technology);
                $em->flush();

                $this->addFlash('success', 'Le technologie a bien été supprimée.');

                return $this->redirectToRoute('technology_index');
            } catch(ForeignKeyConstraintViolationException $e) {
                $this->addFlash(
                    'danger',
                    'Cette technologie ne peut pas être supprimée car '.
                    'elle est liée à un ou plusieurs snippets.'
                );
            }
        }

        return $this->render('SnippetBundle:Technology:delete.html.twig', [
            'technology' => $technology,
            'form' => $form->createView(),
        ]);
    }
}
