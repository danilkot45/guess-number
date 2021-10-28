<?php

namespace danilkot45\guessNumber\Controller;

use function danilkot45\guessNumber\View\greeting;
use function danilkot45\guessNumber\Model\setting;
use function danilkot45\guessNumber\DataBase\openDatabase;
use function danilkot45\guessNumber\View\MenuGame;
use function danilkot45\guessNumber\Model\showGame;
use function danilkot45\guessNumber\DataBase\outputListGame;
use function danilkot45\guessNumber\DataBase\outputListGameTop;
use function danilkot45\guessNumber\DataBase\checkGameid;

function startGame($argv)
{
    setting();
    openDatabase();

    if (count($argv) <= 1 || $argv[1] === "--new" || $argv[1] === "-n") {
            greeting();
    } elseif ($argv[1] === "--list" || $argv[1] === "-l") {
            outputListGame();
    } elseif ($argv[1] === "--list win" || $argv[1] === "-lw") {
            outputListGame("win");
    } elseif ($argv[1] === "--list loose" || $argv[1] === "-ls") {
            outputListGame("loss");
    } elseif ($argv[1] === "--top" || $argv[1] === "-t") {
            outputListGameTop();
    } elseif ($argv[1] === "--replay" || $argv[1] === "-r") {
        if (array_key_exists(2, $argv)) {
                $id = $argv[2];
                unset($temp);
                $checkId = checkGameid($id);
            if ($checkId) {
                    showGame($checkId);
            } else {
                    \cli\line("Такой игры не существует");
            }
        }
    } elseif ($argv[1] === "--help" || $argv[1] === "-h") {
            MenuGame();
    } else {
            \cli\line("Неверный ключ!");
    }
}
