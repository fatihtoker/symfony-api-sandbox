<?php

namespace App\Service;

use App\Entity\Menu;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class MenusService
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getAll(Request $request)
    {
        $menuRepo = $this->em->getRepository(Menu::class);

        $data = $menuRepo->findAll();
        
        return $data;
    }
}