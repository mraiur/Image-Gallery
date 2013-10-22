<?php
if(!defined("app")){
    header("Location: index.php");
}
$file['file'] = substr($file['file'], 0, strpos($file['file'], "?"));
$list = array(
    $path.$directory.'/'.$file['file'],
    $path.$directory.'/thumbs/'.$file['file']
);
foreach($list as $img_file ){

    $im = new imagick( $img_file );
    $im->rotateImage(new ImagickPixel('none'), ($direction==="left")?-90:90); 
    $im->writeImage( $img_file );
}
?>