<?php
session_start();
if(!isset($_SESSION['logged'])){
    $_SESSION['logged'] = false;
}
define("app", true);

$exclude = array('.', '..', 'core', 'assets', 'thumbs', 'index.php');
$path = dirname(__FILE__) . '/';
$imageFormats = array('jpeg', 'jpg', 'gif', 'png');

$albumPath = $path;
$view = false;
$process = false;
$album = false;

$getView = isset($_GET['view'])?strip_tags(trim($_GET['view'])):false;
$getProcess = isset($_GET['process'])?strip_tags(trim($_GET['process'])):false;
$rotate = isset($_GET['rotate'])?strip_tags(trim($_GET['rotate'])):false;
$direction = ( isset($_GET['direction']) && in_array($_GET['direction'], array('left', 'right')))?$_GET['direction']:'left';
$file = isset($_POST['file'])?$_POST['file']:null;
$directory = isset($_POST['directory'])?$_POST['directory']:null;

require_once $path.'core/functions.php';
require_once $path.'core/config.php';

$albums = readAlbumsXML();
$albumsId = albumsKeys($albums);

if(isset($_POST['username']) && isset($_POST['password'])){
    $username = trim(strip_tags($_POST['username']));
    $password = trim(strip_tags($_POST['password']));

    if(isset($users[$username]) && $users[$username]['password'] === md5($password)){
        
        $_SESSION['logged'] = true;
    }
}

if(isset($_POST['loggout'])){
    $_SESSION['logged'] = false;
}

if( $getView && isset($albumsId[$getView])) {
	$view = ".";
    $album = $albumsId[$getView];
	$albumPath .= 'albums/'.$album['folder']."/";

    $albumDescription = readAlbumXML($album['folder']);
    
	if($getProcess && $getProcess == true) {
		$process = true;
	}
}

if($rotate){
    require_once $path.'core/rotate.php';
}elseif($process){
	require_once $path.'core/process.php';
}elseif($view){
	require_once $path.'core/view.php';
}else{
	require_once $path.'core/list.php';
}
?>