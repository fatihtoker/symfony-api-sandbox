<?php

namespace App\DataFixtures;

use App\Entity\Parameter;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $paramRepo = $manager->getRepository(Parameter::class);
        for ($i = 0; $i < 20; $i++) {
            $categoryParam = $paramRepo->findOneBy(['name' => 'category_' . mt_rand(0, 4)]);
            $product = new Product();
            $product->setName('product '.$i);
            $product->setPrice(mt_rand(10, 100));
            $product->setOnSale(true);
            $product->setCategory($categoryParam);
            $product->setDescription('Suspicio? Bene ... tunc ibimus? Quis uh ... CONEXUS locus his diebus? Quisque semper aliquid videtur, in volutpat mauris. Nolo enim dicere. Vobis nequ');
            $manager->persist($product);
        }

        $manager->flush();
    }
}