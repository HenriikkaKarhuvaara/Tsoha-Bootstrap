<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TaskController extends BaseController {

    public static function index() {
        $tasks = Task::all();
        View::make('task/index.html', array('tasks' => $tasks));
    }

    //ei toimi!
    public static function show($id) {
        $task = Task::find($id);
        View::make('task/show.html', array('task' => $task));
    }

    public static function store() {
        $params = $_POST;
        $attributes = array(
            'nimi' => $params['nimi'],
            'kuvaus' => $params['kuvaus'],
            'lisays' => $params['lisays'],
            'deadline' => $params['deadline']
        );

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

        View::make('task/new.html');
    }

    public static function edit($id) {
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
            'kuvaus' => $params['kuvaus']
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
        $task = new Task(array('id' => $id));
        $task->destroy();
        Redirect::to('/task', array('message' => 'Askare on poistettu onnistuneesti!'));
    }

}
