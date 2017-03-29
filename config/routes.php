<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});



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


$routes->get('/task/:id', function($id) {
    TaskController::show($id);
});

//2=edit
$routes->get('/task/:id/edit', function($id) {
    TaskController::edit($id);
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


