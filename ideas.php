<?php
// Definición clase ideas
class Ideas {
    public $id;
    public $idea;

    // Constructor
    function __construct($idea, $id = null) {
        $this->id = $id;
        $this->idea = $idea;
    }

    // Método esLarga()
    public function esLarga(){
        return strlen($this->idea) > 20;
    }

    public static function all(){
        // Declaración ideas
        $idea1 = new Ideas('Estudiar PHP', 1);
        $idea2 = new Ideas('Aprender fundamentos de POO', 2);
        $idea3 = new Ideas('Cenar', 3);

        return [$idea1, $idea2, $idea3];
    }

    public static function find($id){
  
    foreach (self::all() as $idea) {
        if ($idea->id === $id) {
            return $idea;
            }
        }
        return null;
    }
}

// Recorremos las ideas
foreach (Ideas::all() as $idea) {

    echo "ID: ", $idea->id;
    echo "<br>";
    echo "Idea: ", $idea->idea;
    echo "<br>";

    if($idea->esLarga()) {
        echo "La idea es larga.";
    } else {
        echo "La idea no es larga.";
    }
    echo "<br><br>";    
}

echo "<br><br>";
var_dump(Ideas::find(2));
echo "<br>";
var_dump(Ideas::find(10));
echo "<br>";
var_dump(Ideas::find(2)->esLarga());