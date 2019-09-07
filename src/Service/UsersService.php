<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Role;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Response\ApiResponse;

class UsersService
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
        $this->em = $em;
        $this->encoder = $encoder;
    }

    public function create(Request $request)
    {
        $userRepo = $this->em->getRepository(User::class);
        $roleRepo = $this->em->getRepository(Role::class);

        $email = $request->get('email');
        $plainPassword = $request->get('password');
        $roles = $request->get('roles');

        if (!($email && $plainPassword && $roles)) {
            return ApiResponse::createErrorResponse(422, 'Zorunlu alanlar boş bırakılamaz', []);
        }

        $roleCollection = [];

        

        $user = new User();
        $encodedPassword = $this->encoder->encodePassword($user, $plainPassword);

        $user->setEmail($email);
        $user->setPassword($encodedPassword);

        foreach ($roles as $role) {
            $roleCollection[] = $roleRepo->find($role['id']);
        }

        $user->setRoles($roleCollection);

        $this->em->persist($user);
        $this->em->flush();

        return ApiResponse::createSuccessResponse([], 'Kullanıcı başarı ile oluşturuldu.');
    }

    public function delete($id)
    {
        $userRepo = $this->em->getRepository(User::class);

        $user = $userRepo->find($id);

        if (!$id) {
            return ApiResponse::createErrorResponse(422, 'Böyle bir kullanıcı bulunamadı', []);
        }

        $this->em->remove($user);
        $this->em->flush();
        
        return ApiResponse::createSuccessResponse([], 'Kullanıcı başarı ile silindi.');
    }

    public function getAll(Request $request)
    {
        $userRepo = $this->em->getRepository(User::class);

        $data = $userRepo->findAll();
        
        return $data;
    }
}