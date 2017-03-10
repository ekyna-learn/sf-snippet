<?php

namespace SnippetBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SnippetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', [
                'label' => 'Titre',
            ])
            ->add('description', 'textarea', [
                'label' => 'Description',
                'attr' => [
                    'rows' => 8,
                ]
            ])
            ->add('code', 'textarea', [
                'label' => 'Code',
                'attr' => [
                    'rows' => 8,
                ]
            ])
            ->add('links', 'collection', [
                'type'         => new LinkType(),
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'SnippetBundle\Entity\Snippet',
        ]);
    }
}
