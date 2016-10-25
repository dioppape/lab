<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre');
        $builder->add('leadings');
        $builder->add('body');
        $builder->add('slug');
        $builder->add('createdBy');
        //$builder->add('submit','submit');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Article',
            'csrf_protection' => false //API CRS_PROTECTION à FALSE
        ]);
    }
}