<?php

namespace App\Form;

use App\Document\Monster;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MonsterFormInterface extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('name', TextType::class, [
				'label' => 'Name',
				'required' => true,
			])
			->add('nameGeneric', TextType::class, [
				'label' => 'Generic Name',
				'required' => true,
			])
			->add('type', TextType::class, [
				'label' => 'Type',
				'required' => true,
			])
			->add('initiative', TextType::class, [
				'label' => 'Initiative',
				'required' => false,
			])
			->add('ac', TextType::class, [
				'label' => 'AC',
				'required' => true,
			])
			->add('hp', TextType::class, [
				'label' => 'HP',
				'required' => true,
			])
			->add('speed', TextType::class, [
				'label' => 'Speed',
				'required' => true,
			])
			->add('skills', TextType::class, [
				'label' => 'Skills',
				'required' => false,
			])
			->add('senses', TextType::class, [
				'label' => 'Senses',
				'required' => false,
			])
			->add('languages', TextType::class, [
				'label' => 'Languages',
				'required' => false,
			])
			->add('cr', TextType::class, [
				'label' => 'Challenge Rating',
				'required' => true,
			])
			->add('description', TextareaType::class, [
				'label' => 'Description',
				'required' => false,
				'attr' => ['rows' => 4],
			])
			->add('url', UrlType::class, [
				'label' => 'Reference URL',
				'required' => false,
			])
			->add('accepted', CheckboxType::class, [
				'label' => 'Accepted',
				'required' => false,
			])
			->add('actions', CollectionType::class, [
				'label' => 'Actions',
				'entry_type' => TextType::class,
				'allow_add' => true,
				'allow_delete' => true,
				'required' => false,
			])
			->add('reactions', CollectionType::class, [
				'label' => 'Reactions',
				'entry_type' => TextType::class,
				'allow_add' => true,
				'allow_delete' => true,
				'required' => false,
			]);
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			                       'data_class' => Monster::class,
		                       ]);
	}
}
