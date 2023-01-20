<?php 
    class Task {
        public $desc;

        public function __construct($desc){
            echo "Called";
            $this->desc = $desc;
        }
        
    }

    $task = new Task('Go to class');
    echo $task->$desc;
    
?>