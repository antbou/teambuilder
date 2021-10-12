<?php

namespace Teambuilder\controller;

use Teambuilder\controller\AbstractController;
use Teambuilder\core\Render;

class HomeController extends AbstractController
{
    public function index()
    {
        Render::render('home/index');
    }
}
