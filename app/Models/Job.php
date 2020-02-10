<?php

require_once 'BaseElement.php';

class Job extends BaseElement {
    public function __construct($title) {
    $newTitle = "Job: " . $title;
    // We can do this because this atributte is protected not private
    // $this->title = $newTitle;
    parent::__construct($newTitle);
    }
    
    public function getDurationAsString() {
        $ONE_YEAR = 12;
        $years = floor($this->months / $ONE_YEAR);
        $extraMonth = $this->months % $ONE_YEAR;
      
        if($this->months == 0) {
          return;
        }
        
        else if($years == 1 && $extraMonth <= 0) {
          return "Duración de trabajo: $years año";
        }
        
        else if($years > 1 && $extraMonth <= 0) {
          return "Duración de trabajo: $years años";
        }
        
        else if($this->months == 1) {
          return $this->months . " mes";
        }
        
        else if($years < 1 && $extraMonth > 1) {
          return "Duración de trabajo: $extraMonth meses";
        }
        
        else if($years == 1 && $extraMonth == 1) {
          return "Duración de trabajo: $years año y $extraMonth mes";
        }
      
        else if($years == 1 && $extraMonth > 1) {
          return "Duración de trabajo: $years año y $extraMonth meses";
        }
      
        else if($years > 1 && $extraMonth > 1) {
          return "Duración de trabajo: $years años y $extraMonth meses";
        }
      
        else if($years > 1 && $extraMonth == 1) {
          return "Duración de trabajo: $years años y $extraMonth mes";
        }
      
      }
};