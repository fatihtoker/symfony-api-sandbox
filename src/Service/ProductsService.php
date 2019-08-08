<?php

namespace App\Service;

use App\Entity\Parameter;
use App\Entity\ParameterType;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class ProductsService
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var ProductRepository
     */
    private $repo;

    public function __construct(EntityManagerInterface $em, ProductRepository $repo)
    {
        $this->em = $em;
        $this->repo = $repo;
    }

    public function getAll(Request $request)
    {
        $productRepo = $this->em->getRepository(Product::class);
        $query = $request->get('query');
        if ($query) {
            return $this->repo->getSearchResults($query);
        }
        return $productRepo->findAll();
    }

    public function getAllByCategory()
    {
        $productRepo = $this->em->getRepository(Product::class);
        $paramRepo = $this->em->getRepository(Parameter::class);
        $paramTypeRepo = $this->em->getRepository(ParameterType::class);

        $categoryParam = $paramTypeRepo->findOneBy(['name' => 'product_category']);

        $categories = $paramRepo->findBy(['parameterType' => $categoryParam]);

        $data = [];

        foreach ($categories as $category) {
            $productsArr = $productRepo->findBy(['category' => $category]);
            $data[] = ['category' => $category->getDisplayName(), 'products' => $productsArr];
        }

        return $data;
    }
}