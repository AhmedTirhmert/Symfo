<?php

namespace App\Form;

use App\Entity\Team;
use App\Entity\League;
use App\Entity\Stadium;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TeamFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('shortName', TextType::class)
            ->add('league_id', EntityType::class, ['class' => League::class, 'choice_label' => 'name'])
            ->add('stadium_id', EntityType::class, ['class' => Stadium::class, 'choice_label' => 'name'])
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
        ]);
    }
}
