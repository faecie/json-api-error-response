<?php

declare(strict_types=1);

namespace Faecie\Bundle\JsonApiErrorResponseBundle\ExceptionDescriber;

use Faecie\Bundle\JsonApiErrorResponseBundle\Enum\ErrorCodesEnum;
use Faecie\Bundle\JsonApiErrorResponseBundle\JsonApi\Error;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\Exception\AccountStatusException;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\AuthenticationExpiredException;
use Symfony\Component\Security\Core\Exception\AuthenticationServiceException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\CookieTheftException;
use Symfony\Component\Security\Core\Exception\CredentialsExpiredException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\DisabledException;
use Symfony\Component\Security\Core\Exception\InsufficientAuthenticationException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Exception\LockedException;
use Symfony\Component\Security\Core\Exception\ProviderNotFoundException;
use Symfony\Component\Security\Core\Exception\SessionUnavailableException;
use Symfony\Component\Security\Core\Exception\TokenNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class SymfonyExceptionDescriber extends PreconfiguredExceptionsDescriber
{
    public function __construct()
    {
        parent::__construct(
            [
                NotFoundHttpException::class =>
                    new Error(
                        ErrorCodesEnum::RESOURCE_NOT_FOUND,
                        null,
                        null,
                        Response::HTTP_NOT_FOUND
                    ),
                MethodNotAllowedException::class =>
                    new Error(
                        ErrorCodesEnum::RESOURCE_METHOD_NOT_ALLOWED,
                        null,
                        null,
                        Response::HTTP_METHOD_NOT_ALLOWED
                    ),
                BadRequestHttpException::class =>
                    new Error(
                        ErrorCodesEnum::VALIDATION,
                        null,
                        null,
                        Response::HTTP_BAD_REQUEST
                    ),
                AuthenticationCredentialsNotFoundException::class =>
                    new Error(
                        ErrorCodesEnum::AUTHORIZATION_CREDENTIALS_NOT_FOUND,
                        null,
                        null,
                        Response::HTTP_UNAUTHORIZED
                    ),
                BadCredentialsException::class =>
                    new Error(
                        ErrorCodesEnum::AUTHORIZATION_BAD_CREDENTIALS,
                        null,
                        null,
                        Response::HTTP_BAD_REQUEST
                    ),
                AuthenticationServiceException::class =>
                    new Error(
                        ErrorCodesEnum::TEMPORARY_UNAVAILABLE,
                        null,
                        null,
                        Response::HTTP_SERVICE_UNAVAILABLE
                    ),
                DisabledException::class =>
                    new Error(
                        ErrorCodesEnum::AUTHORIZATION_ACCESS_FORBIDDEN,
                        null,
                        null,
                        Response::HTTP_FORBIDDEN
                    ),
                CredentialsExpiredException::class =>
                    new Error(
                        ErrorCodesEnum::AUTHORIZATION_CREDENTIALS_EXPIRED,
                        null,
                        null,
                        Response::HTTP_UNAUTHORIZED
                    ),
                AccountExpiredException::class =>
                    new Error(
                        ErrorCodesEnum::AUTHORIZATION_CREDENTIALS_EXPIRED,
                        null,
                        null,
                        Response::HTTP_UNAUTHORIZED
                    ),
                AuthenticationExpiredException::class =>
                    new Error(
                        ErrorCodesEnum::AUTHORIZATION_CREDENTIALS_EXPIRED,
                        null,
                        null,
                        Response::HTTP_UNAUTHORIZED
                    ),
                InvalidCsrfTokenException::class =>
                    new Error(
                        ErrorCodesEnum::AUTHORIZATION_ACCESS_FORBIDDEN,
                        null,
                        null,
                        Response::HTTP_FORBIDDEN
                    ),
                UsernameNotFoundException::class =>
                    new Error(
                        ErrorCodesEnum::AUTHORIZATION_BAD_CREDENTIALS,
                        null,
                        null,
                        Response::HTTP_BAD_REQUEST
                    ),
                UnsupportedUserException::class =>
                    new Error(
                        ErrorCodesEnum::AUTHORIZATION_BAD_CREDENTIALS,
                        null,
                        null,
                        Response::HTTP_BAD_REQUEST
                    ),
                SessionUnavailableException::class =>
                    new Error(
                        ErrorCodesEnum::AUTHORIZATION_BAD_CREDENTIALS,
                        null,
                        null,
                        Response::HTTP_BAD_REQUEST
                    ),
                CustomUserMessageAuthenticationException::class =>
                    new Error(
                        ErrorCodesEnum::AUTHORIZATION_BAD_CREDENTIALS,
                        null,
                        null,
                        Response::HTTP_UNAUTHORIZED
                    ),
                ProviderNotFoundException::class =>
                    new Error(
                        ErrorCodesEnum::INTERNAL,
                        null,
                        null,
                        Response::HTTP_INTERNAL_SERVER_ERROR
                    ),
                TokenNotFoundException::class =>
                    new Error(
                        ErrorCodesEnum::AUTHORIZATION_CREDENTIALS_NOT_FOUND,
                        null,
                        null,
                        Response::HTTP_FORBIDDEN
                    ),
                CookieTheftException::class =>
                    new Error(
                        ErrorCodesEnum::AUTHORIZATION_CREDENTIALS_NOT_FOUND,
                        null,
                        null,
                        Response::HTTP_UNAUTHORIZED
                    ),
                InsufficientAuthenticationException::class =>
                    new Error(
                        ErrorCodesEnum::AUTHORIZATION_BAD_CREDENTIALS,
                        null,
                        null,
                        Response::HTTP_BAD_REQUEST
                    ),
                LockedException::class =>
                    new Error(
                        ErrorCodesEnum::AUTHORIZATION_ACCESS_FORBIDDEN,
                        null,
                        null,
                        Response::HTTP_FORBIDDEN
                    ),
                AccountStatusException::class =>
                    new Error(
                        ErrorCodesEnum::AUTHORIZATION_ACCESS_FORBIDDEN,
                        null,
                        null,
                        Response::HTTP_FORBIDDEN
                    ),
                AuthenticationException::class =>
                    new Error(
                        ErrorCodesEnum::AUTHORIZATION_CREDENTIALS_NOT_FOUND,
                        null,
                        null,
                        Response::HTTP_UNAUTHORIZED
                    ),
            ]
        );
    }
}
