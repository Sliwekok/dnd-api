<?php

namespace App\Form;

use App\Document\Spell;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpellAddFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Spell Name',
                'required' => true,
            ])
            ->add('level', IntegerType::class, [
                'label' => 'Level',
                'required' => true,
                'attr' => [
                    'min' => 0,
                    'max' => 9
                ],
            ])
            ->add('school', ChoiceType::class, [
                'label' => 'School of Magic',
                'choices' => [
                    'Abjuration' => 'abjuration',
                    'Conjuration' => 'conjuration',
                    'Divination' => 'divination',
                    'Enchantment' => 'enchantment',
                    'Evocation' => 'evocation',
                    'Illusion' => 'illusion',
                    'Necromancy' => 'necromancy',
                    'Transmutation' => 'transmutation',
                ],
                'required' => true,
            ])
            ->add('actionType', ChoiceType::class, [
                'label' => 'Action Type',
                'choices' => [
                    'Action' => 'action',
                    'Bonus action' => 'bonus',
                    'Reaction' => 'reaction',
                    'Ritual' => 'ritual',
                    'Other (as described)' => 'other'
                ],
                'required' => true,
            ])
            ->add('concentration', CheckboxType::class, [
                'label' => 'Requires Concentration',
                'required' => false,
            ])
            ->add('ritual', CheckboxType::class, [
                'label' => 'Ritual Spell',
                'required' => false,
            ])
            ->add('range', TextType::class, [
                'label' => 'Range (in feet)',
                'required' => true,
            ])
            ->add('duration', TextType::class, [
                'label' => 'Duration',
                'required' => true,
            ])
            ->add('components', ChoiceType::class, [
                'label' => 'Components',
                'choices' => [
                    'Verbal (V)' => 'V',
                    'Somatic (S)' => 'S',
                    'Material (M)' => 'M',
                ],
                'expanded' => true,
                'multiple' => true,
                'required' => false,
                'attr' => [
                    'class' => 'inline-checkboxes'
                ],
            ])
	        ->add('componentMaterial', TextType::class, [
		        'label' => 'Component Material',
		        'required' => false,
		        'attr' => [
			        'placeholder' => 'e.g. a small piece of iron or a pinch of powdered iron',
			        'class' => 'componentMaterial'
		        ]
	        ])
            ->add('description', TextareaType::class, [
                'label' => 'Description & Effects',
                'required' => true,
                'attr' => [
                    'rows' => 5
                ]
            ])
            ->add('classes', ChoiceType::class, [
                'label' => 'Available To (Classes)',
                'choices' => [
                    'Artificer' => 'artificer',
                    'Bard' => 'bard',
                    'Cleric' => 'cleric',
                    'Druid' => 'druid',
                    'Paladin' => 'paladin',
                    'Ranger' => 'ranger',
                    'Sorcerer' => 'sorcerer',
                    'Warlock' => 'warlock',
                    'Wizard' => 'wizard',
                ],
                'expanded' => false,
                'multiple' => true,
                'required' => true,
                'attr' => [
                    'class' => 'select2'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
                                   'data_class' => Spell::class,
                               ]);
    }
}
