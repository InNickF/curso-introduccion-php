<?php

use App\Models\Job;

// var_dump($_GET);
// var_dump($_POST);
if(!empty($_POST)) {
    $job = new Job();
    $job->title = $_POST['title'];
    $job->description = $_POST['description'];
    $job->save();
};
// var_dump($_POST);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Job</title>
</head>
<body>
    <h1>Add Job</h1>
    <form action="addjob.php" method="post">
    <label>
        Title
    </label><br>
    <input name="title" type="text"><br>
    <label>
        Description
    </label><br>
    <input name="description" type="text"><br>
    <button type="submit">Send</button>
    </form>
</body>
</html>