<?php

namespace Teambuilder\controller;

use Teambuilder\core\service\Http;
use Teambuilder\core\controller\AbstractController;


class HomeController extends AbstractController
{
    public function index()
    {
        return Http::response('home/index');
    }
}
