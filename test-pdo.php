<?php
include_once "mypdo.class.php";

$db = new MyPDO();

$id = 1;

# Get one value 
$name = $db->get_var('SELECT firstname FROM admin WHERE id = ?',[$id]);
echo $name."<br>";

# Get one row
$data = $db->get_row('SELECT * FROM admin WHERE id = ?',[$id]);
var_dump($data);

# Get one or more rows
$data = $db->get_results('SELECT * FROM admin');
var_dump($data);
?>