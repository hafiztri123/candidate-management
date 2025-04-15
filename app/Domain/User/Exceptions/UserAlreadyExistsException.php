<?php

namespace App\Domain\User\Exceptions;

use App\Shared\Exceptions\DomainException;
use Illuminate\Http\Response;

class UserAlreadyExistsException extends DomainException
{
    public function __construct(
        protected ?string $userId = null,
        protected ?string $customMessage = null
    )
    {
        parent::__construct(
            'User',
            $userId,
            Response::HTTP_CONFLICT,
            $customMessage ?: $this->defaultMessage()
        );
    }

    private function defaultMessage()
    {
        $message = 'User';

        if($this->userId) {
            $message .= " with ID: $this->userId";
        }

        return $message .= ' already exists';


    }
}
