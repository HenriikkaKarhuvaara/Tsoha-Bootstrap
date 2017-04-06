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



$routes->post('/task/:id/edit', function($id) {
    TaskController::update($id);
});

$routes->get('/task/:id/edit', function($id) {
    TaskController::edit($id);
});



$routes->post('/task/:id/destroy', function($id) {
    TaskController::destroy($id);
});

$routes->get('/task/:id/destroy', function($id) {
    TaskController::edit($id);
});


$routes->get('/task', function() {
   TaskController::index();
});

$routes->get('/task/:id', function($id) {
    TaskController::show($id);
});


$routes->get('/kategories', function() {
    KategoryController::index();
});

$routes->get('/kategories/:id', function($id) {
    KategoryController::show($id);
});

$routes->post('/kategories', function(){
  KategoryController::store();
});
// Pelin lisäyslomakkeen näyttäminen
$routes->get('/kategories/new', function(){
  KategoryController::create();
});




$routes->get('/login', function() {
    UserController::login();
});

$routes->post('/login', function(){
  UserController::handle_login();
});