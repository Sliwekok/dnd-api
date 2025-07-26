<?php

namespace App\Form\Types;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MonsterAbilityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        foreach (['Str', 'Dex', 'Con', 'Int', 'Wis', 'Cha'] as $ability) {
            $builder->add($ability, AbilityScoreType::class, ['label' => $ability]);
        }
    }
}
