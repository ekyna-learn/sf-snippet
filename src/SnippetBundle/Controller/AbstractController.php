<?php

namespace SnippetBundle\Controller;

use SnippetBundle\Entity\Technology;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\IsTrue;

abstract class AbstractController extends Controller
{
    /**
     * Finds the technology by request.
     * 
     * @param Request $request
     * 
     * @return null|Technology
     */
    protected function findTechnologyByRequest(Request $request)
    {
        return $this->findTechnologyById(
            $request->attributes->get('technologyId')
        );
    }

    /**
     * Finds a technology by its ID.
     *
     * @param integer $id
     *
     * @return null|Technology
     */
    protected function findTechnologyById($id)
    {
        $technology = $this
            ->getDoctrine()
            ->getRepository('SnippetBundle:Technology')
            ->find($id);

        if (null === $technology) {
            throw $this->createNotFoundException('Technology not found');
        }

        return $technology;
    }

    /**
     * Finds the snippet by request.
     *
     * @param Request $request
     *
     * @return null|\SnippetBundle\Entity\Snippet
     */
    protected function findSnippetByRequest(Request $request)
    {
        return $this->findSnippetById(
            $this->findTechnologyByRequest($request),
            $request->attributes->get('snippetId')
        );
    }
    
    /**
     * Finds a snippet by technology and its ID.
     *
     * @param Technology $technology
     * @param integer $id
     *
     * @return null|\SnippetBundle\Entity\Snippet
     */
    protected function findSnippetById(Technology $technology, $id)
    {
        $snippet = $this
            ->getDoctrine()
            ->getRepository('SnippetBundle:Snippet')
            ->findOneBy([
                'id' => $id,
                'technology' => $technology,
            ]);

        if (null === $snippet) {
            throw $this->createNotFoundException('Snippet not found');
        }

        return $snippet;
    }

    /**
     * @param mixed $entity
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    protected function createDeleteConfirmationForm($entity, array $options)
    {
        //$message = sprintf('Êtes-vous sur de vouloir supprimer &laquo; %s &raquo; ?', $entity);
        $message = sprintf('Êtes-vous sur de vouloir supprimer : %s ?', $entity);

        return $this
            ->createFormBuilder(null, $options)
            ->add('confirmation', 'checkbox', [
                'label' => $message,
                'required' => true,
                'constraints' => [
                    new IsTrue(),
                ]
            ])
            ->add('submit', 'submit', [
                'label' => 'Supprimer',
                'attr' => [
                    'class' => 'btn btn-danger'
                ]
            ])
            ->getForm();
    }
}