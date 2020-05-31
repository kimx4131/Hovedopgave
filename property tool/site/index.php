<?php session_start(); ?>
<!DOCTYPE html>
<html lang="da">
<head>
    <?php include 'inc/head.php' ?>
    <title>Log ind på ...</title>
</head>
<body>
    <?php include 'inc/db.php' ?>

    <nav class="navbar navbar-expand-md navbar-white">
        <div class="navbar-toggler-right">
            <a href="index.php" id="toogle-logo">
                <img src="img/logo.png" alt="Newsec logo" class="logo">
            </a>
        </div>

        <div class="w-100 nav-flex">
            <div class="collapse navbar-collapse flex-column" id="navbar">
                <ul class="navbar-nav justify-content-end container">
                    <p></p>
                    <p></p>
                </ul>

                <div class="w-100 bg-light-grey">
                    <div class="container nav-flex">
                        <a href="index.php" class="col-2 a-logo" id="desktop-logo">
                            <img src="img/logo.png" alt="Newsec logo" class="logo">
                        </a>
                        <ul class="navbar-nav" style="margin-left:0;">
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>



    <?php
    $loginderror = "";

    if(isset($_POST['submit'])){
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $kodeord = mysqli_real_escape_string($conn, $_POST['kodeord']);

        $salt = "ldfjldjf34lksdf4kle" . $kodeord . "dkj2fldsjljf34elk";
        $hashed = hash('sha512', $salt);

        $sql = "SELECT * FROM bruger WHERE email = '$email' AND kodeord = '$hashed' ";
        $result = mysqli_query($conn, $sql) or die ("Query virker ikke " . $sql);

        if(mysqli_num_rows($result) == 1){
            $user = mysqli_fetch_assoc($result);

            session_start();
            $_SESSION['adgang'] = 'adgang';
            $_SESSION['iduser'] = $user['id_bruger'];
            $_SESSION['type'] = $user['admin'];
            $_SESSION['password'] = $hashed;

            echo "<script>window.location.href='projekt.php';</script>";

        } else {
            $loginderror = "Forkert log ind";
        };

    };
    ?>
    
    <div class="container">
    <div class="row">
            <div class="col-sm-12 col-md-4 ml-auto mr-auto logindboks">
                <h1>Log Ind</h1>
                <p><?php echo $loginderror ?></p>
                <form method="POST">
                    <div class="form-group">
                        <input type="text" name="email" placeholder="Skriv e-mail">
                    </div>
                    <div class="form-group">
                        <input type="password" name="kodeord" placeholder="Skriv kodeord">
                    </div>
                    <button type="submit" name="submit" class="w-100">Log ind</button>
                </form>
            </div>
        </div>
    </div>

    <?php include 'inc/footer.php' ?>

</body>
</html>