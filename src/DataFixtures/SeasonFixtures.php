<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;
use App\Entity\Season;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 9; $i++) {
            for ($j = 0; $j < 3; $j++) {
                $season = new Season();                
                $season->setNumber($j);
                $season->setYear($faker->year());
                $season->setDescription($faker->paragraphs(3, true));
                $season->setProgram($this->getReference('program_' . $i));
                $this->addReference(
                    'program_' . $i . 'season_' . $j,
                    $season
                );
                $manager->persist($season);
            }
        }
        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [ProgramFixtures::class];
    }
}
