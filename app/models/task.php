<?php

class Task extends BaseModel {

    public $id, $kayttaja_id, $nimi, $kuvaus, $lisays, $deadline, $kategoriat;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_nimi', 'validate_kuvaus', 'validate_lisays', 'validate_deadline');
    }

    public function validate_nimi() {
        $errors = array();

        if ($this->nimi == '' || $this->nimi == null) {
            $errors[] = 'Muistithan syöttää askareellesi nimen!';
        }
        if (strlen($this->nimi) < 3) {
            $errors[] = 'Nimen minimipituus on  kolme merkkiä!';
        }

        return $errors;
    }

    public function validate_kuvaus() {
        $errors = array();
        if ($this->kuvaus == '' || $this->kuvaus == null) {
            $errors[] = 'Muistithan syöttää askareellesi kuvauksen!';
        }
        if (strlen($this->kuvaus) < 3) {
            $errors[] = 'Kuvauksen minimipituus on kolme merkkiä!';
        }

        return $errors;
    }

    public function validate_lisays() {
        $errors = array();
        if ($this->lisays == '' || $this->lisays == null) {
            $errors[] = 'Muistithan syöttää askareellesi lisäyspäivämäärän!';
        }
        if (!preg_match("/^[0-9]{1,2}\\.[0-9]{1,2}\\.[0-9]{4}$/", $this->lisays)) {
            $errors[] = 'Päivämäärän tulee olla muodossa dd.mm.yyyy!';
        }

        return $errors;
    }

    public function validate_deadline() {
        $errors = array();
        if ($this->deadline == '' || $this->deadline == null) {
            $errors[] = 'Muistithan syöttää askareellesi deadlinen!';
        }
        if (!preg_match("/^[0-9]{1,2}\\.[0-9]{1,2}\\.[0-9]{4}$/", $this->deadline)) {
            $errors[] = 'Päivämäärän tulee olla muodossa dd.mm.yyyy!';
        }

        return $errors;
    }

    public static function all($kayttaja_id) {

        $query = DB::connection()->prepare('SELECT * FROM Askare WHERE kayttaja_id = :kayttaja_id');
        $query->execute(array('kayttaja_id' => $kayttaja_id));
        $rows = $query->fetchAll();
        $tasks = array();

        foreach ($rows as $row) {
            $tasks[] = new Task(array(
                'id' => $row['id'],
                'kayttaja_id' => $row['kayttaja_id'],
                'nimi' => $row['nimi'],
                'kuvaus' => $row['kuvaus'],
                'lisays' => $row['lisays'],
                'deadline' => $row['deadline'],
            ));
        }

        return $tasks;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Askare WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $task = new Task(array(
                'id' => $row['id'],
                'kayttaja_id' => $row['kayttaja_id'],
                'nimi' => $row['nimi'],
                'kuvaus' => $row['kuvaus'],
                'lisays' => $row['lisays'],
                'deadline' => $row['deadline'],
            ));

            return $task;
        }

        return null;
    }

    public static function allWithCategories($kayttaja_id) {

        $query = DB::connection()->prepare('SELECT * FROM Askare WHERE kayttaja_id = :kayttaja_id');
        $query->execute(array('kayttaja_id' => $kayttaja_id));
        $rows = $query->fetchAll();
        $tasks = array();

        foreach ($rows as $row) {
            $query = DB::connection()->prepare('SELECT Kategoria.nimi FROM Askare, AskareenKategoria, Kategoria'
                    . ' WHERE askare.id=:askare_id AND Askare.id=AskareenKategoria.askare_id AND AskareenKategoria.kategoria_id=Kategoria.id');
            $query->execute(array('askare_id' => $row['id']));
            $categories = array();
            $categories = $query->fetchAll();

            $tasks[] = new Task(array(
                'id' => $row['id'],
                'kayttaja_id' => $row['kayttaja_id'],
                'nimi' => $row['nimi'],
                'kuvaus' => $row['kuvaus'],
                'lisays' => $row['lisays'],
                'deadline' => $row['deadline'],
                'kategoriat' => $categories
            ));
        }
        
        return $tasks;
    }

    public function save() {

        $query = DB::connection()->prepare('INSERT INTO Askare (nimi, lisays, deadline, kuvaus, kayttaja_id) VALUES (:nimi, :lisays, :deadline, :kuvaus, :kayttaja_id) RETURNING id');
        $query->execute(array('nimi' => $this->nimi, 'lisays' => $this->lisays, 'deadline' => $this->deadline, 'kuvaus' => $this->kuvaus, 'kayttaja_id' => $this->kayttaja_id));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function update() {

        $query = DB::connection()->prepare('UPDATE Askare SET nimi = :nimi, lisays = :lisays, deadline = :deadline, kuvaus = :kuvaus, kayttaja_id = :kayttaja_id WHERE id = :id');
        $query->execute(array('nimi' => $this->nimi, 'lisays' => $this->lisays, 'deadline' => $this->deadline, 'kuvaus' => $this->kuvaus, 'kayttaja_id' => $this->kayttaja_id));
        $row = $query->fetch();
    }

    public function destroy() {

        $query = DB::connection()->prepare('DELETE FROM Askare WHERE id = :id');
        $query->execute(array('id' => $this->id));
        $row = $query->fetch();


        Kint::dump($row);
    }

}
