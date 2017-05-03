<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TaskController extends BaseController {

    public static function index() {
        self::check_logged_in();

        $tasks = Task::allWithCategories(self::get_user_logged_in()->id);
        View::make('task/index.html', array('tasks' => $tasks));
    }

    //ei toimi!
    public static function show($id) {
        self::check_logged_in();
        $task = Task::find($id);
        $kategories = AskareenKategoria::findCategories($id);
        View::make('task/show.html', array('task' => $task, 'kategories' => $kategories));
    }

    public static function store() {
        self::check_logged_in();
        $params = $_POST;
        $kategoriat = $params['kategoriat'];
        
        $attributes = array(
            'nimi' => $params['nimi'],
            'kuvaus' => $params['kuvaus'],
            'lisays' => $params['lisays'],
            'deadline' => $params['deadline'],
            'kayttaja_id' => $params['kayttaja_id'],
            'kategoriat' => array()
        );
        
        if($kategoriat!=0){
            
        foreach ($kategoriat as $kategory) {
            
            $attributes['kategoriat'][]=$kategory;
        }}

        $task = new Task($attributes);
        $errors = $task->errors();

        if (count($errors) == 0) {
            $task->save();

            Redirect::to('/task/' . $task->id, array('message' => 'Askare on lisätty muistilistaasi!'));
        } else {
            View::make('task/new.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function create() {
        //Näytetään askareen lisäyslomake

        self::check_logged_in();
        $kategories = Kategory::all(self::get_user_logged_in()->id);
        View::make('task/new.html',array('kategories' => $kategories));
    }

    public static function edit($id) {
        self::check_logged_in();

        $task = Task::find($id);
        View::make('task/edit.html', array('attributes' => $task));
    }

    public static function update($id) {
        $params = $_POST;

        $attributes = array(
            'id' => $id,
            'nimi' => $params['nimi'],
            'lisays' => $params['lisays'],
            'deadline' => $params['deadline'],
            'kuvaus' => $params['kuvaus'],
            'kayttaja_id' => $params['kayttaja_id'],

        );




        $task = new Task($attributes);
        $errors = $task->errors();

        if (count($errors) > 0) {
            View::make('task/edit.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            $task->update();
            Redirect::to('/task/' . $task->id, array('message' => 'Askaretta on muokattu onnistuneesti'));
        }
    }

    public static function destroy($id) {
        self::check_logged_in();
        $task = new Task(array('id' => $id));
        $task->destroy();
        Redirect::to('/task', array('message' => 'Askare on poistettu onnistuneesti!'));
    }

}