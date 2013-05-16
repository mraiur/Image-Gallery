<!doctype html> 
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?=$album['title']?></title>
        <script type="text/javascript" src="assets/js/view.js?v=1.0"></script>
        <link rel="stylesheet" href="assets/css/style.css?v=1.0">
        <link rel="stylesheet" href="assets/css/view.css?v=1.0">
    </head>
    <body onload="onViewLoad()">
        <div class="files">
            <a class="back" href="?">Back to albums</a>
        <?php
        foreach($albumDescription as $cnt => $file) {
            $src = $album['folder']."/thumbs/".$file['file'];
            $pic = $album['folder']."/".$file['file'];
            $title = $file['title'];
            ?>
            <div class="file" id="cnt-<?=$cnt?>" style="top: <?=(170*$cnt)+32?>px">
                <div class="view-small">
                    <a href="javascript:view('cnt-<?=$cnt?>')">
                        <img src="<?=$src?>" alt="<?=$title?>" border="0" />
                    </a>
                </div>
                <div class="view-big" id="cnt-<?=$cnt?>-big">
                    <div class="thumb">
                        <img picsrc="<?=$pic?>" alt="" border="0" class="img" />
                    </div>
                    <div class="title"><?=$title?></div>
                </div>
            </div>
            <?
        }
        ?>
        </div>
        <div id="view"></div>
    </body>
</html>