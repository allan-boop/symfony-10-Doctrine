<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

use Faker\Factory;
use App\Entity\Episode;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for($i = 0; $i < 9; $i++) {
            for($k = 0; $k < 3; $k++) {
                for($j = 0; $j < 10; $j++) {
                    $episode = new Episode();
                    $episode->setTitle($faker->sentence($nbWords = 2, $variableNbWords = true));
                    $episode->setNumber($j);
                    $episode->setSynopsis($faker->paragraphs(10, true));
                    $episode->setSeason($this->getReference('program_' . $i . 'season_' . $k));
                    $manager->persist($episode);
                }
            }
        }
        $manager->flush();        
    }
    public function getDependencies(): array
    {
        return [SeasonFixtures::class];
    }    
}
