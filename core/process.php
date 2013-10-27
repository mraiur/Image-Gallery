<?php
if(!defined("app")){
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

if($hasThumbDir) {
    $generated = 0;
    $fileList = scandir($albumPath);
    
    foreach($fileList as $file) {
        $format = getFormat($file);

        if(!in_array($file, $exclude) && !file_exists($thumbDir.$file) && in_array(strtolower($format), $imageFormats)){
            if(!$firstThumb){
                $firstThumb = $album['folder'].'/thumbs/'.$file;
                $albumsId[$getView]['thumb'] = $firstThumb;
            }
            $im = new imagick( $albumPath.$file );
            $im->cropThumbnailImage( 150, 150 );
            $im->writeImage(  $thumbDir.$file  );

            $originalSize = getimagesize($albumPath.$file);
            $maxSize = 0;

            foreach($image_sizes as $size => $sizeConfig ){
                $sizePath = $albumPath . $size ."/";

                if(!is_dir($sizePath) ) {
                    if( mkdir($sizePath, 0755) === false ) {
                        break;
                    }
                }

                if($originalSize[0] > $sizeConfig['width'] && $originalSize[1] > $sizeConfig['height']) {
                    $resizeObj = new imagick( $albumPath.$file );
                    $resizeObj->resizeImage( $sizeConfig['width'], $sizeConfig['height'], imagick::FILTER_LANCZOS, 1);
                    $resizeObj->writeImage( $sizePath . $file );
                    $maxSize = $size;
                } else {

                }
            }

            $albumDescription[] = array(
                'maxSize' => $maxSize,
                'file' => $file
            );
            saveAlbums($albumsId);
            saveAlbum($album['folder'], $albumDescription);
            header("Refresh: 2");
            echo "<div>generate...</div>";
            die();
        }
    }

    if($generated === 0) {
    ?>
        <div>Finished</div>
        <script type="text/javascript">
        setTimeout(function(){
            //window.close();
        }, 5000);
        </script>
    <?php
    }
}
?>