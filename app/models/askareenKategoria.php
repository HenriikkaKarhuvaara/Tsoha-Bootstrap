<?php

class AskareenKategoria extends BaseModel {

    public $askare_id, $kategoria_id;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM AskareenKategoria');
        $query->execute();
        $rows = $query->fetchAll();
        $askareenKategoriat = array();
        foreach ($rows as $row) {
            $askareenKategoriat[] = new AskareenKategoria(array(
                'askare_id' => $row['askare_id'],
                'kategoria_id' => $row['kategoria_id']
            ));
        }
        return $askareenKategoriat;
    }

    public static function find($askare_id) {
        $query = DB::connection()->prepare('SELECT * FROM AskareenKategoria WHERE askare_id = :askare_id');
        $query->execute(array('askare_id' => $askare_id));
        $rows = $query->fetchAll();
        if ($rows) {
            foreach ($rows as $row) {
                $askareenKategoriat[] = new AskareenKategoria(array(
                    'askare_id' => $row['askare_id'],
                    'kategoria_id' => $row['kategoria_id']
                ));
            }
            return $askareenKategoriat;
        }
        return null;
    }

    
    public static function findCategories($askare_id) {
        $query = DB::connection()->prepare('SELECT Kategoria.nimi AS nimi FROM AskareenKategoria, Kategoria WHERE  AskareenKategoria.askare_id = :askare_id AND AskareenKategoria.kategoria_id=Kategoria.id');
        $query->execute(array('askare_id' => $askare_id));
        $rows = $query->fetchAll();

        if ($rows) {
            return $rows;
        }
        return null;
    }
    
    public static function findTasks($kategoria_id) {
        $query = DB::connection()->prepare('SELECT Askare.nimi AS nimi FROM AskareenKategoria, Askare WHERE  AskareenKategoria.kategoria_id = :kategoria_id AND AskareenKategoria.askare_id=Askare.id');
        $query->execute(array('kategoria_id' => $kategoria_id));
        $rows = $query->fetchAll();

        if ($rows) {
            return $rows;
        }
        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO AskareenKategoria (askare_id, kategoria_id) VALUES (:askare_id, :kategoria_id)');
        $query->execute(array('askare_id' => $this->askare_id, 'kategoria_id' => $this->kategoria_id));
    }
    
    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM AskareenKategoria WHERE askare_id=:askare_id');
        $query->execute(array('askare_id' => $this->askare_id));

    }

    
}
