<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class CatPersonType extends AbstractType
{
    protected $company;

    function __construct($company = null)
    {
        $this->company = $company;
    }

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
                'placeholder' => false,
            ))
            ->add('catCompany', EntityType::class, array(
                'label'  => 'Firma danej osoby',
                'class'  => 'AppBundle\Entity\CatCompany',
                'data'   => $this->company,
                'mapped' => false,
            ))
            ->add('catCompanyOffice', EntityType::class, array(
                'class'         => 'AppBundle\Entity\CatCompanyOffice',
                'query_builder' => function (EntityRepository $er) {
                    return $er->qbByCatCompany($this->company);
                },
                'placeholder'   => false,
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\CatPerson'
        ));
    }

    public function getBlockPrefix()
    {
        return 'appbundle_catperson';
    }
}
