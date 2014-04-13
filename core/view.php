<!doctype html> 
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?=$album['title']?></title>
        <script type="text/javascript">
        var album = <?=json_encode($album)?>;
        var files  = <?=json_encode($albumDescription)?>;
        var sizeConfig = <?=json_encode($image_sizes)?>;
        </script>
        <script type="text/javascript" src="assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="assets/js/main.js"></script>
        <script type="text/javascript" src="assets/js/view.js?v=1.0"></script>
        <link rel="stylesheet" href="assets/css/style.css?v=1.0">
        <link rel="stylesheet" href="assets/css/view.css?v=1.0">
    </head>
    <body onload="onViewLoad()" class="view">
        <?php require_once "header.php"; ?>
        <div>
            <div id="view-container">
                <a id="previous-image" href="javascript:viewPrevious();"></a>
                <div id="view-container-img"></div>
                <div id="view-container-loader"></div>
                <div id="view-container-text" class="hidden"></div>
                <div id="view-container-text-toggle">View text</div>
                <a id="next-image" href="javascript:viewNext();"></a>
            </div>
        </div>
        <a id="hide-show-thumbs" href="javascript:toggleThumbs()">...</a>
        <div class="thumb-container">
            <div class="scroll"></div>
        </div>
    </body>
</html>