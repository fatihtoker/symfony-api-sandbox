<?php

namespace App\DataFixtures;

use App\Entity\Parameter;
use App\Entity\ParameterType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ParameterFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $paramTypeRepo = $manager->getRepository(ParameterType::class);
        $categoryParam = $paramTypeRepo->findOneBy(['name' => 'product_category']);
        for ($i = 0; $i < 5; $i++) {
            $category = new Parameter();
            $category->setName('category_' . $i);
            $category->setDisplayName('Kategori' . $i);
            $category->setParameterType($categoryParam);
            $manager->persist($category);

            $manager->flush();
        }
    }
}