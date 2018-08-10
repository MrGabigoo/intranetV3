<?php

namespace App\Form;

use App\Entity\Constantes;
use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('civilite', ChoiceType::class, ['label' => 'label.civilite','choices' => [
                Constantes::CIVILITE_FEMME        => Constantes::CIVILITE_FEMME,
                Constantes::CIVILITE_HOMME => Constantes::CIVILITE_HOMME,

            ],])
            ->add('nom', TextType::class, ['label' => 'label.nom'])
            ->add('prenom', TextType::class, ['label' => 'label.prenom'])
            ->add('fonction', TextType::class, ['label' => 'label.fonction'])
            ->add('email', TextType::class, ['label' => 'label.email'])
            ->add('telephone', TextType::class, ['label' => 'label.telephone'])
            ->add('portable', TextType::class, ['label' => 'label.portable'])
            ->add('fax', TextType::class, ['label' => 'label.fax'])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
            'translation_domain' => 'form'
        ]);
    }
}
