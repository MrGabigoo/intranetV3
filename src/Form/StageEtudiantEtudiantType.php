<?php

namespace App\Form;

use App\Entity\StageEtudiant;
use App\Form\Type\YesNoType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class StageEtudiantEtudiantType extends AbstractType
{
    protected $flexible = false;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->flexible = $options['flexible'];

        $builder
            ->add('entreprise', EntrepriseType::class, [
                'label' => 'Contact et coordonnées du siège de l\'entreprise',
                'help'  => 'Le siège de l\'entreprise n\'est pas forcément le lieu de stage'
            ])
            ->add('tuteur', ContactType::class)
            ->add('adresseStage', AdresseType::class, [
                'label' => 'Adresse du lieu où le stage sera effectué',
                'help'  => 'Cette adresse peut être différente du siège de l\'entreprise.'
            ])
            ->add(
                'serviceStageEntreprise',
                TextType::class,
                ['label' => 'label.serviceStageEntreprise', 'help' => 'help.serviceStageEntreprise']
            )
            ->add('sujetStage', TextareaType::class, ['label' => 'label.sujetStage', 'help' => 'help.sujetStage'])
            ->add('activites', TextareaType::class, ['label' => 'label.activites', 'help' => 'help.activites'])
            ->add(
                'dureeHebdomadaire',
                TextType::class,
                ['label' => 'label.dureeHebdomadaire', 'help' => 'help.dureeHebdomadaire']
            )
            ->add(
                'commentaireDureeHebdomadaire',
                TextareaType::class,
                ['label' => 'label.commentaireDureeHebdomadaire', 'help' => 'help.commentaireDureeHebdomadaire']
            )
            ->add(
                'periodesInterruptions',
                TextareaType::class,
                ['label' => 'label.periodesInterruptions', 'help' => 'help.periodesInterruptions']
            )
            ->add(
                'amenagementStage',
                TextareaType::class,
                ['label' => 'label.amenagementStage', 'help' => 'help.amenagementStage']
            )
            ->add('gratification', YesNoType::class, ['label' => 'label.gratification', 'help' => 'help.gratification'])
            ->add(
                'gratificationMontant',
                TextType::class,
                ['label' => 'label.gratificationMontant', 'help' => 'help.gratificationMontant']
            )
            ->add(
                'gratificationPeriode',
                ChoiceType::class,
                ['label' => 'label.gratificationPeriode', 'help' => 'help.gratificationPeriode']
            )
            ->add('avantages', TextareaType::class, ['label' => 'label.avantages', 'help' => 'help.avantages']);


        if ($this->flexible === true) {
            //todo: remplacer par un dateRange
            $builder
                ->add(
                    'dateDebutStage',
                    DateType::class,
                    ['label' => 'label.dateDebutStage', 'help' => 'help.dateDebutStage', 'widget' => 'single_text']
                )
                ->add(
                    'dateFinStage',
                    DateType::class,
                    ['label' => 'label.dateFinStage', 'help' => 'help.dateFinStage', 'widget' => 'single_text']
                )

                ->add(
                    'dureeJoursStage',
                    TextType::class,
                    ['label' => 'label.dureeJoursStage', 'help' => 'help.dureeJoursStage']
                );
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'         => StageEtudiant::class,
            'flexible'           => false,
            'translation_domain' => 'form'


        ]);
    }
}
