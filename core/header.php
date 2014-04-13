<?php
if(!defined("app")){
    header("Location: index.php");
}
?>
<div class="header">
    <?php
    if($view){
        ?>
        <a class="back" href="?">Back to albums</a>
        <?php
    }
    if($view && $_SESSION['logged'] === true){
        ?>
        <span class="mod">
            <a href="javascript:mod.rotateLeft()" class="tool rotate-left"></a>
            <a href="javascript:mod.rotateRight()" class="tool rotate-right"></a>
        </span>
        <?php   
    }
    ?>
    <?php if($_SESSION['logged'] === true) { ?>
    <form action="" method="post">
        <input type="hidden" name="loggout" value="1" />
        <input type="submit" value="" class="loginbtn notactive" />
    </form>
    
    <?php } else { ?>
    <a href="#" id="login_form_toggle" class="loginbtn notactive"></a>
    <span id="login_form">
        <form action="" method="post">
            Username : <input type="text" name="username" /> 
            Password : <input type="password" name="password" />
            <input type="submit" value="Login" class="login-button" />
        </form>
    </span>
    <?php } ?> 
</div>