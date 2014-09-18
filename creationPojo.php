<?php
$db=false;
$path= false;
 try
{

        $db =  new PDO('mysql:host=localhost;','root', '');
        $path =$path;
                }
catch(Exception $e)
{
	// En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
        
}
$dbc= $db->query("SHOW SCHEMAS");


//$dba =     mysql_query("SHOW DATABASES;");
$schema=array();

while (  $db_array=$dbc->fetch(PDO::FETCH_NUM)){
    $schema[]=$db_array;
}
