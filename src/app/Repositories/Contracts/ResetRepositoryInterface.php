<?php

namespace App\Repositories\Contracts;

interface ResetRepositoryInterface
{
    public function reset() : bool;

    public function create() : bool;

}