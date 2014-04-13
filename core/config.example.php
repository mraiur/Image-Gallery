<?php
if(!defined("app")){
    header("Location: index.php");
}

$image_sizes = array(
    1 => array('width' => 750, 'height' => 600), // small
    2 => array('width' => 1000, 'height' => 768), // medium
    3 => array('width' => 1550, 'height' => 1200) // large
);

$users = array(
    // username => array("password" => MD5(PASSWORD))
    "" => array("password" => "")
);
?>