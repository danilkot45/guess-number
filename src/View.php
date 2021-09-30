<?php

namespace danilkot45\guessNumber\View;

use function danilkot45\guessNumber\Controller\showGame;
use function danilkot45\guessNumber\Controller\setting;
use function danilkot45\guessNumber\Controller\greeting;

function startGame()
{
    setting();
    greeting();
    showGame();
}
function showList()
{
    echo "Вывод списка всех сохраненных игр из БД SQLite3\n";
}

function showReplay()
{
    echo " Повтор всех ходов игры с идентификатором id\n";
}
function showTop()
{
    echo " Вывод статистики по игрокам из БД SQLite3\n";
}
