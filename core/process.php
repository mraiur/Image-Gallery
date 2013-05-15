<?php
$hasThumbDir = true;
$firstThumb = false;
$thumbDir = $albumPath . "thumbs/";

if( !is_dir($thumbDir ) )
{
    if( !mkdir($thumbDir, 0755) )
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
            if($generated>2) {
                header("Refresh: 15");
                die();
            }
            $generated++;
            echo '<div>image: '.$file.'</div>';

            $albumDescription[] = array(
                'file' => $file
            );
        }
    }
    ?>
        <div>new thumbs <?=$generated?></div>
        <script type="text/javascript">
        setTimeout(function(){
            window.close();
        }, 5000);
        </script>
    <?php
    saveAlbums($albumsId);
    saveAlbum($album['folder'], $albumDescription);
}
?>