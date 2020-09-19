<?php

namespace App\Exceptions;

use Exception;

class AppError extends Exception
{
    /**
     * The status code to use for the response.
     *
     * @var int
     */
    public $status = 400;

    /**
     * is a internal error.
     *
     * @var int
     */
    public $isInternal = false;

    public function __construct($message, $status = 400, $isInternal = false)
    {
        parent::__construct($message);

        $this->status = $status;
        $this->isInternal = $isInternal;
    }
}
