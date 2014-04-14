<?php
//http://gallery.mraiur.com/?view=4&process=true
if(!defined("app") || isLogged() === false){
    header("Location: index.php");
}
$hasThumbDir = true;
$firstThumb = false;
$thumbDir = $albumPath . "thumbs/";

if( !is_dir($thumbDir ) )
{
    if( mkdir($thumbDir, 0755) === false )
    {
        echo '<div>Cant create thumbs dir</div>';
        $hasThumbDir = false;
    }
}

$getStep = isset($_GET['step'])?intval($_GET['step']):null;
$getFileCoutner = isset($_GET['fileCounter'])?intval($_GET['fileCounter']):null;

if(!$getFile){
    $fileList = scandir($albumPath);

    foreach($fileList as $proccessFile) {
        $format = getFormat($proccessFile);
        if(!in_array($proccessFile, $exclude) && !file_exists($thumbDir.$proccessFile) && in_array(strtolower($format), $imageFormats)){
            $albumDescription[] = array(
                'maxSize' => $maxSize,
                'file' => $proccessFile
            );
            $fileCounter = count($albumDescription)-1;
            saveAlbums($albumsId);
            saveAlbum($album['folder'], $albumDescription);
            header("Location: ?view=".$getView.'&process=true&file='.$proccessFile.'&step=0&fileCounter='.$fileCounter.'&first=true');
            die();
        }
    }
} else if( $getFile && $getStep !== null ){

    if($getStep === 0) {
        $im = new imagick( $albumPath.$getFile );
        $im->cropThumbnailImage( 150, 150 );
        $im->writeImage(  $thumbDir.$getFile  );

        foreach( $albumsId as $cnt => $row ){
            if($row['id'] == $getView){
                $albumsId[$cnt]['thumb'] = $album['folder']."/thumbs/".$getFile;
            }
        }
        saveAlbums($albumsId);
        header("Refresh:1;url=?view=".$getView.'&process=true&file='.$getFile.'&step=1&fileCounter='.$getFileCoutner);
        echo "<div>Generate thumb</div>";
        die();
    } else if( $getStep <= max(array_keys($image_sizes)) ){
        
        $originalSize = getimagesize($albumPath.$getFile);

        $sizePath = $albumPath . $getStep ."/";

        if(!is_dir($sizePath) ) {
            if( mkdir($sizePath, 0755) === false ) {
                break;
            }
        }
        $sizeConfig = $image_sizes[$getStep];

        $maxSize = $albumDescription[$getFileCoutner]['maxSize'];

        if($originalSize[0] > $sizeConfig['width'] && $originalSize[1] > $sizeConfig['height']) {
            $resizeObj = new imagick( $albumPath.$getFile );
            $resizeObj->resizeImage( $sizeConfig['width'], $sizeConfig['height'], imagick::FILTER_LANCZOS, 1);
            $resizeObj->writeImage( $sizePath . $getFile );
            $maxSize = $getStep;
        }

        $albumDescription[$getFileCoutner]['maxSize'] = $maxSize;
        //saveAlbums($albumsId);
        saveAlbum($album['folder'], $albumDescription);

        header("Refresh:1;url=?view=".$getView.'&process=true&file='.$getFile.'&step='.($getStep+1).'&fileCounter='.$getFileCoutner);
        echo "<div>Generate size".str_repeat('.', $getStep)."</div>";
        die();
    } else {
        header("Location: ?view=".$getView.'&process=true');
        die();
    }
}
?>
<div>END</div>
<script type="text/javascript">
setTimeout(function(){
    window.close();
}, 5000);
</script>
<?php
die();
?>
