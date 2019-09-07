<?php

namespace App\Service;

use App\Entity\Role;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class RoleService
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
        $userRepo = $this->em->getRepository(Role::class);

        $data = $userRepo->findAll();
        
        return $data;
    }
}