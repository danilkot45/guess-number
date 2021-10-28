<?php

namespace danilkot45\guessNumber\Model;

use function danilkot45\guessNumber\View\endGame;
use function danilkot45\guessNumber\View\MenuGame;
use function danilkot45\guessNumber\DataBase\insertNewGame;
use function danilkot45\guessNumber\DataBase\addAttemptInDB;
use function danilkot45\guessNumber\DataBase\updateInfoGame;

function setting()
{
    define("MAX_NUMBER", 10);
    define("NUMBER_ATTEMPT", 3);
}

function showGame($user_name)
{
    $hidden_num = mt_rand(1, MAX_NUMBER);
    echo "Попробуйте угадать." . PHP_EOL;

    $attempt = 1;

    $idNewGame = insertNewGame($user_name, $hidden_num, MAX_NUMBER);

    while ($attempt <= NUMBER_ATTEMPT) {
        $get_num = readline();

        while (is_numeric($get_num) === false) {
            echo "Введено не число! " . PHP_EOL;
            $get_num = readline();
        }

        if ($get_num == $hidden_num) {
            addAttemptInDB($idNewGame, $get_num, "guessed", $attempt);
            updateInfoGame($idNewGame, "win");
            endGame($hidden_num, $attempt);
            break;
        }

        if ($get_num < $hidden_num) {
            echo 'Твое число слишком маленькое' . PHP_EOL;
            addAttemptInDB($idNewGame, $get_num, "number is small", $attempt);
        } elseif ($get_num > $hidden_num) {
            echo 'Твое число слишком большое' . PHP_EOL;
            addAttemptInDB($idNewGame, $get_num, "number is large", $attempt);
        }

        $attempt++;
    }

    if ($attempt > NUMBER_ATTEMPT) {
        updateInfoGame($idNewGame, "loss");
        endGame($hidden_num);
    }
}

function replayGame($user_name)
{
    echo $user_name . ', попробуем еще раз? (y ="Да" / n = "Нет")' . PHP_EOL;
    echo 'Хотите закончить? (--exit - Выход из игры | --menu - Меню игры)' . PHP_EOL;
    $replay_game = readline();

    if ($replay_game === 'y' || $replay_game === 'Y') {
        showGame($user_name);
    } elseif ($replay_game === 'n' || $replay_game === 'N') {
        echo 'Эх,жалко ' . $user_name . '. До свидания!' . PHP_EOL;
    } elseif ($replay_game === '--exit') {
        exit();
    } elseif ($replay_game === '--menu') {
        MenuGame();
    } else {
        replayGame($user_name);
    }
}
