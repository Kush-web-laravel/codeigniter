<?php

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