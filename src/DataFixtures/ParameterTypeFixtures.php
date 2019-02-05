<?php

namespace App\DataFixtures;

use App\Entity\ParameterType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ParameterTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $category = new ParameterType();
        $category->setName('product_category');
        $category->setDisplayName('Ürün Kategorileri');

        $manager->persist($category);

        $manager->flush();
    }
}