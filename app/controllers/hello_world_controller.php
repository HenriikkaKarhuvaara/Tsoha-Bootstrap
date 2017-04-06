<?php

class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('home.html');
    }

    public static function sandbox() {

        $doom = new Task(array(
            'nimi' => 'henriikka',
            'kuvaus' => 'sakkd',
            'lisays' => '25.8.1994',
            'deadline' => '23.3.1999'
            
        ));
        $errors = $doom->errors();
        Kint::dump($errors);
    }

    public static function login() {
        View::make('suunnitelmat/login.html');
    }

    public static function task_list() {
        View::make('suunnitelmat/task_list.html');
    }

    public static function task_show() {
        View::make('suunnitelmat/task_show.html');
    }

    public static function task_change() {
        View::make('suunnitelmat/task_change.html');
    }

    public static function kategories_list() {
        View::make('suunnitelmat/kategories_list.html');
    }

    public static function kategories_show() {
        View::make('suunnitelmat/kategories_show.html');
    }

    public static function kategories_change() {
        View::make('suunnitelmat/kategories_change.html');
    }

}
