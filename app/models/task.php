<?php

class Task extends BaseModel {

    public $id, $kategoria_id, $kayttaja_id, $nimi, $kuvaus, $lisays, $deadline;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_nimi','validate_kuvaus', 'validate_lisays','validate_deadline');
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
    

    public static function all() {
        
        $query = DB::connection()->prepare('SELECT * FROM Askare');
        $query->execute();
        $rows = $query->fetchAll();
        $tasks = array();

        foreach ($rows as $row) {
            $tasks[] = new Task(array(
                'id' => $row['id'],
                'kategoria_id' => $row['kategoria_id'],
                'kayttaja_id' => $row['kayttaja_id'],
                'nimi' => $row['nimi'],
                'kuvaus' => $row['kuvaus'],
                'lisays' => $row['lisays'],
                'deadline' => $row['deadline']
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
                'kategoria_id' => $row['kategoria_id'],
                'kayttaja_id' => $row['kayttaja_id'],
                'nimi' => $row['nimi'],
                'kuvaus' => $row['kuvaus'],
                'lisays' => $row['lisays'],
                'deadline' => $row['deadline']
            ));

            return $task;
        }

        return null;
    }

    public function save() {

        $query = DB::connection()->prepare('INSERT INTO Askare (nimi, lisays, deadline, kuvaus) VALUES (:nimi, :lisays, :deadline, :kuvaus) RETURNING id');
        $query->execute(array('nimi' => $this->nimi, 'lisays' => $this->lisays, 'deadline' => $this->deadline, 'kuvaus' => $this->kuvaus));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function update() {

        $query = DB::connection()->prepare('UPDATE Askare SET nimi = :nimi, lisays = :lisays, deadline = :deadline, kuvaus = :kuvaus WHERE id = :id');
        $query->execute(array('id' => $this->id,'nimi' => $this->nimi, 'lisays' => $this->lisays, 'deadline' => $this->deadline, 'kuvaus' => $this->kuvaus));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function destroy() {

        $query = DB::connection()->prepare('DELETE FROM Askare WHERE id = :id');
        $query->execute(array('id' => $this->id));
        $row = $query->fetch();
    }

}
