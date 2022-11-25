<?php

namespace App\Form;

use App\Entity\Team;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('shortName')
            ->add('apiId')
            ->add('fifaApiId')
            ->add('team_api_id')
            ->add('team_fifa_id')
            ->add('team_long_name')
            ->add('team_short_name')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('league_id')
            ->add('stadium_id')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
        ]);
    }
}
