<?php
    $tituloPagina = "Práctica 04: Introducción a la Programación del Lado del Servidor</br>";   

    $persona1 = [
        'nombre' => 'Persona 1',
        'apellidos' => 'Apellido 1',
        'edad' => 32,
        'deportesPracticados' => ['Futbol', 'Tenis', 'Basquet']
    ];

    $persona2 = array(
        'nombre' => 'Persona2',
        'apellidos' => 'Apellido 2',
        'edad' => 30,
        'deportesPracticados' => array('Futbol Americano', 'Baseball')
    );

    $personas = [$persona1, $persona2];

    $deportesPersona1 = $persona1['deportesPracticados'];

    $persona3 = [
        'nombre' => 'Persona 3',
        'apellidos' => 'Apellido 3',
        'edad' => 32,
        'deportesPracticados' => ['Futbol Soccer', 'Tenis', 'Basquet']
    ];

    $personas[] = $persona3;

    require 'index.view.php';

