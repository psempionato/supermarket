<?php

namespace app\controllers;

class HomeController
{
    public function index()
    {
        include __DIR__ . '../../views/home.php';
    }
}