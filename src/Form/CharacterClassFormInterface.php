<?php

namespace App\Form;

use App\Document\CharacterClass;
use Symfony\Component\Form\AbstractType;
use Doctrine\Bundle\MongoDBBundle\Form\Type\DocumentType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CharacterClassFormInterface extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
        $choices = [
            'Strength' => 'strength',
            'Dexterity' => 'dexterity',
            'Constitution' => 'constitution',
            'Intelligence' => 'intelligence',
            'Wisdom' => 'wisdom',
            'Charisma' => 'charisma',
        ];

		$builder
			->add('name', TextType::class, [
				'label' => 'Name',
				'required' => true,
			])
			->add('description', TextareaType::class, [
				'label' => 'Description & Story',
				'required' => true,
				'attr' => [
					'rows' => 5
				]
			])
			->add('primaryAbility', ChoiceType::class, [
                'label' => 'Primary Ability',
                'required' => true,
                'expanded' => false,
                'multiple' => true,
                'attr' => [
                    'class' => 'select2',
                    'data-placeholder' => 'Select primary ability',
                ],
                'choices' => $choices,
            ])
            ->add('hitPointsDie', IntegerType::class, [
                'label' => 'Hit Points Die',
                'required' => true,
                'attr' => [
                    'min' => 0,
                    'max' => 20
                ],
            ])
            ->add('savingThrowProficiency', ChoiceType::class, [
                'label' => 'Saving throw Proficiencies',
                'required' => true,
                'expanded' => false,
                'multiple' => true,
                'attr' => [
                    'class' => 'select2',
                    'data-placeholder' => 'Select primary ability',
                ],
                'choices' => $choices,
            ])
            ->add('skillProficiencies', ChoiceType::class, [
                'label' => 'Skill Proficiencies',
                'required' => true,
                'expanded' => false,
                'multiple' => true,
                'attr' => [
                    'class' => 'select2',
                    'data-placeholder' => 'Select primary ability',
                    'data-max-selections' => 1,
                ],
                'choices' => $choices,
            ])

            ;
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			                       'data_class' => CharacterClass::class,
		                       ]);
	}
}
