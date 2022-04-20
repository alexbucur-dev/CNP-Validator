<?php
function isCnpValid(string $value): bool{
    echo "CNP: ";
    fscanf(STDIN, "%d\n", $value);

    // dupa verificarea regulilor din pdf, am constatat:
    // cel mai mic CNP
    $cnp_min = 1000101010014;
    // cel mai mare CNP
    $cnp_max = 9991231529991;


    if ($value < $cnp_min ) {
        echo "CNP-ul este invalid. Nu se incadreaza in lungimea minima admisa\n";
        die(0);
    }elseif($value > $cnp_max){
        echo "CNP-ul este invalid. Nu se incadreaza in lungimea maxima admisa\n";
        die(0);
    }

    // CIFRA DE CONTROL
    $verificare = $value%10;
    $value = intval($value/10); 

    $numar_control=279146358279; 
    $sum = 0;
    $x = $value;
   
    for ($i=0;$i<12;$i++) {
        $sum += ($x%10) * ($numar_control%10);
        $x = intval($x/10);
        $numar_control = intval($numar_control/10);
    }

    $testare = $sum % 11;
    if ($testare===10)
        $testare=1;

    if ($testare!==$verificare) {
        echo "CNP-ul este invalid. Cifra de verificare incorecta. \n";
        die(0);
    }

    // NNN-ul
    $random= $value%1000;

    if ($random=== 0) {
        echo "CNP-ul este invalid. Cod alocat de judet (NNN) invalid.\n";
        die(0);
    }
    $value = intval($value/1000);

    // judet
    $jud = $value%100;

    if ($jud<1 || $jud >52) {
        echo "CNP-ul este invalid. Cod judet invalid.\n";
        die(0);
    }
    $value = intval($value/100);

    // data nasterii
    $zi_nastere = $value%100; $value = intval($value/100);
    $luna_nastere = $value%100; $value = intval($value/100);

    if ($luna_nastere<1 || $luna_nastere > 12) {
        echo "CNP-ul este invalid. Luna invalida.\n";
        die(0);
    }
    $an_nastere = $value%100; $value = intval($value/100);


    if ($value===0) {
        echo "CNP-ul este invalid. Sexul nu poate fi 0.\n";
        die(0);
    }

    $verificare_zile=array(
        1=>31,
        2=>($an_nastere%4 ? 28 : 29),
        3=>31,
        4=>30,
        5=>31,
        6=>30,
        7=>31,
        8=>31,
        9=>30,
        10=>31,
        11=>30,
        12=>31,
    );

    if ($zi_nastere > $verificare_zile[$luna_nastere] || $zi_nastere < 1) {
        echo "CNP-ul este invalid. Ziua este incorecta.\n";
        die(0);
    }

    echo "CNP valid\n"; die(0);
}
$value = 1981024046235;
isCnpValid($value);