<?php

declare(strict_types=1);

namespace Faecie\Bundle\JsonApiErrorResponseBundle\JsonApi;

class ErrorLinks
{
    private $about;

    public function __construct(?string $about = null)
    {
        $this->about = $about;
    }
}
