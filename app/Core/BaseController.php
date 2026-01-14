<?php

namespace Src\Core;

abstract class BaseController
{


    public function render(string $view)
    {
        require_once __DIR__ . '/../Views/' . $view . '.php';
    }
}