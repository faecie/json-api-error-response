<?php

declare(strict_types=1);

namespace Faecie\Bundle\JsonApiErrorResponseBundle\Enum;

class ErrorCodesEnum
{
    public const RESOURCE_NOT_FOUND = 'resource.not_found';
    public const RESOURCE_METHOD_NOT_ALLOWED = 'resource.method_not_allowed';
    public const MALFORMED_REQUEST = 'request.malformed';
    public const INTERNAL = 'internal';
    public const VALIDATION = 'validation_error';
    public const TEMPORARY_UNAVAILABLE = 'service.temporary.unavailable';
    public const AUTHORIZATION_CREDENTIALS_NOT_FOUND = 'authorization.credentials_not_found';
    public const AUTHORIZATION_CREDENTIALS_EXPIRED = 'authorization.credentials_expired';
    public const AUTHORIZATION_BAD_CREDENTIALS = 'authorization.bad_credentials';
    public const AUTHORIZATION_ACCESS_FORBIDDEN = 'authorization.access_forbidden';
}
