<?php

$loader = require_once  DOCROOT . 'vendor/autoload.php';
$loader->add('', DOCROOT . 'classes/');

setlocale(LC_TIME, 'Russian');

session_start();

$app = App::instance();


$app->post('/get', 'Http\Controllers\Suppliers:get_reviews');
$app->get('/login', 'Http\Controllers\Auth:login');
$app->get('/login_vk', 'Http\Controllers\Auth:vk');
$app->get('/{page}', 'Http\Controllers\Suppliers:get_Suppliers');
$app->get('/', 'Http\Controllers\Suppliers:get_Suppliers');


/*$app->group('/', function () {

	$this->get('', 'Http\Controllers\Orders:index');
	$this->map(['GET', 'POST'], 'create', 'Http\Controllers\Orders:create');
	$this->map(['GET', 'POST'], 'edit/{id}', 'Http\Controllers\Orders:edit');
	$this->get('delete/{id}', 'Http\Controllers\Orders:delete');

	$this->get('settings/status', 'Http\Controllers\Status:index');
	$this->map(['GET', 'POST'], 'settings/status/create', 'Http\Controllers\Status:create');
	$this->map(['GET', 'POST'], 'settings/status/edit/{id}', 'Http\Controllers\Status:edit');
	$this->get('settings/status/delete/{id}', 'Http\Controllers\Status:delete');

	$this->map(['GET', 'POST'], 'settings', 'Http\Controllers\Settings:index');

})->add( new Http\Middleware\Auth() );*/

return $app;