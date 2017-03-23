<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

// $app->get('/', function(Request $request, Response $response){
//
// });
$app->get('/', 'HomeController:index')->setName('home');
$app->get('/auth/signup', \App\Controllers\Auth\AuthController::class . ':getSignUp')->setName('auth.signup');
$app->post('/auth/signup', \App\Controllers\Auth\AuthController::class . ':postSignUp');
$app->get('/auth/signin', \App\Controllers\Auth\AuthController::class . ':getSignIn')->setName('auth.signin');
$app->post('/auth/signin', \App\Controllers\Auth\AuthController::class . ':postSignIn');
