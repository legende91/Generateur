<?php
include_once 'CreationPojo.php';
include_once 'MesPojos.php';
include_once 'index2.php';


var_dump($_POST);
if (isset($_POST['DbName'],$_POST['Path'] )&& !empty($_POST['DbName']) && !empty($_POST['Path'])){
   new MesPojos($_POST['DbName'],$_POST['Path']);
}
?>

<form name="Select Base de donnée" action="" method="POST">
    <input type="text" name="Path" value="" />
    <select name="DbName">
        <?php foreach ($schema as $key => $value) :
            foreach ($value as $key2 => $value2) :
                ?>
                <option><?php echo $value2; ?></option>  
            <?php endforeach;
        endforeach;
        ?>
    </select>
    <input type="submit" value="envoyer" name="envoyer" />
</form>