<?php
function dbg($what)
{
	echo "<div style='clear:both;'></div><pre style='display:block; border:solid #000000 1px; background-color:#FFFFFF; color:#000000; font-size:12px;'>";
	var_dump($what);
	echo "</pre><div style='clear:both;'></div>";
}

function getFormat( $file_name )
{
	return substr(strrchr($file_name,'.'),1);
}

function readAlbumsXML(){
    global $path;
    $xml = simplexml_load_file($path."albums.xml");
    $return = array();
    foreach( $xml->album as $album) {
        $return[] = array(
            'id' => (int) $album->id,
            'title' => (string) $album->title,
            'folder' => (string) $album->folder,
            'thumb' => (string) $album->thumb,
            'description' => (string) $album->description
        );
    }
    return $return;
}

function albumsKeys($albums){
    $return = array();
    foreach($albums as $album) {
        $return[$album['id']] = $album;
    }
    return $return;
}

function saveAlbums($albums){
    global $path;
    $xml = new SimpleXMLElement('<albums/>');
    foreach($albums as $album){

        $albumNode = $xml->addChild('album');
        foreach($album as $key => $value) {
            $albumNode->addChild($key, $value);
        }

    }
    $output = $xml->asXML();

    $dom = new DOMDocument('1.0');
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($output);

    file_put_contents($path . 'albums.xml', $dom->saveXML());
}

function readAlbumXML($folder){
    global $path;
    $return = array();

    if(file_exists($path.$folder."/album.xml")) {
        $xml = simplexml_load_file($path.$folder."/album.xml");

        foreach( $xml->file as $file) {
            $return[] = array(
                'file' => (string) $file->file,
                'title' => (string) $file->title,
                'description' => (string) $file->description
            );
        }
    }
    return $return;
}

function saveAlbum($folder, $data){
    global $path;
    $xml = new SimpleXMLElement('<album/>');
    foreach($data as $album){

        $albumNode = $xml->addChild('file');
        foreach($album as $key => $value) {
            $albumNode->addChild($key, $value);
        }

    }
    $output = $xml->asXML();

    $dom = new DOMDocument('1.0');
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($output);

    file_put_contents($path.$folder."/album.xml", $dom->saveXML());
}
?>