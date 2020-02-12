<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Job extends Model {
  protected $table = 'jobs';
  // public $title;
  public $id;
  // public $description;
  public $visible = true;
  public $months;

  public function getDescription() {
    return $this->description;
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

    public function printElement($element) {
      if($element->visible == false) {
        return;
      };
    
      echo "
      <li class=\"work-position\">
      <h5>" . $element->title . "</h5>
      <small>" . $this->getDurationAsString() . "</small>
      <p>" . $element->description . "</p>
    
      <strong>Achievements:</strong>
      <ul>
        <li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>
        <li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>
        <li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>
      </ul>
    </li>
      ";
    }

};