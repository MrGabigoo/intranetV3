<?php

namespace App\Form;

use App\Entity\Semestre;
use App\Entity\StagePeriode;
use App\Form\Type\YesNoType;
use App\Repository\SemestreRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class StagePeriodeType extends AbstractType
{
    private $formation;

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->formation = $options['formation'];
        $builder
            ->add('libelle', TextType::class, ['label' => 'label.libelle', 'help' => 'help.libelleStagePeriode'])
            ->add('numeroPeriode',   ChoiceType::class, [
                'label'              => 'label.ordre_annee',
                'choices'            => [1 => 1, 2 => 2,3 => 3, 4 => 4,5 => 5, 6 => 6],
                'translation_domain' => 'form'
            ])

            ->add('semestre',EntityType::class, array(
                'class'         => Semestre::class,
                'label'         => 'label.semestre_stage_periode',
                'choice_label'  => 'libelle',
                'query_builder' => function(SemestreRepository $semestreRepository) {
                    return $semestreRepository->findByFormationBuilder($this->formation);
                },
                'required'      => true,
                'expanded'      => true,
                'multiple'      => false))
            //->add('responsables')
            ->add('anneeUniversitaire', ChoiceType::class, [
                'label'   => 'label.anneeUniversitaire',
                'choices' => array_combine(range(date('Y') - 1, date('Y') + 4), range(date('Y') - 1, date('Y') + 4))
            ])
            ->add('dateDebut', DateType::class, ['widget' => 'single_text', 'label' => 'label.date_debut'])
            ->add('dateFin', DateType::class, ['widget' => 'single_text', 'label' => 'label.date_debut'])
            ->add('nbSemaines', TextType::class, ['label' => 'label.nbSemaines', 'help' => 'help.nbSemaines'])
            ->add('nbJours', TextType::class, ['label' => 'label.nbJours', 'help' => 'help.nbJours'])
            ->add('datesFlexibles', YesNoType::class, ['label' => 'label.datesFlexibles', 'help' => 'help.datesFlexibles'])
            ->add('copieAssistant', YesNoType::class, ['label' => 'label.copieAssistant', 'help' => 'help.copieAssistant'])
            ->add('documentFile', VichFileType::class, [
                'required'       => true,
                'label'          => 'label.fichier',
                'download_label' => 'label.apercu',
                'allow_delete'   => true,
                'help' => 'help.ficheRenseignement'
            ])
            ->add('texteLibre',TextareaType::class, ['label' => 'label.texteLibre', 'help' => 'help.texteLibre'])
            ->add('competencesVisees',TextareaType::class, ['label' => 'label.competencesVisees', 'help' => 'help.competencesVisees'])
            ->add('modaliteEvaluation',TextareaType::class, ['label' => 'label.modaliteEvaluation', 'help' => 'help.modaliteEvaluation'])
            ->add('modaliteEvaluationPedagogique',TextareaType::class, ['label' => 'label.modaliteEvaluationPedagogique', 'help' => 'help.modaliteEvaluationPedagogique'])
            ->add('modaliteEncadrement',TextareaType::class, ['label' => 'label.modaliteEncadrement', 'help' => 'help.modaliteEncadrement'])
            ->add('documentRendre',TextareaType::class, ['label' => 'label.documentRendre', 'help' => 'help.documentRendre'])
            ->add('nbEcts', TextType::class, ['label' => 'label.nbEcts', 'help' => 'help.nbEcts'])



        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => StagePeriode::class,
            'formation'          => null,
            'translation_domain' => 'form'
        ]);
    }
}
