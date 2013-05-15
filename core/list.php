<!doctype html> 
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Gallery</title>
        <link rel="stylesheet" href="assets/css/style.css?v=1.1">
        <link rel="stylesheet" href="assets/css/albums.css?v=1.1">
    </head>
    <body>
        <div class="list-albums">
        <?php
        foreach($albums as $album) {
            $title = $album['title'];
            $description = $album['description'];
            $thumb = ( isset($album['thumb']) && $album['thumb']!="" )?$album['thumb']:"assets/no-thumb.png";
            $link = "?view=".$album['id'];
            $processLink = "?view=".$album['id']."&process=true";
                ?>
                <div class="album">
                    <div class="thumb">
                        <a href="<?=$link?>">
                            <img src="<?=$thumb?>" alt="<?=$title?>" border="0" />
                        </a>
                    </div>
                    <div class="info">
                        <div class="title">
                            <a href="<?=$link?>"><?=$title?></a>
                        </div>
                        <div class="description">
                            <a href="<?=$link?>"><?=$description?></a>
                        </div>
                        <a href="<?=$processLink?>" target="_blank" class="processLink"></a>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>   
                </div>
                <?php
            //}
        }
        ?>
        </div>
    </body>
</html>