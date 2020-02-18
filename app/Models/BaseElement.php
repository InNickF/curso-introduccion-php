<?php
namespace App\Models;
require_once 'Printable.php';

class BaseElement implements Printable {
    protected $title;
    public $id;
    public $description;
    public $visible = true;
    public $months;

    public function getDescription() {
      return $this->description;
    }

    public function __construct($title) {
        $this->setTitle($title);
    }
    
    public function setTitle($title) {
        if(is_string($title)) {
            if($title == '') {
                $this->title = 'N/A'; 
            } else {
            $this->title = $title;
            }
        } else {
           return trigger_error("El nombre del element con el ID: $this->id debe ser de tipo string");
        }
    }

    public function getTitle() {
        return $this->title;
    }

    function getDurationAsString() {
        $ONE_YEAR = 12;
        $years = floor($this->months / $ONE_YEAR);
        $extraMonth = $this->months % $ONE_YEAR;
      
        if($this->months == 0) {
          return;
        }
        
        else if($years == 1 && $extraMonth <= 0) {
          return "$years año";
        }
        
        else if($years > 1 && $extraMonth <= 0) {
          return "$years años";
        }
        
        else if($this->months == 1) {
          return $this->months . " mes";
        }
        
        else if($years < 1 && $extraMonth > 1) {
          return "$extraMonth meses";
        }
        
        else if($years == 1 && $extraMonth == 1) {
          return "$years año y $extraMonth mes";
        }
      
        else if($years == 1 && $extraMonth > 1) {
          return "$years año y $extraMonth meses";
        }
      
        else if($years > 1 && $extraMonth > 1) {
          return "$years años y $extraMonth meses";
        }
      
        else if($years > 1 && $extraMonth == 1) {
          return "$years años y $extraMonth mes";
        }
      
      }

};