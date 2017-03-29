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

        $task = new Task(array(
        'nimi' => $params['nimi'],
        'lisays' => $params['lisays'],
        'deadline' => $params['deadline'],
        'kuvaus' => $params['kuvaus']
      ));

        $task->save();
        
        Redirect::to('/task/' . $task->id, array('message' => 'Askare on lisätty listaasi!'));
    }
    
    public static function create() {
        //Näytetään askareen lisäyslomake
 
        View::make('task/new.html');
    }
    
    public static function edit($id) {
        $task = Task::find($id);
        View::make('task/edit.html',array('task' => $task));
    }

}
