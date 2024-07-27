<?php 
/**
 * @var $errno \huina\ErrorHandler
 * @var $errstr \huina\ErrorHandler
 * @var $errfile \huina\ErrorHandler
 * @var $errline \huina\ErrorHandler
 */
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server error</title>
</head>
<body>
    <h1>Произошла ошибка</h1>
    <p><b>Тип ошибки: </b><?=$errno ?></p>
    <p><b>Текст ошибка: </b><?=$errstr ?></p>
    <p><b>Файл в котором проищошла ошибки: </b><?=$errfile ?></p>
    <p><b>Строка в которой произошла ошибка: </b><?=$errline ?></p>
</body>
</html>