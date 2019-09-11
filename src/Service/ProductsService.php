<?php

namespace App\Service;

use App\Entity\Parameter;
use App\Entity\ParameterType;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Response\ApiResponse;

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
        $paramRepo = $this->em->getRepository(Parameter::class);
        $query = $request->get('query');
        $type = $request->get('type');
        $data = [];
        if ($query) {
            $data = $productRepo->getSearchResults($query);
        } else if ($type) {
            $param = $paramRepo->findOneBy(['name' => $type]);
            $data = $productRepo->findBy(['type' => $param]);
        } else {
            $data = $productRepo->findAll();
        }
        return $data;
    }

    public function delete($id)
    {
        $productRepo = $this->em->getRepository(Product::class);

        $product = $productRepo->find($id);

        if (!$id) {
            return ApiResponse::createErrorResponse(422, 'Böyle bir ürün bulunamadı', []);
        }

        $this->em->remove($product);
        $this->em->flush();
        
        return ApiResponse::createSuccessResponse([], 'Ürün başarı ile silindi.');
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

    public function getCategories() {
        $paramRepo = $this->em->getRepository(Parameter::class);
        $paramTypeRepo = $this->em->getRepository(ParameterType::class);

        $categoryParam = $paramTypeRepo->findOneBy(['name' => 'product_category']);

        return $paramRepo->findBy(['parameterType' => $categoryParam]);
    }

    public function getTypes() {
        $paramRepo = $this->em->getRepository(Parameter::class);
        $paramTypeRepo = $this->em->getRepository(ParameterType::class);

        $categoryParam = $paramTypeRepo->findOneBy(['name' => 'product_type']);

        return $paramRepo->findBy(['parameterType' => $categoryParam]);
    }

    public function create(Request $request)
    {
        $productRepo = $this->em->getRepository(Product::class);
        $paramRepo = $this->em->getRepository(Parameter::class);

        $id = $request->get('id');
        $name = $request->get('name');
        $_category = $request->get('category');
        $description = $request->get('description');
        $onSale = $request->get('onSale');
        $price = $request->get('price');
        $_type = $request->get('type');
        $image = $request->files->get('image');

        if (!($name && $_category && $description && $onSale && $price && $image)) {
            return ApiResponse::createErrorResponse(422, 'Zorunlu alanlar boş bırakılamaz', []);
        }

        $category = $paramRepo->find($_category);
        $type = $paramRepo->find($_type);

        

        if ($id) {
            $product = $productRepo->find($id);
        } else {
            $product = new Product();
        }

        $product->setName($name);
        $product->setCategory($category);
        $product->setDescription($description);
        $product->setOnSale($onSale);
        $product->setPrice($price);
        $product->setType($type);
        $product->setImageFile($image);

        $this->em->persist($product);
        $this->em->flush();
        
        $response = $id ? 'Ürün başarı ile güncellendi.' : 'Ürün başarı ile oluşturuldu.';


        return ApiResponse::createSuccessResponse([], $response);
    }
}