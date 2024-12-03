<?php

$arrayElementos = [];

for ($i = 0; $i < 10; $i++) {
    $arrayElementos[] = "Elemento $i";
}

?>
<ul>
    <?php foreach ($arrayElementos as $a) { ?>
        <li><?=$a?></li>
    <?php } ?>
</ul>
