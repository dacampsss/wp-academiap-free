<?php

$campo_1 = get_field('link_externo');
$campo_2 = get_field('territorio');

if (empty($campo_1)) {
    ?>
    <style>
        .producao-link-group {
            display: none !important;
        }
    </style>
    <?php
}

if (empty($campo_2)) {
    ?>
    <style>
        .producao-territorio-group {
            display: none !important;
        }
    </style>
    <?php
}
?>