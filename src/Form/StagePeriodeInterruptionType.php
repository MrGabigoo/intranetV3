<?php

namespace App\Form;

use App\Entity\StagePeriodeInterruption;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StagePeriodeInterruptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateDebut', DateType::class, ['widget' => 'single_text', 'label' => 'label.dateDebut'])
            ->add('dateFin', DateType::class, ['widget' => 'single_text', 'label' => 'label.dateFin'])
            ->add('motif', TextType::class, ['label' => 'label.motif'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => StagePeriodeInterruption::class,
        ]);
    }
}
