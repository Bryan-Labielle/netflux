<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    const SYNOPSIS = [
        'Des zombies envahissent la terre',
        'Des zombies envahissent la terre',
        'Des zombies envahissent la terre',
        'Des zombies envahissent la terre',
        'Des zombies envahissent la terre',
    ];
    public function load(ObjectManager $manager): void
    {
        // $program = new Program();
        // $program->setTitle('Walking dead');
        // $program->setSynopsis('Des zombies envahissent la terre');
        // $program->setCategory($this->getReference('category_Action'));
        // $manager->persist($program);
        // $manager->flush();

        foreach (SELF::SYNOPSIS as $synopsis){
            $program = new Program();
            $program->setSynopsis($synopsis);
            $program->setTitle('title');
            // ne boucle qu'une fois a chaque et s'arrete sur la premiére category
            foreach (CategoryFixtures::CATEGORIES as $category ){
                $program->setCategory($this->getReference('category_'. $category));
                $manager->persist($program);
            }
        };
        $manager->flush();

    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class
        ];
    }
}
