<?php
if(!defined("app")){
    header("Location: index.php");
}

$users = array(
    // username => array("password" => MD5(PASSWORD))
    "" => array("password" => "")
);
?>