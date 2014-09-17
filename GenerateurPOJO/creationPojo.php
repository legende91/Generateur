<?php


$connect = mysql_connect('localhost', 'root', '');
$dba = mysql_query("SHOW SCHEMAS");

//$dba =     mysql_query("SHOW DATABASES;");
$schema=array();
while (  $db_array = mysql_fetch_row($dba)){
$schema[]=$db_array;

}
