<?php

namespace App\Security;

use App\Controller\Api\ApiController;
use App\Entity\User;
use App\Response\ApiResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class TokenAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var ApiController
     */
    private $apiController;

    public function __construct(EntityManagerInterface $em, ApiController $apiController)
    {
        $this->em = $em;
        $this->apiController = $apiController;
    }

    /**
     * Called on every request to decide if this authenticator should be
     * used for the request. Returning false will cause this authenticator
     * to be skipped.
     */
    public function supports(Request $request)
    {
        return $request->headers->has('X-AUTH-TOKEN');
    }

    /**
     * Called on every request. Return whatever credentials you want to
     * be passed to getUser() as $credentials.
     */
    public function getCredentials(Request $request)
    {
        return [
            'token' => $request->headers->get('X-AUTH-TOKEN'),
        ];
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $apiToken = $credentials['token'];

        if (null === $apiToken) {
            return;
        }

        // if a User object, checkCredentials() is called
        return $this->em->getRepository(User::class)
            ->findOneBy(['apiToken' => $apiToken]);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        // check credentials - e.g. make sure the password is valid
        // no credential check is needed in this case

        // return true to cause authentication success
        return true;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // on success, let the request continue
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
            $message = strtr($exception->getMessageKey(), $exception->getMessageData());

            // or to translate this message
            // $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())

        return $this->apiController->createJsonResponse(ApiResponse::createErrorResponse(403, $message, null));
    }

    /**
     * Called when authentication is needed, but it's not sent
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        return $this->apiController->createJsonResponse(ApiResponse::createErrorResponse(401, 'Kullanıcı girişi gerekli.', null));
    }

    public function supportsRememberMe()
    {
        return false;
    }
}
