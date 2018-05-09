<?php

namespace App\Form;

use App\Entity\Diplome;
use App\Entity\Personnel;
use App\Entity\TypeDiplome;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DiplomeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type_diplome', EntityType::class, [
                'class' => TypeDiplome::class,
                'choice_label' => 'libelle',
                'label' => 'label.type_diplome'
            ])
            ->add('libelle', TextType::class,[
                'label' => 'label.libelle'
            ])
            ->add('responsable_diplome', EntityType::class, [
                'class' => Personnel::class,
                'choice_label' => 'display',
                'label' => 'label.responsable_diplome'
            ])
            ->add('assistant_diplome', EntityType::class, [
                'class' => Personnel::class,
                'choice_label' => 'display',
                'label' => 'label.assistant_diplome'
            ])
            ->add('code_apogee', TextType::class,[
                'label' => 'label.code_apogee'
            ])
            ->add('code_version', TextType::class,[
                'label' => 'label.code_version'
            ])
            ->add('code_departement', TextType::class,[
                'label' => 'label.code_departement'
            ])
            ->add('opt_nb_jours_saisie', TextType::class,[
                'label' => 'label.opt_nb_jours_saisie'
            ])
            ->add('opt_dilpome_decale', ChoiceType::class,
                [
                    'choices' => ['choice.oui' => true, 'choice.non' => true],
                    'expanded' => true,
                    'choice_translation_domain' => 'form',
                    'label'   => 'label.opt_dilpome_decale'
                ])
            ->add('opt_suppr_absence', ChoiceType::class,
                [
                    'choices' => ['choice.oui' => true, 'choice.non' => true],
                    'expanded' => true,
                    'label'   => 'label.opt_suppr_absence',
                    'choice_translation_domain' => 'form'
                ])
            ->add('opt_methode_calcul', ChoiceType::class,
                [
                    'choices' => ['choice.moymodules' => 'moymodules', 'choice.moyues' => 'moyues'],
                    'expanded' => true,
                    'label'   => 'label.opt_methode_calcul',
                    'choice_translation_domain' => 'form'

                ])
            ->add('opt_anonymat', ChoiceType::class,
                [
                    'choices' => ['choice.oui' => true, 'choice.non' => true],
                    'expanded' => true,
                    'label'   => 'label.opt_anonymat',
                    'choice_translation_domain' => 'form'

                ])
            ->add('opt_commentaires_releve', ChoiceType::class,
                [
                    'choices' => ['choice.oui' => true, 'choice.non' => true],
                    'choice_translation_domain' => 'form',
                    'expanded' => true,
                    'label'   => 'label.opt_commentaires_releve'
                ])
            ->add('opt_espace_perso_visible', ChoiceType::class,
                [
                    'choices' => ['choice.oui' => true, 'choice.non' => true],
                    'expanded' => true,
                    'label'   => 'label.opt_espace_perso_visible',
                    'choice_translation_domain' => 'form'

                ])
            ->add('volume_horaire', TextType::class,[
                'label' => 'label.volume_horaire'
            ])
            ->add('code_celcat_departement', TextType::class,[
                'label' => 'label.code_celcat_departement'
            ])
//todo: ajouter formation

        ;
    }

    /**
     * @param OptionsResolver $resolver
     *
     * @throws \Symfony\Component\OptionsResolver\Exception\AccessException
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Diplome::class,
            'translation_domain' => 'form'

        ]);
    }
}