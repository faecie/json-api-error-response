<?php

declare(strict_types=1);

namespace Faecie\Bundle\JsonApiErrorsBundle\JsonApi;

class ErrorLinks
{
    private $about;

    public function __construct(?string $about = null)
    {
        $this->about = $about;
    }
}
