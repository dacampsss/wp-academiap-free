<?php

$campo_1 = get_field('datahorario_final');
$campo_2 = get_field('link_inscricao');
$tipoLocal = get_field('tipo_local');

if (empty($campo_1)) {
    ?>
    <style>
        .evento-datafinal-group {
            display: none !important;
        }
    </style>
    <?php
}

if (empty($campo_2)) {
    ?>
    <style>
        .evento-link-group {
            display: none !important;
        }
    </style>
    <?php
}

if ($tipoLocal == 'Digital') {
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelector('.event-location-row > div:last-child').innerText = 'evento virtual';
        });
    </script>
    <?php
}
?>