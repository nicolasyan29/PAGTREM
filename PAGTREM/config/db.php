<?php

$mysqli = new mysqli("localhost","root","root","login_db");
if($mysqli->connect_errno){
    die("Erro de conexão: " . $mysqli->connect_error);
}

?>