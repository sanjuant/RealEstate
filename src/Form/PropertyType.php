<?php

namespace App\Form;

use App\Entity\Option;
use App\Entity\Property;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('title')
			->add('description')
			->add('surface')
			->add('rooms')
			->add('bedrooms')
			->add('floor')
			->add('price')
			->add('heat', ChoiceType::class, [
				'choices' => $this->getChoices()
			])
			->add('options', EntityType::class, [
				'class' => Option::class,
				'choice_label' => 'name',
				'multiple' => true,
				'required' => false
			])
			->add('pictureFiles', FileType::class, [
				'required' => false,
				'multiple' => true
			])
			->add('sold')
			->add('city')
			->add('address')
			->add('postal_code')
			->add('lat', HiddenType::class)
			->add('lng', HiddenType::class)
		;
	}

	private function getChoices(): array
	{
		return array_flip(Property::HEAT);
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => Property::class,
			'translation_domain' => 'forms'
		]);
	}
}
