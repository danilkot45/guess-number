<?php

namespace danilkot45\guessNumber\Controller;

use function danilkot45\guessNumber\Model\setting;
use function danilkot45\guessNumber\View\MenuGame;
use function danilkot45\guessNumber\DataBase\openDatabase;

function startGame()
{
    setting();
    openDatabase();
    MenuGame();
}
