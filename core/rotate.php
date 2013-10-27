<?php
if(!defined("app")){
    header("Location: index.php");
}
$file['file'] = substr($file['file'], 0, strpos($file['file'], "?"));
$list = array(
    $path.'albums/'.$directory.'/'.$file['file'],
    $path.'albums/'.$directory.'/thumbs/'.$file['file']
);


foreach($image_sizes as $size => $sizeConfig ){
    if( file_exists($path.'albums/'.$directory.'/'.$size.'/'.$file['file']) ){
        array_push($list, $path.'albums/'.$directory.'/'.$size.'/'.$file['file']);
    }
}

foreach($list as $img_file ){

    $im = new imagick( $img_file );
    $im->rotateImage(new ImagickPixel('none'), ($direction==="left")?-90:90); 
    $im->writeImage( $img_file );
}
?>