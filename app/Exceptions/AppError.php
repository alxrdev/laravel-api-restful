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

    public function __construct($message, $status = 400)
    {
        parent::__construct($message);

        $this->status = $status;
    }
}
