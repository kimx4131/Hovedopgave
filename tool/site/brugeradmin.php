<?php session_start(); ?>
<!DOCTYPE html>
<html lang="da">
<head>
    <?php include 'inc/head.php' ?>
    <title>Brugeradmin</title>
</head>
<body>
    <?php include 'inc/db.php' ?>
    <?php include 'inc/nav.php' ?>

    <?php 
        if(isset($_SESSION['adgang'])){

            $sqlusers = "SELECT * FROM bruger";
            $resultusers = mysqli_query($conn, $sqlusers) or die("Query virker ikke");
            $users = mysqli_fetch_all($resultusers, MYSQLI_ASSOC); 

            //Variabler til beskeder
            $adduseremail = "";
            $addusermsg = "";

            //Når der oprettes en bruger
            if(isset($_POST['opretbruger'])){
                $name = mysqli_real_escape_string($conn, $_POST['navn']);
                $admin = mysqli_real_escape_string($conn, $_POST['admin']);
                $email = mysqli_real_escape_string($conn, $_POST['email']);
                $emailgentag = mysqli_real_escape_string($conn, $_POST['emailgentag']);
            
                $flagemail = false;
                $emailUniq = true;
            
                $salt = "ldfjldjf34lksdf4kle" . "Newsec123" . "dkj2fldsjljf34elk";
                $hashed = hash('sha512', $salt);
            
                if($admin == "admin"){
                    $admin = "ja";
                } else{
                    $admin = "nej";
                };
            
                if($email == $emailgentag){
                    $flagemail = true;
                } else {
                    $adduseremail = "E-mailen er ikke ens";
                };

                //Henter email for at se om emailen er taget.
                $sqlemail = "SELECT * FROM `bruger` WHERE email = '$email'";
                $resultemail = mysqli_query($conn, $sqlemail)  or die("Query virker ikke - henter");
                    if(mysqli_num_rows($resultemail) == 1){
                        $emailUniq = false;
                        $msgemail ="Email er i brug.";
                    };
            
                if($flagemail == true AND $emailUniq == true){
                    //Indsættes i databasen
                    $sql = "INSERT INTO bruger (`id_bruger`, `email`, `navn`, `kodeord`, `admin`) VALUES (NULL, '$email', '$name', '$hashed', '$admin');";
                    $result = mysqli_query($conn, $sql) or die("Query virker overhoved ikke - upload");

                    $to = $email;
                        $subject = "My subject";
                        $txt ='
                            <div id="baggrund" style="background-color: #f9f8f3; padding-top: 20px; padding-bottom: 20px; font-family: arial;"><br />
                            <table style="background-color: white; width: 100%; max-width: 600px; margin-right: auto; margin-left: auto; border-collapse: collapse;">
                            <tbody>
                            <tr>
                            <td colspan="2">&nbsp;<img class="mar-right" style="margin-right: 25px; margin-left: auto; margin-top: 7px; display: block; margin-bottom: 15px;" alt="Newsec logo" src="https://www.newsec.dk/globalassets/denmark/images/e-mail-grafik/newsec-logo.jpg" height="58" width="117" /></td>
                            </tr>
                            <tr>
                            <td class="pad-left" style="padding-left: 25px; padding-right: 25px; color: black;" colspan="2">
                            <p>Kære&nbsp;#Navn#</p>
                            <p>&nbsp;</p>
                            <p>Vi har modtaget din opsigelse.&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>Du vil inden for få dage modtage en e-mail eller et brev med nærmere oplysninger om fraflytning, flyttesyn mv.</p>
                            <p>Når du modtager bekræftelsen på din opsigelse, bedes du venligst være opmærksom på de datoer der bliver nævnt i brevet, at de stemmer overens med de ønskede datoer for fraflytning.</p>
                            <p>&nbsp;&nbsp;</p>
                            <p>Venlig hilsen</p>
                            <p>Newsec<br />Commercial</p>
                            <p>&nbsp;</p>
                            </td>
                            </tr>
                            <tr class="hide-mobil" style="background-color: #33434b; color: white; font-size: 9px;">
                            <td class="pad-left" style="padding-left: 25px;">
                            <p style="margin-bottom: 0; margin-top: 20px;">Newsec<br /> Lyngby Hovedgade 4 <br /> 2800 Kgs. Lyngby</p>
                            <a style="color: white;" href="https://www.newsec.dk">www.newsec.dk</a>
                            <p style="font-size: 7px; margin-top: 10px; margin-bottom: 20px;">THE FULL SERVICE PROPERTY HOUSE</p>
                            </td>
                            <td style="align-content: flex-end;">
                            <div class="mar-right" style="float: right; margin-bottom: 5px; padding-bottom: 0; margin-top: auto; margin-right: 25px;">
                            <p style="margin-bottom: 0; padding-left: 5px;">Følg os</p>
                            <p class="circle-mobil" style="display: inline-block; width: 30px; height: 30px; background-color: #ffffff; border-radius: 50%; margin: 5px;"><a title="https://www.facebook.com/NewsecGroup/" href="https://www.facebook.com/NewsecGroup/" target="_blank"><img class="social" style="width: 12px; height: 12px; margin-right: auto; margin-left: 30%; margin-top: 30%; margin-bottom: auto; display: inline-block;" alt="facebook link" src="/EPiServer/CMS/Content/globalassets/denmark/images/e-mail-grafik/facebook.png,,120343?epieditmode=False" height="42" width="42" /></a></p>
                            <p class="circle-mobil" style="display: inline-block; width: 30px; height: 30px; background-color: #ffffff; border-radius: 50%; margin-bottom: 5px; margin-left: 0px; margin-right: 0px; margin-top: 5px;"><a title="https://www.linkedin.com/company/newsec/" href="https://www.linkedin.com/company/newsec/"><img class="social" style="width: 12px; height: 12px; margin-right: auto; margin-left: 30%; margin-top: 30%; margin-bottom: auto; display: inline-block;" alt="linkin link" src="/EPiServer/CMS/Content/globalassets/denmark/images/e-mail-grafik/linkin.png,,120344?epieditmode=False" height="40" width="40" /></a></p>
                            </div>
                            </td>
                            </tr>
                            </tbody>
                            </table>
                            </div>';
                        $headers = "From: kim@kragesand.dk";
                        mail($to,$subject,$txt,$headers);
            
                    $addusermsg = "Bruger er oprettet";
                    echo "<script>window.location.href='brugeradmin.php';</script>";
            
                } else {
                    $addusermsg = "Bruger blev ikke oprettet. ".$msgemail;
                };
            };

            //Slet bruger
            if(isset($_POST['slet'])){
                $idusder = mysqli_real_escape_string($conn, $_POST['idusder']);

                $sql = "DELETE FROM bruger WHERE id_bruger = '$idusder'";

                // Fobindelse til at slette bruger
                $usersconn = false;
                if(mysqli_query($conn, $sql)){
                    $usersconn = true;
                    echo "<script>window.location.href='brugeradmin.php';</script>";
                } else {
                    echo "ERROR sql " . mysqli_error($conn);
                    $addusermsg = "Bruger er ikke slettet.";
                };
            };

            //Nultil kodeord
            if(isset($_POST['nulstil'])){
                $idbruger = mysqli_real_escape_string($conn, $_POST['idbruger']);

                $salt = "ldfjldjf34lksdf4kle" . "Newsec123" . "dkj2fldsjljf34elk";
                $hashed = hash('sha512', $salt);

                $sql = "UPDATE bruger SET kodeord='$hashed' WHERE bruger.id_bruger='$idbruger'";

                $usersconn = false;
                if(mysqli_query($conn, $sql)){
                    $usersconn = true;

                    $to = "kim.k.b@hotmail.com"; //$email
                        $subject = "My subject";
                        $txt ='
                            <div id="baggrund" style="background-color: #f9f8f3; padding-top: 20px; padding-bottom: 20px; font-family: arial;"><br />
                            <table style="background-color: white; width: 100%; max-width: 600px; margin-right: auto; margin-left: auto; border-collapse: collapse;">
                            <tbody>
                            <tr>
                            <td colspan="2">&nbsp;<img class="mar-right" style="margin-right: 25px; margin-left: auto; margin-top: 7px; display: block; margin-bottom: 15px;" alt="Newsec logo" src="https://www.newsec.dk/globalassets/denmark/images/e-mail-grafik/newsec-logo.jpg" height="58" width="117" /></td>
                            </tr>
                            <tr>
                            <td class="pad-left" style="padding-left: 25px; padding-right: 25px; color: black;" colspan="2">
                            <p>Kære&nbsp;#Navn#</p>
                            <p>&nbsp;</p>
                            <p>Vi har modtaget din opsigelse.&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>Du vil inden for få dage modtage en e-mail eller et brev med nærmere oplysninger om fraflytning, flyttesyn mv.</p>
                            <p>Når du modtager bekræftelsen på din opsigelse, bedes du venligst være opmærksom på de datoer der bliver nævnt i brevet, at de stemmer overens med de ønskede datoer for fraflytning.</p>
                            <p>&nbsp;&nbsp;</p>
                            <p>Venlig hilsen</p>
                            <p>Newsec<br />Commercial</p>
                            <p>&nbsp;</p>
                            </td>
                            </tr>
                            <tr class="hide-mobil" style="background-color: #33434b; color: white; font-size: 9px;">
                            <td class="pad-left" style="padding-left: 25px;">
                            <p style="margin-bottom: 0; margin-top: 20px;">Newsec<br /> Lyngby Hovedgade 4 <br /> 2800 Kgs. Lyngby</p>
                            <a style="color: white;" href="https://www.newsec.dk">www.newsec.dk</a>
                            <p style="font-size: 7px; margin-top: 10px; margin-bottom: 20px;">THE FULL SERVICE PROPERTY HOUSE</p>
                            </td>
                            <td style="align-content: flex-end;">
                            <div class="mar-right" style="float: right; margin-bottom: 5px; padding-bottom: 0; margin-top: auto; margin-right: 25px;">
                            <p style="margin-bottom: 0; padding-left: 5px;">Følg os</p>
                            <p class="circle-mobil" style="display: inline-block; width: 30px; height: 30px; background-color: #ffffff; border-radius: 50%; margin: 5px;"><a title="https://www.facebook.com/NewsecGroup/" href="https://www.facebook.com/NewsecGroup/" target="_blank"><img class="social" style="width: 12px; height: 12px; margin-right: auto; margin-left: 30%; margin-top: 30%; margin-bottom: auto; display: inline-block;" alt="facebook link" src="/EPiServer/CMS/Content/globalassets/denmark/images/e-mail-grafik/facebook.png,,120343?epieditmode=False" height="42" width="42" /></a></p>
                            <p class="circle-mobil" style="display: inline-block; width: 30px; height: 30px; background-color: #ffffff; border-radius: 50%; margin-bottom: 5px; margin-left: 0px; margin-right: 0px; margin-top: 5px;"><a title="https://www.linkedin.com/company/newsec/" href="https://www.linkedin.com/company/newsec/"><img class="social" style="width: 12px; height: 12px; margin-right: auto; margin-left: 30%; margin-top: 30%; margin-bottom: auto; display: inline-block;" alt="linkin link" src="/EPiServer/CMS/Content/globalassets/denmark/images/e-mail-grafik/linkin.png,,120344?epieditmode=False" height="40" width="40" /></a></p>
                            </div>
                            </td>
                            </tr>
                            </tbody>
                            </table>
                            </div>';
                        $headers = "From: kim@kragesand.dk";
                        mail($to,$subject,$txt,$headers);

                    $addusermsg = "Brugers kode er nulstilt";
                } else {
                    echo "ERROR sql " . mysqli_error($conn);
                };

            }

            //ret bruger
            if(isset($_POST['opdaterbruger'])){
                $navn = mysqli_real_escape_string($conn, $_POST['navn']);
                $admin = mysqli_real_escape_string($conn, $_POST['admin']);
                $email = mysqli_real_escape_string($conn, $_POST['email']);
                $emailgentag = mysqli_real_escape_string($conn, $_POST['emailgentag']);
                $idbruger = mysqli_real_escape_string($conn, $_POST['idbruger']);

                $flagemail = false;
                $emailUniq = true;

                if($admin == "admin"){
                    $admin = "ja";
                } else{
                    $admin = "nej";
                };

                if($email == $emailgentag){
                    $flagemail = true;
                } else {
                    $adduseremail = "E-mailen er ikke ens";
                };

                //Henter email for at se om emailen er taget.
                $sqlemail = "SELECT * FROM `bruger` WHERE email = '$email'";
                $resultemail = mysqli_query($conn, $sqlemail)  or die("Query virker ikke - henter");
                    if(mysqli_num_rows($resultemail) == 1){
                        $emailUniq = false;
                        $msgemail ="Email er i brug.";
                    };

                //Tjekker om navnet er ændret
                $sqlidbruger = "SELECT * FROM bruger WHERE id_bruger = $idbruger";
                $resultidbruger = mysqli_query($conn, $sqlidbruger);
                $useridbruger = mysqli_fetch_assoc($resultidbruger);
                if($useridbruger['navn'] != $navn ){

                }

                if($flagemail == true AND $emailUniq == true){
                    $sql = "UPDATE bruger SET email='$email', navn='$navn', admin='$admin' WHERE bruger.id_bruger='$idbruger'";

                    $usersconn = false;
                    if(mysqli_query($conn, $sql)){
                        $usersconn = true;
                        $addusermsg = "Bruger er rettet";

                        $to = $email;
                        $subject = "My subject";
                        $txt ='
                            <div id="baggrund" style="background-color: #f9f8f3; padding-top: 20px; padding-bottom: 20px; font-family: arial;"><br />
                            <table style="background-color: white; width: 100%; max-width: 600px; margin-right: auto; margin-left: auto; border-collapse: collapse;">
                            <tbody>
                            <tr>
                            <td colspan="2">&nbsp;<img class="mar-right" style="margin-right: 25px; margin-left: auto; margin-top: 7px; display: block; margin-bottom: 15px;" alt="Newsec logo" src="https://www.newsec.dk/globalassets/denmark/images/e-mail-grafik/newsec-logo.jpg" height="58" width="117" /></td>
                            </tr>
                            <tr>
                            <td class="pad-left" style="padding-left: 25px; padding-right: 25px; color: black;" colspan="2">
                            <p>Kære&nbsp;#Navn#</p>
                            <p>&nbsp;</p>
                            <p>Vi har modtaget din opsigelse.&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>Du vil inden for få dage modtage en e-mail eller et brev med nærmere oplysninger om fraflytning, flyttesyn mv.</p>
                            <p>Når du modtager bekræftelsen på din opsigelse, bedes du venligst være opmærksom på de datoer der bliver nævnt i brevet, at de stemmer overens med de ønskede datoer for fraflytning.</p>
                            <p>&nbsp;&nbsp;</p>
                            <p>Venlig hilsen</p>
                            <p>Newsec<br />Commercial</p>
                            <p>&nbsp;</p>
                            </td>
                            </tr>
                            <tr class="hide-mobil" style="background-color: #33434b; color: white; font-size: 9px;">
                            <td class="pad-left" style="padding-left: 25px;">
                            <p style="margin-bottom: 0; margin-top: 20px;">Newsec<br /> Lyngby Hovedgade 4 <br /> 2800 Kgs. Lyngby</p>
                            <a style="color: white;" href="https://www.newsec.dk">www.newsec.dk</a>
                            <p style="font-size: 7px; margin-top: 10px; margin-bottom: 20px;">THE FULL SERVICE PROPERTY HOUSE</p>
                            </td>
                            <td style="align-content: flex-end;">
                            <div class="mar-right" style="float: right; margin-bottom: 5px; padding-bottom: 0; margin-top: auto; margin-right: 25px;">
                            <p style="margin-bottom: 0; padding-left: 5px;">Følg os</p>
                            <p class="circle-mobil" style="display: inline-block; width: 30px; height: 30px; background-color: #ffffff; border-radius: 50%; margin: 5px;"><a title="https://www.facebook.com/NewsecGroup/" href="https://www.facebook.com/NewsecGroup/" target="_blank"><img class="social" style="width: 12px; height: 12px; margin-right: auto; margin-left: 30%; margin-top: 30%; margin-bottom: auto; display: inline-block;" alt="facebook link" src="/EPiServer/CMS/Content/globalassets/denmark/images/e-mail-grafik/facebook.png,,120343?epieditmode=False" height="42" width="42" /></a></p>
                            <p class="circle-mobil" style="display: inline-block; width: 30px; height: 30px; background-color: #ffffff; border-radius: 50%; margin-bottom: 5px; margin-left: 0px; margin-right: 0px; margin-top: 5px;"><a title="https://www.linkedin.com/company/newsec/" href="https://www.linkedin.com/company/newsec/"><img class="social" style="width: 12px; height: 12px; margin-right: auto; margin-left: 30%; margin-top: 30%; margin-bottom: auto; display: inline-block;" alt="linkin link" src="/EPiServer/CMS/Content/globalassets/denmark/images/e-mail-grafik/linkin.png,,120344?epieditmode=False" height="40" width="40" /></a></p>
                            </div>
                            </td>
                            </tr>
                            </tbody>
                            </table>
                            </div>';
                        $headers = "From: kim@kragesand.dk";
                        mail($to,$subject,$txt,$headers);

                        echo "<script>window.location.href='brugeradmin.php';</script>";
                    } else {
                        echo "ERROR sql " . mysqli_error($conn);
                    };
                };

            };

            //Henter / tjekker URL
            if(isset($_GET['idusder'])){
                $id = mysqli_real_escape_string($conn, $_GET['idusder']);
                $sql = "SELECT * FROM bruger WHERE id_bruger = $id";
                $result = mysqli_query($conn, $sql);
                $userinfo = mysqli_fetch_assoc($result);
            }
            

        } else{
            //Hvis man ikke er logget på
            echo "<script>window.location.href='index.php';</script>";
        };
    ?>

