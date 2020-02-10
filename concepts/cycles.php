<?php

$ex1 = [
	'keyStr1' => 'lado',
	0 => 'ledo',

	'keyStr2' => 'lido',
	1 => 'lodo',
    2 => 'ludo'
];
echo '<p>';
$i = 0;
foreach ($ex1 as $key) {
    if($i < (count($ex1) - 1)) {
        echo $key . ', ';
    } else {
        echo $key . '.';
    };

    $i++;
};

echo '<br><br>Decirlo al revés lo dudo.<br><br>';

$i = 0;
foreach (array_reverse($ex1) as $key) {
    if($i < (count($ex1) - 1)) {
        echo $key . ', ';
    } else {
        echo $key . '.';
    };

    $i++;
}

echo '<br><br>¡Qué trabajo me ha costado!';

echo '</p>';
?>

<?php

$ex2 = [
    'México' => [
        'Monterrey',
        'Querétaro',
        'Guadalajara'
    ],
    'Otro' => [
        'Monterrey',
        'Querétaro',
        'Guadalajara'
    ],
    'Otro2' => [
        'Monterrey',
        'Querétaro',
        'Guadalajara'
    ]
];

foreach ($ex2 as $key => $value) {
    echo '<p>';
    echo $key . ': ' . implode(', ', $value) . '<br>';
    echo '</p>';
};

?>

<?php

$ex3 = [23, 54, 32, 67, 34, 78, 98, 56, 21, 34, 57, 92, 12, 5, 61];
$asc = $ex3;
$des = $ex3;

sort($asc);
rsort($des);

echo '<p>Número del menor al mayor:<br>';
for ($i=0; $i < 3; $i++) { 
    echo $asc[$i] . '<br>';
};
echo '</p>';

echo '<p>Número del mayor al menor:<br>';
for ($i=0; $i < 3; $i++) { 
    echo $des[$i] . '<br>';
};
echo '</p>';
?>