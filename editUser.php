<?php
session_start();

include 'config.php';
include 'lib/db.php';

$id = $_SESSION['uid'] ?? $_GET['id'] ?? 0;
$dbc = new DB( $db_host, $db_user, $db_pass, $db_name);
$sql = "SELECT * FROM `users` WHERE id=?";
$result = $dbc->query( $sql, $id);
$row = $result->fetchArray();


if( isset( $_POST['submit'] ) ){

    if($_POST['password'] == ""){
        $password = $row['password'];
    }else{
        $password = $_POST['password'];
    }
    
    $sql = "UPDATE `users` SET username=?,password=?,
    fullname=?,email=?,phone=?,gender=?, age=?, city=?, edu=?, major=?, role=?, level=? WHERE id=?";
    $result = $dbc->query( $sql, $_POST['username'], $password, $_POST['fullname'], $_POST['email'],
    $_POST['phone'], $_POST['gender'], $_POST['age'], $_POST['city'], $_POST['edu'], $_POST['major'], 
    $_POST['role'], $_POST['level'], $id);
    $dbc -> close();


    if($result){
        $_SESSION['info'] = "<div style='color: darkgreen;'><p>با موفقیت ویرایش شد!</p></div>";
        header("Location: editUser.php");
    }else{
        $_SESSION['info'] = "<div style='color: red;'><p>خطایی پیش آمد!</p></div>";
        header("Location: editUser.php");
    }

}else{
    include 'view/editUser_view.php';
}
$dbc -> close();

?>