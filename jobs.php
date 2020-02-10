<?php

class Job {
    private $title;
    public $description;
    public $visible;
    public $months;
    
    public function setTitle($title) {
        $this->title = $title;
    }

    public function getTitle() {
        return $this->title;
    }

};

$job1 = new Job();
$job1->setTitle('JS Developer');
$job1->description= 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi sapiente sed pariatur sint exercitationem eos expedita eveniet veniam ullam, quia neque facilis dicta voluptatibus. Eveniet doloremque ipsum itaque obcaecati nihil.';
$job1->visible = true;
$job1->months = 3;

$job2 = new Job();
$job2->setTitle('React Develope');
$job2->description= 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi sapiente sed pariatur sint exercitationem eos expedita eveniet veniam ullam, quia neque facilis dicta voluptatibus. Eveniet doloremque ipsum itaque obcaecati nihil.';
$job2->visible = true;
$job2->months = 14;


$jobs = [
    $job1,
    $job2,

    // [
    //   'title' => 'JS Developer',
    //   'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi sapiente sed pariatur sint exercitationem eos expedita eveniet veniam ullam, quia neque facilis dicta voluptatibus. Eveniet doloremque ipsum itaque obcaecati nihil.',
    //   'visible' => true,
    //   'months' => 3,
    // ],
    // [
    //   'title' => 'React Developer',
    //   'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi sapiente sed pariatur sint exercitationem eos expedita eveniet veniam ullam, quia neque facilis dicta voluptatibus. Eveniet doloremque ipsum itaque obcaecati nihil.',
    //   'visible' => true,
    //   'months' => 4,
    // ],
    // [
    //   'title' => 'PHP Developer',
    //   'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi sapiente sed pariatur sint exercitationem eos expedita eveniet veniam ullam, quia neque facilis dicta voluptatibus. Eveniet doloremque ipsum itaque obcaecati nihil.',
    //   'visible' => false,
    //   'months' => 9,
    // ],
    // [
    //   'title' => 'React Router and Redux',
    //   'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi sapiente sed pariatur sint exercitationem eos expedita eveniet veniam ullam, quia neque facilis dicta voluptatibus. Eveniet doloremque ipsum itaque obcaecati nihil.',
    //   'visible' => true,
    //   'months' => 12,
    // ],
    // [
    //   'title' => 'Holistic UX Developer',
    //   'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi sapiente sed pariatur sint exercitationem eos expedita eveniet veniam ullam, quia neque facilis dicta voluptatibus. Eveniet doloremque ipsum itaque obcaecati nihil.',
    //   'visible' => true,
    //   'months' => 18,
    // ],
    // [
    //   'title' => 'UX Designer',
    //   'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi sapiente sed pariatur sint exercitationem eos expedita eveniet veniam ullam, quia neque facilis dicta voluptatibus. Eveniet doloremque ipsum itaque obcaecati nihil.',
    //   'visible' => false,
    //   'months' => 8,
    // ],
  ];

  function getDuration($months) {
    $ONE_YEAR = 12;
    $years = floor($months / $ONE_YEAR);
    $extraMonth = $months % $ONE_YEAR;
  
    if($months == 0) {
      return;
    }
    
    else if($years == 1 && $extraMonth <= 0) {
      return "$years año";
    }
    
    else if($years > 1 && $extraMonth <= 0) {
      return "$years años";
    }
    
    else if($months == 1) {
      return "$months mes";
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
    };
  
  };