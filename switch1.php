<?php
session_start();
$page_id = $_GET['page_id'];
 
foreach($_SESSION['accounts'] as $page) {
    if( $page['id'] == $page_id ) {
        $_SESSION['active'] = $page;
        header('Location: manage.php');
        exit();
    }
}
exit();
?>