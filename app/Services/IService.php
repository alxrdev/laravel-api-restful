<?php

namespace App\Services;

use App\Dtos\IDto;

interface IService
{
    public function execute(IDto $dto);
}
