<?php
$colors = array();
$colors []= 'green';

$colors [] = 'yellow';

$colors [] = 'brown';

$colors []= 'blue';



$skc = count($colors);
$number = 10;



sort($colors);

if($number == $skc){
    $y=0;
    while ($y < 4){
    print "$colors[$y]<br>";
    $y++;
    }

} else {
    print "hi";
}

$cars = array();
$cars['red'] = 'big';
$cars['blue'] = 'midle';
$cars['green'] = 'small';
$cars[] = 'huge';

foreach ($cars as $y => $x){
    print "$x<br>";
    print "$y<br>";
}


?>