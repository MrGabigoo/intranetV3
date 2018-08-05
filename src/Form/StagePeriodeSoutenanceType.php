<?php

namespace App\Form;

use App\Entity\StagePeriodeSoutenance;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StagePeriodeSoutenanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateDebut', DateType::class, ['widget' => 'single_text', 'label' => 'label.dateDebut'])
            ->add('dateFin', DateType::class, ['widget' => 'single_text', 'label' => 'label.dateFin'])
            ->add('dateRenduRapport', DateTimeType::class, ['widget' => 'single_text', 'label' => 'label.dateRenduRapport'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => StagePeriodeSoutenance::class,
        ]);
    }
}
