<?php

namespace App\Shared\Exceptions;

use Exception;
use Illuminate\Http\Response;

class DomainException extends Exception
{
    public function __construct(
        protected string $resourceType,
        protected ?string $resourceId = null,
        protected int $HttpCode = Response::HTTP_INTERNAL_SERVER_ERROR,
        protected ?string $customMessage = null,
        protected array $errors = []
    )
    {

        parent::__construct(
            $customMessage ?: $this->defaultMessage(),
            $HttpCode
        );
    }

    public function getResourceType()
    {
        return $this->resourceType;
    }

    public function getResourceId()
    {
        return $this->resourceId;
    }

    public function getHttpCode()
    {
        return $this->HttpCode;
    }

    public function getCustomMessage()
    {
        return $this->customMessage;

    }

    public function getErrors()
    {
        return [
            'resource_type' => $this->getResourceType(),
            'resource_id' => $this->getResourceId(),
            'errors' => $this->errors
        ];
    }


    private function defaultMessage()
    {
        return "An error has occured";
    }


}
