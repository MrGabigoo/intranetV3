<?php

namespace App\Form;

use App\Entity\StageEtudiant;
use App\Form\Type\YesNoType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StageEtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('entreprise', EntrepriseType::class, ['label' => 'label.entreprise'])
            ->add('tuteur', ContactType::class, ['label' => 'label.tuteurEntreprise'])
            ->add('serviceStageEntreprise', TextType::class, ['label' => 'label.serviceStageEntreprise'])
            ->add('sujetStage', TextareaType::class, ['label' => 'label.sujetStage'])
            ->add('activites', TextareaType::class, ['label' => 'label.activites'])

            ->add('dateDebutStage', DateType::class, ['label' => 'label.dateDebutStage', 'widget' => 'single_text'])
            ->add('dateFinStage', DateType::class, ['label' => 'label.dateFinStage', 'widget' => 'single_text'])
            ->add('dureeHebdomadaire', TextType::class, ['label' => 'label.dureeHebdomadaire'])
            ->add('dureeJoursStage', TextType::class, ['label' => 'label.dureeJoursStage'])
            ->add('amenagementStage', TextareaType::class, ['label' => 'label.amenagementStage'])

            ->add('gratification', YesNoType::class, ['label' => 'label.gratification'])
            ->add('gratificationMontant', TextType::class, ['label' => 'label.gratificationMontant'])
            ->add('gratificationPeriode', ChoiceType::class, ['label' => 'label.gratificationPeriode'])
            ->add('avantages', TextareaType::class, ['label' => 'label.avantages'])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => StageEtudiant::class,
            'translation_domain' => 'form'
        ]);
    }
}
