<?php
if(!defined("app") || isLogged() === false){
    header("Location: index.php");
}

if(count($_POST)>0){
    $newList = array();
    foreach($_POST['id'] as $cnt => $row){
        if( strlen($_POST['folder'][$cnt]) > 0){
            array_push($newList, array(
                "id" => $_POST['id'][$cnt],
                "title" => $_POST['title'][$cnt],
                "description" => $_POST['description'][$cnt],
                "folder" => $_POST['folder'][$cnt],
                "thumb" => $_POST['thumb'][$cnt]
            ));
        }
    }
    saveAlbums($newList);
}

$list = $albums;
$list[] = array(
    'thumb' => '',
    'title' => '',
    'description' => '',
    'folder' => ''
);
?>
<form action="" method="post">
<table>
    <tr>
        <th>id</th>
        <th>Name</th>
        <th>Folder</th>
        <th>Description</th>
    </tr>
<?php
$incId = 1;
foreach( $list as $row ){
    if(isset($row['id'])){
        $incId = ($row['id']*1)+1;
    }
    ?>
    <tr>
        <td><input type='text' name="id[]" style="width:30px;" readonly="readonly" value="<?=isset($row['id'])?$row['id']:$incId?>" /></td>
        <td><input type='text' name="title[]" value="<?=$row['title']?>" /></td>
        <td><input type='text' name="folder[]" value="<?=$row['folder']?>" /></td>
        <td>
            <textarea name="description[]"><?=$row['description']?></textarea>
            <input type="hidden" name="thumb[]" value="<?=$row['thumb']?>" /> 
        </td>
    </tr>
    <?php
}
?>
    <tr>
        <td colspan="4" align="center">
            <button type="submit">Update</button>
        </td>
    </tr>
</table>
</form>