<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

use App\Entity\Program;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public const CATEGORY = [
        'Aventure',
        'Horreur',
        'Fantastique',
        'Action',
        'Animation',
    ];
    
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 10; $i++)
        {
        $program = new Program();
        $program->setTitle($faker->sentence($nbWords = 2, $variableNbWords = true));
        $program->setSynopsis($faker->paragraphs(1, true));
        $program->setCountry('France');
        $program->setYear(rand(2000, 2020));
        $program->setCategory($this->getReference('category_' . self::CATEGORY[rand(0, 4)]));
        $this->addReference('program_' . $i, $program);
        $manager->persist($program);
        }
    $manager->flush();
    }

    public function getDependencies()
    {
        return [CategoryFixtures::class];
    }
}
