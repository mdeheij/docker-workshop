<?php
/*
 *  Gelieve dit bestand niet te bewerken.
 */

if (!file_exists('/.dockerenv')) {
    die('Dit ding is alleen voor containers bedoeld. Het blaast dingen op enzo. Niet uitvoeren op je eigen machine');
}

echo "Hello world!!!!1111";

if (file_get_contents('/app/magisch.txt') !== "root de bouwer. Kunnen wij het maken? root de bouwer. Nou en of!\n") {
    echo "<h1>Ik mis m'n magie</h1> :( <pre>";
    echo file_get_contents('/app/magisch.txt');
    echo "</pre>";
    die("Het leven van een container is kort en tragisch.");
}

if (getenv('HELLO_MESSAGE') !== "wereldoverheersing") {
    //Als je me niet begroet met het juiste woord, vernietig ik de hele wereld. Da's niet erg, het zit toch in een container.
    shell_exec("rm -rf /app");
    die(str_rot13('<oe/><oe/><u1>“…ra rra vasnzr <f>Oenonaqre</f> <v>Pbagnvare mbaqre URYYB_ZRFFNTR</v> jbeqra? Qna yvrire qr yhpug va”.</u1> <u2>~Wna ina Fcrvwx</u2>'));
}

echo "<pre>".getenv('HELLO_MESSAGE')."</pre>";

echo "Ga door naar opdracht 2.";

?>
