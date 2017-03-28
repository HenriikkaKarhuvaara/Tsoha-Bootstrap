<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});



//$routes->get('/taask/:id', function($id) {
//    TaskController::show($id);
//});
//
//$routes->get('/taask/edit', function() {
//    TaskController::index();
//});

$routes->post('/task', function(){
  TaskController::store();
});
// Pelin lisäyslomakkeen näyttäminen
$routes->get('/task/new', function(){
  TaskController::create();
});


//lista
$routes->get('/task', function() {
   TaskController::index();
});

//tehdään 1= id
$routes->get('/task/1', function() {
    HelloWorldController::task_show();
});

//2=edit
$routes->get('/task/edit', function() {
    HelloWorldController::task_change();
});


$routes->get('/login', function() {
    HelloWorldController::login();
});

$routes->get('/kategories', function() {
    HelloWorldController::kategories_list();
});

$routes->get('/kategories/1', function() {
    HelloWorldController::kategories_show();
});

$routes->get('/kategories/2', function() {
    HelloWorldController::kategories_change();
});


