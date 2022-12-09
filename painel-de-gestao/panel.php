<?php
// Inicialize a sessão
session_start();
 
// Verifique se o usuário está logado, se não, redirecione-o para uma página de login
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="css/styles-panel.css">
    </head>

<header id="header">
    <a id="logo" href="">Logo</a>

    <nav id="nav">
        <button id="btn">Menu</button>
        <ul id="menu">
        <li><a href="/">Inicio</a><li>
        <li><a href="/">Cadastro</a><li>
        <li><a href="/">Bloquear IP na rede - Fastnetmon</a><li>
        <li><a href="/">Bloquear acesso ao Site - DNS</a><li>
        <li><a href="/">Gerador de Senha</a><li>
        <li><a href="reset-password.php">Redefina sua senhaSair</a><li>
        <li><a href="index.php">Sair</a><li>
    </ul>
    </header>
