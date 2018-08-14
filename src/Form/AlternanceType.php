<?php

namespace App\Form;

use App\Entity\Alternance;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AlternanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('created')
            ->add('updated')
            ->add('anneeUniversitaire')
            ->add('typeContrat')
            ->add('entreprise')
            ->add('tuteur')
            ->add('etudiant')
            ->add('tuteurUniversitaire')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Alternance::class,
        ]);
    }
}
