<?php
$exclude = array('.', '..', 'core', 'assets', 'thumbs', 'index.php');
$path = dirname(__FILE__) . '/';
$imageFormats = array('jpeg', 'jpg', 'gif', 'png');

$albumPath = $path;
$view = false;
$process = false;
$album = false;

$getView = isset($_GET['view'])?strip_tags(trim($_GET['view'])):false;
$getProcess = isset($_GET['process'])?strip_tags(trim($_GET['process'])):false;

require_once 'core/functions.php';
$albums = readAlbumsXML();
$albumsId = albumsKeys($albums);


if( $getView && isset($albumsId[$getView])) {
	$view = ".";
    $album = $albumsId[$getView];
	$albumPath .= $album['folder']."/";

    $albumDescription = readAlbumXML($album['folder']);
    
	if($getProcess && $getProcess == true) {
		$process = true;
	}
}


if($process){
	require_once 'core/process.php';
}elseif($view){
	require_once 'core/view.php';
}else{
	require_once 'core/list.php';
}
?>