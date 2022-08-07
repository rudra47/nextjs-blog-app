<?php

namespace App\Interfaces;

interface AuthRepositoryInterface
{
    public function emailExistence($email);
    public function registrationStore($request);
}
