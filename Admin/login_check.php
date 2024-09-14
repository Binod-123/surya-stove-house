<?php 
if(!isset($_SESSION['admin_user'])){
    header('Location:login.php');
}