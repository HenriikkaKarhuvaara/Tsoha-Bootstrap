<?php

class Task extends BaseModel {
    
    public $id, $kategoria_id, $kayttaja_id, $nimi, $kuvaus, $lisays, $deadline;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
       
    }
    
    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Askare');
        $query ->execute();
        $rows = $query->fetchAll();
        $tasks = array();
        
        foreach($rows as $row ) {
           $tasks[] = new  Task(array(
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
           
     public static function find($id){
    $query = DB::connection()->prepare('SELECT * FROM Task WHERE id = :id LIMIT 1');
    $query->execute(array('id' => $id));
    $row = $query->fetch();

    if($row){
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
}
    
            

