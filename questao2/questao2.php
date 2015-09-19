<?php

/*
* Questão 2
*    2. Refatore o código abaixo, fazendo as alterações que julgar necessário.
*    Abaixo o codigo refatorado
*/

if (isset($_SESSION['loggedin']) || isset($_COOKIE['Loggedin'])) {
    header("Location: http://www.google.com");
    exit();
} 