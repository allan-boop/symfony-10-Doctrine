<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;
use App\Entity\Actor;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    // $product = new Product();
    // $manager->persist($product);      
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $actor = new Actor();
            $actor->setName($faker->name());
            $actor->addProgram($this->getReference('program_' . $faker->numberBetween(0, 9)));
            $actor->addProgram($this->getReference('program_' . $faker->numberBetween(0, 9)));
            $actor->addProgram($this->getReference('program_' . $faker->numberBetween(0, 9)));
            $manager->persist($actor);
        }
        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [ProgramFixtures::class];
    }
}
