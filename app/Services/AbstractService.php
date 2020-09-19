<?php

namespace App\Services;

use App\Dtos\IDto;
use App\Exceptions\AppError;

abstract class AbstractService implements IService
{
    /**
     * Checks the dto class
     * 
     * @param  string   $needed
     * @param  IDto     $current
     * @throws AppError
     */
    public function isTheCorrectDto(string $needed, IDto $current) : void
    {
        if (!$current instanceof $needed) {
            throw new AppError('Invalid dto class.', 500, true);
        }
    }
}
