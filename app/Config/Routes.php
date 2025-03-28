<?php

use App\Controllers\Api\ProductController;
use CodeIgniter\Router\RouteCollection;
use App\Controllers\Api\StudentController;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/simple', 'SiteController::simple');
$routes->get('/about-us', 'SiteController::aboutUs');
$routes->get('/contact-us', 'SiteController::contactUs');

$routes->get('/simple-closure-route', function(){
   echo "<h1>This is a closure route</h1>";
   return view('simple-closure-file');
});

$routes->get('call-me/(:any)/(:num)', 'SiteController::callMe/$1/$2');

//Raw queries

$routes->get('/raw-insert', 'SiteController::insertRaw');
$routes->get('/raw-update', 'SiteController::updateRawQuery');
$routes->get('/get-data', 'SiteController::getData');
$routes->get('/get-data-2', 'SiteController::getData2');
$routes->get('/insert', 'SiteController::insertData2');
$routes->get('/update', 'SiteController::updateData2');
$routes->get('/get-data-3', 'SiteController::getData3');
$routes->get('/insert-data', 'SiteController::insertData3');
$routes->get('/update-data', 'SiteController::updateData3');
$routes->get('/get-data-4', 'SiteController::getData4');
// $routes->get('/my-form', 'SiteController::myForm');
$routes->match(['GET','POST'],'/my-form', 'SiteController::myForm');
$routes->get('/list-call', 'SiteController::listCall');
$routes->get('/user-data', 'SiteController::getUserData');
$routes->get('/user-session', 'SiteController::userSession');
$routes->match(['GET','POST'],'/my-file', 'SiteController::fileUpload');
$routes->match(['GET','POST'],'/my-form-data', 'SiteController::myFormData');
$routes->get('/ajax-method', 'SiteController::ajaxMethod');
$routes->post('/handle-myajax', 'SiteController::handleAjaxRequest');
$routes->get('/welcome-country', 'SiteController::welcomeCountryMessage', ['filter' => 'country_check']);
$routes->get('/access-denied', function(){
   echo "<h1>Access denied to this url</h1>";
});

$routes->group('api', ['namespace' => 'app\Controllers\Api'], function($routes){
   $routes->get('students', [StudentController::class, 'index']);
   $routes->post('create-student', [StudentController::class, 'create']);
   $routes->get('student/(:num)', [StudentController::class, 'show']);
   $routes->put('student/(:num)', [StudentController::class, 'update']);
   $routes->delete('student/(:num)', [StudentController::class, 'delete']);
});

$routes->group('api', ['namespace' => 'app\Controllers\Api', 'filter' => 'basic_auth'], function($routes){
   $routes->get('products', [ProductController::class, 'index']);
   $routes->post('create-product', [ProductController::class, 'create']);
   $routes->get('product/(:num)', [ProductController::class, 'show']);
   $routes->put('product/(:num)', [ProductController::class, 'update']);
   $routes->delete('product/(:num)', [ProductController::class, 'delete']);
});

$routes->post("/auth/register", "Api\AuthorController::registerAuthor");
$routes->post('/auth/login', "Api\AuthorController::loginAuthor");

$routes->group('author', ['namespace' => 'App\Controllers\Api', "filter" => 'jwt_auth'], function($routes){
   $routes->get('profile', 'AuthorController::authorProfile');
   $routes->get('logout', 'AuthorController::logoutAuthor');

   $routes->post('add-book', 'BookController::createBook');
   $routes->get('list-book', 'BookController::authorBooks');
   $routes->delete('delete-book/(:num)', 'BookController::deleteAuthorBook/$1');
});