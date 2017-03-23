<?php

namespace App\Controllers\Auth;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use App\Controllers\Controller;
use App\Models\User;
use Respect\Validation\Validator as v;

class AuthController extends Controller {

    public function getSignUp(Request $request, Response $response)
    {
        return $this->view->render($response, 'auth/signup.twig');
    }

    public function postSignUp(Request $request, Response $response)
    {
        $validation = $this->validator->validate($request, [
            'email' => v::noWhiteSpace()->notEmpty()->email()->emailAvailable(),
            'firstName' => v::alpha()->length(3,20)->notEmpty(),
            'lastName' => v::alpha()->length(4,30)->notEmpty(),
            'password' => v::notEmpty()->length(6,12),
        ]);

        if($validation->failed())
        {
            return $response->withRedirect($this->router->pathFor('auth.signup'));
        }

        $user = [
            'firstName' => $request->getParam('firstName'),
            'lastName' => $request->getParam('lastName'),
            'email' => $request->getParam('email'),
            'password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT),
            'role' => 1
        ];

        return $response->withRedirect($this->router->pathFor('home'));
    }

    public function getSignIn(Request $request, Response $response)
    {
        return $this->view->render($response, 'auth/signin.twig');
    }

    public function postSignIn(Request $request, Response $response)
    {
        $validation = $this->validator->validate($request, [
            'email' => v::noWhiteSpace()->notEmpty()->email(),
            'password' => v::notEmpty()->length(6,12),
        ]);

        if($validation->failed())
        {
            return $response->withRedirect($this->router->pathFor('auth.signin'));
        }

        $auth = $this->auth->attempt(
            $request->getParam('email'), $request->getParam('password')
        );
        if(!$auth)
        {
            return $response->withRedirect($this->router->pathFor('auth.signin'));
        }
        return $response->withRedirect($this->router->pathFor('home'));
    }
}
