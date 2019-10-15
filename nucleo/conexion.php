<?php

$servername="localhost";
$username="root";
$password="root";
$schema="secciones2";

$conn=new mysqli($servername, $username, $password, $schema);
if($conn -> connect_error){
	die($conn -> connect_error);
}