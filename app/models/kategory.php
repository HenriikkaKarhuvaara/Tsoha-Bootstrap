<?php

class Kategory extends BaseModel {

    public $id, $nimi, $kuvaus, $lisays;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Kategoria');
        $query->execute();
        $rows = $query->fetchAll();
        $kategory = array();

        foreach ($rows as $row) {
            $kategories[] = new Kategory(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'kuvaus' => $row['kuvaus'],
                'lisays' => $row['lisays'],
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
            ));

            return $kategory;
        }

        return null;
    }

    public function save() {

        $query = DB::connection()->prepare('INSERT INTO Kategory (nimi, lisays, kuvaus) VALUES (:nimi, :lisays, :kuvaus) RETURNING id');
        $query->execute(array('nimi' => $this->nimi, 'lisays' => $this->lisays, 'kuvaus' => $this->kuvaus));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

}
