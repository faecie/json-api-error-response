<?php

declare(strict_types=1);

namespace Faecie\Bundle\JsonApiErrorsBundle\JsonApi;

class Error
{
    private $id;
    private $status;
    private $code;
    private $title;
    private $detail;
    private $meta;
    private $links;
    private $source;

    public function __construct(
        string $code,
        ?string $id = null,
        ?string $aboutLink = null,
        ?int $status = null,
        ?string $title = null,
        ?string $detail = null,
        ?string $sourcePointer = null,
        ?string $sourceParameter = null,
        $meta = null
    ) {
        $this->id = $id;
        $this->status = $status;
        $this->code = $code;
        $this->title = $title;
        $this->detail = $detail;
        $this->meta = $meta;
        $this->links = $aboutLink !== null ? new ErrorLinks($aboutLink) : null;
        $isThereAnySource = $sourcePointer !== null || $sourceParameter !== null;
        $this->source = $isThereAnySource ? new ErrorSource($sourcePointer, $sourceParameter) : null;
    }
}
