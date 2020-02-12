<?php

require_once 'vendor/autoload.php';
use App\Models\{Job, Project};
// use App\Models\Project;


$project1 = new Project('Proyecto 1');
$project1->id = 1;

$jobs = Job::All();

$projects = [
  $project1,
];
