<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class CatPersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname')
            ->add('firstname')
            ->add('birth', DateType::class, array(
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr'   => array(
                    'class' => 'js-datepicker',
                ),
            ))
            ->add('catCity', EntityType::class, array(
                'class'       => 'AppBundle\Entity\CatCity',
                'empty_value' => false,
            ))
            ->add('catCompany', EntityType::class, array(
                'label'    => 'Firma danej osoby',
                'class'    => 'AppBundle\Entity\CatCompany',
                'property' => 'name',
                'mapped'   => false,
            ))
            ->add('catCompanyOffice', null, array(
                'empty_value' => false,
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\CatPerson'
        ));
    }

    public function getName()
    {
        return 'appbundle_catperson';
    }
}
