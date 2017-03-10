<?php

namespace SnippetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LayoutController extends Controller
{
    public function sidebarAction()
    {
        $technologies = $this
            ->getDoctrine()
            ->getRepository('SnippetBundle:Technology')
            ->findAll();

        return $this->render('SnippetBundle:Layout:sidebar.html.twig', [
            'technologies' => $technologies,
        ]);
    }
}