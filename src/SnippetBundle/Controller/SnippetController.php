<?php

namespace SnippetBundle\Controller;


use SnippetBundle\Entity\Snippet;
use SnippetBundle\Form\SnippetType;
use Symfony\Component\HttpFoundation\Request;

class SnippetController extends AbstractController
{
    public function readAction(Request $request)
    {
        return $this->render('SnippetBundle:Snippet:read.html.twig', [
            'snippet' => $this->findSnippetByRequest($request),
        ]);
    }

    public function createAction(Request $request)
    {
        $technology = $this->findTechnologyByRequest($request);

        $snippet = new Snippet();
        $snippet->setTechnology($technology);

        $form = $this
            ->createForm(new SnippetType(), $snippet)
            ->add('submit', 'submit', [
                'label' => 'Créer',
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($snippet);
            $em->flush();

            $this->addFlash('success', 'Le snippet a bien été créé.');

            return $this->redirectToRoute('snippet_read', [
                'technologyId' => $technology->getId(),
                'snippetId' => $snippet->getId(),
            ]);
        }

        return $this->render('SnippetBundle:Snippet:create.html.twig', [
            'technology' => $technology,
            'form' => $form->createView(),
        ]);
    }

    public function updateAction(Request $request)
    {
        $snippet = $this->findSnippetByRequest($request);

        $cancelPath = $this->generateUrl('snippet_read', [
            'technologyId' => $snippet->getTechnology()->getId(),
            'snippetId' => $snippet->getId(),
        ]);

        $form = $this
            ->createForm(new SnippetType(), $snippet, [
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
            $em->persist($snippet);
            $em->flush();

            $this->addFlash('success', 'Le snippet a bien été modifié.');

            return $this->redirect($cancelPath);
        }

        return $this->render('SnippetBundle:Snippet:create.html.twig', [
            'snippet' => $snippet,
            'form' => $form->createView(),
        ]);
    }

    public function deleteAction(Request $request)
    {
        $snippet = $this->findSnippetByRequest($request);
        $technology = $snippet->getTechnology();

        $form = $this->createDeleteConfirmationForm($snippet, [
            'cancel_path' => $this->generateUrl('snippet_read', [
                'technologyId' => $snippet->getTechnology()->getId(),
                'snippetId' => $snippet->getId(),
            ]),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($snippet);
            $em->flush();

            $this->addFlash('success', 'Le snippet a bien été supprimé.');

            return $this->redirectToRoute('technology_read', [
                'technologyId' => $technology->getId(),
            ]);
        }

        return $this->render('SnippetBundle:Snippet:delete.html.twig', [
            'snippet' => $snippet,
            'form' => $form->createView(),
        ]);
    }
}
