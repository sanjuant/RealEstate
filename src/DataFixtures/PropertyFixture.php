<?php

namespace App\DataFixtures;

use App\Entity\Property;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class PropertyFixture extends Fixture
{
	/**
	 * @param ObjectManager $manager
	 * @throws \Exception
	 */
	public function load(ObjectManager $manager): void
	{
		$faker = Factory::create('fr_FR');
		for ($i = 0; $i < 100; $i++) {
			$property = new Property();
			$property->setTitle($faker->words(3, true))
					 ->setDescription($faker->text(400))
					 ->setSurface($faker->numberBetween(20, 320))
					 ->setRooms($faker->numberBetween(2, 10))
					 ->setBedrooms($faker->numberBetween(2, 10))
					 ->setFloor($faker->numberBetween(0, 15))
					 ->setHeat($faker->numberBetween(0, \count(Property::HEAT) - 1))
					 ->setPrice($faker->numberBetween(10000, 1000000))
					 ->setCity($faker->city)
					 ->setAddress($faker->address)
					 ->setPostalCode($faker->postcode)
					 ->setLat($faker->latitude)
					 ->setLng($faker->longitude)
					 ->setSold(false);
			$manager->persist($property);
		}
		$manager->flush();
	}
}
