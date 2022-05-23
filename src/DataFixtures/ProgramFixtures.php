<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

use App\Entity\Program;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public const PROGRAMS = [
        'program1' => [
            'Title' => 'Suits',
            'Synopsis' => 'Avocat très ambitieux d\'une grosse firme de Manhattan, Harvey Specter a besoin de quelqu\'un pour l\'épauler',
            'Category' => 'category_Aventure',
        ],
        'program2' => [
            'Title' => 'The Walking Dead',
            'Synopsis' => 'Les survivants de la première guerre mondiale se réunissent pour protéger la ville de Los Angeles',
            'Category' => 'category_Horreur',
        ],
        'program3' => [
            'Title' => 'The Big Bang Theory',
            'Synopsis' => 'Les amis de Leonard, Sheldon et Penny se réunissent pour découvrir le monde de la science-fiction',
            'Category' => 'category_Fantastique',
        ],
        'program4' => [
            'Title' => 'Breaking Bad',
            'Synopsis' => 'Le vieux voleur de drogue, Walter White, a été tué par un gang de Los Angeles',
            'Category' => 'category_Action',
        ],
        'program5' => [
            'Title' => 'The Simpsons',
            'Synopsis' => 'Les amis de Homer, Marge et Bart se réunissent pour découvrir le monde de la science-fiction',
            'Category' => 'category_Animation',
        ],
    ];
    
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        foreach (self::PROGRAMS as $programSpec)
        {
        $program = new Program();
        $program->setTitle($programSpec['Title']);
        $program->setSynopsis($programSpec['Synopsis']);
        $program->setCategory($this->getReference($programSpec['Category']));
        $manager->persist($program);
        }
    $manager->flush();
    }

    public function getDependencies()
    {
        return [CategoryFixtures::class,];
    }
}
