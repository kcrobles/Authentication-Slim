<?php

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use App\Controllers\Controller;
use App\Models\User;

class HomeController extends Controller {

    public function index(Request $request, Response $response){
        return $this->view->render($response, 'home.twig');
    }
}
