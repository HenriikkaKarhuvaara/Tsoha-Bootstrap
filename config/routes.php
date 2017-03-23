<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/task', function() {
    HelloWorldController::task_list();
});
$routes->get('/task/1', function() {
    HelloWorldController::task_show();
});

$routes->get('/task/2', function() {
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
