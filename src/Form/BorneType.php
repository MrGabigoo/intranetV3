<?php

namespace App\Form;

use App\Entity\Borne;
use App\Entity\Semestre;
use App\Repository\SemestreRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BorneType extends AbstractType
{
    private $formation;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->formation = $options['formation'];


        $builder
            ->add('icone', TextType::class, [
                'label' => 'label.icone',
            ])
            ->add('couleur', TextType::class, [
                'label' => 'label.couleur',
            ])
            ->add('message', TextareaType::class, [
                'label' => 'label.message',
            ])
            ->add('url', TextType::class, [
                'label'    => 'label.url',
                'required' => false
            ])
            ->add('dateDebutPublication', DateTimeType::class, [
                'label' => 'label.dateDebutPublication',
            ])
            ->add('dateFinPublication', DateTimeType::class, [
                'label' => 'label.dateFinPublication',
            ])
            ->add('visible', ChoiceType::class,
                [
                    'choices'                   => ['choice.oui' => true, 'choice.non' => true],
                    'expanded'                  => true,
                    'choice_translation_domain' => 'form',
                    'label'                     => 'label.visible'
                ])
            ->add('semestres', EntityType::class, array(
                'class'         => Semestre::class,
                'label'         => 'label.semestres_date',
                'choice_label'  => 'libelle',
                'query_builder' => function (SemestreRepository $semestreRepository) {
                    return $semestreRepository->findByFormationBuilder($this->formation);
                },
                'required'      => true,
                'expanded'      => true,
                'multiple'      => true
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => Borne::class,
            'formation'          => null,
            'translation_domain' => 'form'
        ]);
    }
}