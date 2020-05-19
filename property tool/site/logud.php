<?php session_start(); ?>
<!DOCTYPE html>
<html lang="da">
<head>
    <?php include 'inc/head.php' ?>
    <title>Log ud</title>
</head>
<body>
    <?php include 'inc/db.php'?>
    <?php include 'inc/nav.php' ?>
    
    <?php 
    session_destroy();
    echo "<script>window.location.href='index.php';</script>";
    ?>

    <?php include 'inc/footer.php' ?>

</body>
</html>