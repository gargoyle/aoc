<?php

spl_autoload_register(function ($className) {
    $file = $className . '.php';
    if(file_exists($file)) {
        require_once $file;
    }
});

$loader = new DataLoader();

$callSequence = $loader->callSequence();
$cards = $loader->cards();

printf("Loaded %s caller values and %d cards\n",
        count($callSequence),
        count($cards));

$game = new Bingo($callSequence, $cards);
$game->play();