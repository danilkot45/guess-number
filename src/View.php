<?php

namespace danilkot45\guessNumber\View;

use function cli\line;
use function cli\prompt;
use function danilkot45\guessNumber\Model\showGame;
use function danilkot45\guessNumber\Model\replayGame;

function MenuGame()
{
    echo PHP_EOL;
    echo "****************************************************************" . PHP_EOL;
    echo "Главное меню:" . PHP_EOL;
    echo "--new или -n - Новая игра." . PHP_EOL;
    echo "--list или -l - Вывод списка всех сохраненных игр." . PHP_EOL;
    echo "--list win или -lw - Вывод списка всех игр, в которых победил человек." . PHP_EOL;
    echo "--list loose или -ls- Вывод списка всех игр, в которых человек проиграл." . PHP_EOL;
    echo "--top или -t- Вывод статистики по игрокам. Для каждого игрока нужно посчитать количество побед и проигрышей,
     список отсортировать по количеству побед (чемпионы располагаются вверху списка)." . PHP_EOL;
    echo "--replay id или -r id - Повтор игры с идентификатором id." . PHP_EOL;
    echo "--exit - Выход из игры." . PHP_EOL;
    echo PHP_EOL;
}

function greeting()
{
    global $user_name;

    echo 'Здравствуйте! Как вас зовут?' . PHP_EOL;

    $user_name = readline();

    if (!empty($user_name)) {
        echo 'Замечательно, ' . $user_name . '!' . PHP_EOL . 'Давайте сыграем в игру "Угадай число".'
            . ' Я загадываю число от 1 до ' . MAX_NUMBER .
            ' и вы должны отгадать число за ' . NUMBER_ATTEMPT . ' попытки.' . PHP_EOL;

        showGame($user_name);
    } else {
        greeting();
    }
}

function endGame($hidden_num, $attempt = false)
{
    global $user_name;

    if ($attempt) {
        echo 'Поздравляю! Вы выиграли игру за ' . $attempt . ' попытки.' . PHP_EOL;
        replayGame($user_name);
    } else {
        echo 'Вы проиграли. Я загадал число: ' . $hidden_num . PHP_EOL;
        replayGame($user_name);
    }
}

function outputGamesInfo($row)
{
    if ($row['game_outcome'] === '...') {
        $row['game_outcome'] = "not completed";
    }

    line("ID: {$row['id']} | Дата: {$row['game_data']} {$row['game_time']} | " .
        "Имя игрока: {$row['player_name']} | Максимальное число: {$row['max_number']} | " .
        "Сгенерированное число: {$row['generated_number']} | Исход: {$row['game_outcome']}");
}

function outputTurnInfo($row)
{
    line("----- Номер попытки: {$row['number_attempts']} | "
        . "предложенное число: {$row['proposed_number']} | "
        . "Ответ компьютера: {$row['computer_responds']}");
}

function outputGamesInfoTop($row)
{
    line(
        "Имя игрока: {$row['player_name']} | Кол-во побед: {$row['countWin']} |"
        . " Кол-во проигрышей: {$row['countLoss']}"
    );
}

function exitOrMenu()
{
    echo PHP_EOL . "(--exit - Выход из игры | --menu - Меню игры)" . PHP_EOL;

    $command = readline();

    if ($command === '--exit') {
        exit();
    } elseif ($command === '--menu') {
        MenuGame();
    } else {
        exitOrMenu();
    }
}
