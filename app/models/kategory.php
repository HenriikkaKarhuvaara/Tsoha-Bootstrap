<?php

class Kategory extends BaseModel {

    public $id, $nimi, $kuvaus, $lisays, $kayttaja_id;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_nimi', 'validate_kuvaus', 'validate_lisays');
    }

    public function validate_nimi() {
        $errors = array();

        if ($this->nimi == '' || $this->nimi == null) {
            $errors[] = 'Muistithan syöttää kategoriallesi nimen!';
        }
        if (strlen($this->nimi) < 3) {
            $errors[] = 'Nimen minimipituus on  kolme merkkiä!';
        }

        return $errors;
    }

    public function validate_kuvaus() {
        $errors = array();
        if ($this->kuvaus == '' || $this->kuvaus == null) {
            $errors[] = 'Muistithan syöttää kategoriallesi kuvauksen!';
        }
        if (strlen($this->kuvaus) < 3) {
            $errors[] = 'Kuvauksen minimipituus on kolme merkkiä!';
        }

        return $errors;
    }

    public function validate_lisays() {
        $errors = array();
        if ($this->lisays == '' || $this->lisays == null) {
            $errors[] = 'Muistithan syöttää kategoriallesi lisäyspäivämäärän!';
        }
        if (!preg_match("/^[0-9]{1,2}\\.[0-9]{1,2}\\.[0-9]{4}$/", $this->lisays)) {
            $errors[] = 'Päivämäärän tulee olla muodossa dd.mm.yyyy!';
        }

        return $errors;
    }

    public static function all($kayttaja_id) {
        $query = DB::connection()->prepare('SELECT * FROM Kategoria WHERE kayttaja_id = :kayttaja_id');
        $query->execute(array('kayttaja_id' => $kayttaja_id));
        $rows = $query->fetchAll();
        $kategories = array();

        foreach ($rows as $row) {
            $kategories[] = new Kategory(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'kuvaus' => $row['kuvaus'],
                'lisays' => $row['lisays'],
                'kayttaja_id' => $row['kayttaja_id']
            ));
        }

        return $kategories;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Kategoria WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $kategory = new Kategory(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'kuvaus' => $row['kuvaus'],
                'lisays' => $row['lisays'],
                'kayttaja_id' => $row['kayttaja_id']
            ));

            return $kategory;
        }

        return null;
    }

    

    public function save() {

        $query = DB::connection()->prepare('INSERT INTO Kategoria (nimi, lisays, kuvaus, kayttaja_id) VALUES (:nimi, :lisays, :kuvaus, :kayttaja_id) RETURNING id');
        $query->execute(array('nimi' => $this->nimi, 'lisays' => $this->lisays, 'kuvaus' => $this->kuvaus, 'kayttaja_id' => $this->kayttaja_id));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function update() {

        $query = DB::connection()->prepare('UPDATE Kategoria SET nimi = :nimi, lisays = :lisays, deadline = :deadline, kuvaus = :kuvaus, kayttaja_id = :kayttaja_id WHERE id = :id');
        $query->execute(array('id' => $this->id, 'nimi' => $this->nimi, 'lisays' => $this->lisays, 'deadline' => $this->deadline, 'kuvaus' => $this->kuvaus, 'kayttaja_id' => $this->kayttaja_id));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function destroy() {

        $query = DB::connection()->prepare('DELETE FROM Kategoria WHERE id = :id');
        $query->execute(array('id' => $this->id));
        $row = $query->fetch();
    }

}
