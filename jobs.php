<?php

require_once('./app/Models/Job.php');
require_once('./app/Models/Project.php');

$job1 = new Job('JS Developer');
$job1->id = 1;
$job1->description= 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi sapiente sed pariatur sint exercitationem eos expedita eveniet veniam ullam, quia neque facilis dicta voluptatibus. Eveniet doloremque ipsum itaque obcaecati nihil.';
$job1->months = 3;

$job2 = new Job('React Develope');
$job2->id = 2;
$job2->description= 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi sapiente sed pariatur sint exercitationem eos expedita eveniet veniam ullam, quia neque facilis dicta voluptatibus. Eveniet doloremque ipsum itaque obcaecati nihil.';
$job2->months = 14;

$job3 = new Job('Node developer');
$job3->id = 3;
$job3->description= 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi sapiente sed pariatur sint exercitationem eos expedita eveniet veniam ullam, quia neque facilis dicta voluptatibus. Eveniet doloremque ipsum itaque obcaecati nihil.';
$job3->months = 6;


$project1 = new Project('Proyecto 1');
$project1->id = 1;

$jobs = [
    $job1,
    $job2,
    $job3,
];

$projects = [
  $project1,
];
