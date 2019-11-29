<?php
// stukje html



echo "

<html>
<head>

<title>Test webserver + PHP voor Yelena</title>
</head>
<body>


";

function YelenaSnaptDezeFunctie($naam){

    if ($naam == 'Yelena'){
        $functieBegrepen = 1;
    }

    else

    {
        $functieBegrepen = 0;
    }

    return $functieBegrepen;

}

function genereerQuote(){
    $pvbeschrijving = array('lief','leuk','gemeen','boos','kwaadaardig','slim','eigenwijs','naief','dom','geleerd');
    $tijdbeschrijving = array('nooit','zelden','soms','regelmatig','vaker','dikwijls','bijna altijd','altijd');


    $dobbelsteen1 = rand(0,5);
    $dobbelsteen2 = rand(0,5);
    $dobbelsteen3 = rand(0,5);

    return "<br><br>Wie " . $tijdbeschrijving[$dobbelsteen1] . " " . $pvbeschrijving[$dobbelsteen2] . " is, is " . $tijdbeschrijving[$dobbelsteen3] . " " . $pvbeschrijving[$dobbelsteen3] . ".";

}

// we bouwen een array waar we mee gaan werken
$opsomming = array('Peter','Lennard','Boaz','Yelena','Sander','Jorn');  // opdracht


// we kunnen elke waarde individueel doorlopen met een foreach loop
foreach($opsomming as $naam){  // herhalingstructuur

    echo "  <<< " . $naam . " >>>   ";
}

// maar we kunnen middels de offset er 1 waarde uitpikken (dit is het gedeelte waar $variabele[OFFSET] staat
$dobbelsteen = rand(0,5); // opdracht



// beslissingstructuur
$naam  = $opsomming[$dobbelsteen]; // opdracht

if(YelenaSnaptDezeFunctie($naam) == 1){
    $resultaat = "Yelena snapt deze functie wel";
}

if(YelenaSnaptDezeFunctie($naam) == 0){
    $resultaat = $naam . " snapt deze functie helemaal niet";
}

if(YelenaSnaptDezeFunctie($naam) == 0 AND $naam == 'Sander'){
    $resultaat = $naam . " kan goed uitleggen.";
}

echo "<br>" . $resultaat;

if(isset($_GET['print'])){ // isset controleert of er iets is ingevuld

    $tekst  = $_GET['print'];

    echo " " . $tekst;

}

echo genereerQuote();

echo "

</body>
</html>


";