<?php 

?>
    
    <div class="container">
        <div class="row h1area">
            <div class="col-md-8">
                <h1>Brugeradmin</h1>
            </div>
            <div class="col-md-4 moveright">
                <button id="adduser">+ Bruger</button>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <p><?php echo $addusermsg.$adduseremail ?></p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-9">
                <table class="w-100">
                    <thead>
                        <tr>
                            <th>Navn</th>
                            <th>E-mail</th>
                            <th>Admin</th>
                            <th>Kode</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($users as $user): ?>
                        <tr>
                            <td><?php echo $user['navn'] ?></td>
                            <td><?php echo $user['email'] ?></td>
                            <td><?php echo $user['admin'] ?></td>
                            <td>
                                <form method="POST">
                                    <input type="hidden" name="idbruger" value="<?php echo $user['id_bruger'] ?>">
                                    <input type="submit" name="nulstil" Value="Nulstil" class="nulstil">
                                </form>
                            </td>
                            <td>
                                <form>
                                    <!-- <img src="img/icons/ret.png" alt="ret ikon"> -->
                                    <input type="text" name="idusder" value="<?php echo $user['id_bruger'] ?>" style="display:none;">
                                    <input type="submit" class="ret" id="ret" value="">
                                </form>
                            </td>
                            <td>
                                <form method="POST">
                                    <!-- <img src="img/icons/slet.png" alt="ret ikon"> -->
                                    <input type="text" name="idusder" value="<?php echo $user['id_bruger'] ?>" style="display:none;">
                                    <input type="submit" name="slet" class="slet" value="">
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="popup" id="adduserpopup"><?php include 'popup/useradd.php' ?></div>
    <div class="popup" id="edituserpopup"><?php include 'popup/useredit.php' ?></div>
    

    <?php include 'inc/footer.php' ?>

    <script>
    // Tilføj en bruger
    let adduser = document.querySelector('#adduser');
    let adduserpopup = document.querySelector('#adduserpopup');

    adduser.addEventListener("click", function(){
        adduserpopup.classList.remove("popup");
        adduserpopup.classList.add("popupshow");
    });

    // Ret en bruger
    let ret = document.querySelector("#ret");
    let edituserpopup = document.querySelector("#edituserpopup");

   function useredit(){
        let ret = document.querySelector("#ret");
        let edituserpopup = document.querySelector("#edituserpopup");
        edituserpopup.classList.remove("popup");
        edituserpopup.classList.add("popupshow");
    };


    // Luk popup - tilføj bruger
    let lukpopup = document.querySelector('#lukpopup');

    lukpopup.addEventListener("click", function(){
        adduserpopup.classList.remove("popupshow");
        adduserpopup.classList.add("popup");
    });

    // Luk popup - ret bruger
    let lukpopup2= document.querySelector('#lukpopup2');

    lukpopup2.addEventListener("click", function(){
        window.location.href='brugeradmin.php';
    });


    </script>

<?php 
if(isset($id)){
    echo '<script>
    useredit();
    </script>';
};
?>

</body>
</html>




