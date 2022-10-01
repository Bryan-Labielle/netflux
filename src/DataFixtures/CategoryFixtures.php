<?php
namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    const CATEGORIES = [
        'Action',
        'Aventure',
        'Animation',
        'Drame',
        'Fantastique',
        'Horreur',
    ];

    public function load(ObjectManager $manager)
    {
        // créer une fixture
        // $category = new Category;
        // $category->setName('Horreur');
        // $manager->persist($category);
        // $manager->flush();

        // //création 50 fixtures
        // for ($i = 0; $i <= 50; $i++){
        //     $category = new Category;
        //     $category->setName('Catégorie ' . $i);
        //     $manager->persist($category);
        //     //persist une catégorie a chaque itération
        // }
        // $manager->flush();
        // // flush necessaire qu'une seule fois 
            
        foreach(self::CATEGORIES as $categoryName){
            $category = new Category;
            $category->setName($categoryName);
            $manager->persist($category);
            $this->addReference('category_' . $categoryName, $category);
        }
        $manager->flush();
    }
}