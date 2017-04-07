<?php

class KategoryController extends BaseController {

    public static function index() {
        self::check_logged_in();

        $kategories = Kategory::all();
        View::make('kategories/index.html', array('kategories' => $kategories));
    }

    public static function show($id) {
        self::check_logged_in();

        $kategory = Kategory::find($id);
        View::make('kategories/show.html', array('kategory' => $kategory));
    }

    public static function store() {
        $params = $_POST;

        $kategory = new Kategory(array(
            'nimi' => $params['nimi'],
            'lisays' => $params['lisays'],
            'kuvaus' => $params['kuvaus']
        ));

        $kategory->save();

        Redirect::to('/kategories/' . $kategory->id, array('message' => 'Kategoria on lisätty listaasi!'));
    }

    public static function create() {
        //Näytetään askareen lisäyslomake

        View::make('kategories/new.html');
    }

    public static function edit($id) {
        self::check_logged_in();

        $kategory = Kategory::find($id);
        View::make('kategories/edit.html', array('attributes' => $kategory));
    }

    public static function update($id) {
        $params = $_POST;

        $attributes = array(
            'id' => $id,
            'nimi' => $params['nimi'],
            'lisays' => $params['lisays'],
            'kuvaus' => $params['kuvaus']
        );

        $kategory = new Kategory($attributes);
        $errors = $kategory->errors();

        if (count($errors) > 0) {
            View::make('kategories/edit.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            $kategory->update();
            Redirect::to('/kategories/' . $kategory->id, array('message' => 'Kategoriaa on muokattu onnistuneest'));
        }
    }

    public static function destroy($id) {
        $kategory = new Kategory(array('id' => $id));
        $kategory->destroy();
        Redirect::to('/kategories/' . array('message' => 'Kategoria on poistettu onnistuneesti!'));
    }

}
