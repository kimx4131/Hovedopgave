<?php session_start(); ?>
<!DOCTYPE html>
<html lang="da">
<head>
    <?php include 'inc/head.php' ?>
    <title>Projekter</title>
</head>
<body>
    <?php include 'inc/db.php' ?>
    <?php include 'inc/nav.php' ?>

    <?php 
        if(isset($_SESSION['adgang'])){
            $saltnewsec = "ldfjldjf34lksdf4kle" . "Newsec123" . "dkj2fldsjljf34elk";
            $passwordnewsec = hash('sha512', $saltnewsec);
            $password = $_SESSION['password'];


            $sqlprojekt = "SELECT * FROM projekter";
            $resultprojekt = mysqli_query($conn, $sqlprojekt) or die("Query virker ikke");
            $projekter = mysqli_fetch_all($resultprojekt, MYSQLI_ASSOC); 

            $iduser = $_SESSION['iduser'];

            $sqluserid = "SELECT * FROM bruger WHERE id_bruger = $iduser";
            $resultuserid = mysqli_query($conn, $sqluserid);
            $userinfo = mysqli_fetch_assoc($resultuserid);

            $username = $userinfo['navn'];
            $useridbruger = $userinfo['id_bruger'];
            $useradmin = $userinfo['admin'];
            
            $projektmsg = "";
            $passworderrormsg = "";

            //Når der oprettes et projekt
            if(isset($_POST['opretprojekt'])){
                $name = mysqli_real_escape_string($conn, $_POST['navn']);

                $nameUniq = true;

                //Henter projektnavn for at se om navnet er taget.
                $sql = "SELECT * FROM `projekter` WHERE projektnavn = '$name'";
                $resultnavn = mysqli_query($conn, $sql)  or die("Query virker ikke - henter");

                    if(mysqli_num_rows($resultnavn) == 1){
                        $nameUniq = false;
                    };
            

                if($nameUniq== true){
                    //Indsættes i databasen
                    $sql = "INSERT INTO projekter (`id_projekt`, `projektnavn`, `ejer`) VALUES (NULL, '$name', '$useridbruger');";
                    $result = mysqli_query($conn, $sql) or die("Query virker overhoved ikke - upload");

                    mkdir('projekter/'.$name, 0777, true);
            
                    echo "<script>window.location.href='projekt.php';</script>";
            
                } else {
                    $projektmsg = "Projekt blev ikke oprettet. Projektnavn er taget.";
                };
            };

            //Slet projekt 
            if(isset($_POST['slet'])){
                $sletid = mysqli_real_escape_string($conn, $_POST['sletid']);

                $sqlprojektid= "SELECT * FROM projekter WHERE id_projekt = $sletid";
                $resultidprojekt = mysqli_query($conn, $sqlprojektid);
                $projektinfo = mysqli_fetch_assoc($resultidprojekt);
                $projektname = $projektinfo['projektnavn'];

                $sql = "DELETE FROM projekter WHERE id_projekt = '$sletid'";

                // Fobindelse til at slette bruger
                $usersconn = false;
                if(mysqli_query($conn, $sql)){
                    $usersconn = true;

                    $files = glob('projekter/'.$projektname.'/*'); // get all file names
                    foreach($files as $file){ // iterate files
                    if(is_file($file))
                        unlink($file); // delete file
                    };

                    echo "<script>window.location.href='projekt.php';</script>";
                } else {
                    echo "ERROR sql " . mysqli_error($conn);
                    $projektmsg = "Projekt er ikke slettet.";
                };
            };

            $passwordconn = false;
            //Ændre kodeord
            if(isset($_POST['changepassword'])){
                $passwordone = mysqli_real_escape_string($conn, $_POST['passwordone']);
                $passwordtwo = mysqli_real_escape_string($conn, $_POST['passwordtwo']);

                $flagpasswordmatch = true;
                $flagnewsecpassword = false;

                if($passwordone !== $passwordtwo){
                    $flagpasswordmatch = false;
                }

                if($passwordone == "Newsec123" OR $passwordtwo == "Newsec123"){
                    $flagnewsecpassword = true;
                }

                if($flagpasswordmatch == true AND $flagnewsecpassword == false){
                    $salt = "ldfjldjf34lksdf4kle" . $passwordone . "dkj2fldsjljf34elk";
                    $hashed = hash('sha512', $salt);

                    $sql = "UPDATE bruger SET kodeord='$hashed' WHERE id_bruger='$iduser'";

                    $passwordconn = false;
                    if(mysqli_query($conn, $sql)){
                        $passwordconn = true;
                        $_SESSION['password'] = $hashed;
                    } else {
                        echo "ERROR sql " . mysqli_error($conn);
                    };

                }else{
                    if($flagpasswordmatch == false AND $flagnewsecpassword == false){
                        $passworderrormsg = "De indtastede kodeord er ikke ens.";
                    } else if($flagnewsecpassword == true AND $flagpasswordmatch == true){
                        $passworderrormsg = 'Dit kodeord må ikke være "Newsec123"';
                    }else if($flagpasswordmatch == false AND $flagnewsecpassword == true){
                        $passworderrormsg = 'De indtastede kordord er ikke ens. Dit kodeord må ikke være "Newsec123"';
                    }
                }


            };

        } else{
            echo "<script>window.location.href='index.php';</script>";
        };
    ?>
    
    <div class="container">
        <div class="row h1area">
            <div class="col-md-8">
                <h1>Projekter</h1>
            </div>
            <div class="col-md-4 moveright">
                <button id="addprojekt">+ Projekt</button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-7">
                <?php echo "<p>".$projektmsg."</p>" ?>
                <table class="w-100">
                    <thead>
                        <tr>
                            <th>Projektnavn</th>
                            <th>Oprettet af</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($projekter as $projekt): 
                            $useridname = $projekt['ejer'];
                            $sqluseridname = "SELECT * FROM bruger WHERE id_bruger = $useridname";
                            $resultuserid = mysqli_query($conn, $sqluseridname);
                            $useridinfoname = mysqli_fetch_assoc($resultuserid);
                        ?>
                        <tr>
                            <td><?php echo $projekt['projektnavn'] ?></td>
                            <td><?php echo $useridinfoname['navn'] ?></td>
                            <td>
                            <?php 
                                if($useradmin == "ja" OR $username == $useridinfoname['navn']){
                                    $projektid = $projekt['id_projekt'];
                                    echo'
                                    <form method="POST">
                                    <!-- <img src="img/icons/slet.png" alt="ret ikon"> -->
                                    <input type="text" name="sletid" value="'.$projekt['id_projekt'].'" style="display:none;">
                                    <input type="submit" name="slet" class="slet" value="">
                                </form>';
                                } else {
                                    echo "";
                                }
                                ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-5">
                <h3>Oprettelse af nyt projekt</h3>
                <p>Skal du lavet et nyt projekt, kan du her læse hvordan. Der er tre steps. </p>
                <p class="listheading">Step 1: Opret nyt projekt</p>
                <ul>
                    <li>Klik på “+ projekt” på denne side </li>
                    <li>Udfyld indformationerne </li>
                    <li>Klik opret </li>
                </ul>
                <p class="listheading">Step 2: Upload CSV fil (Excel)</p>
                <ul>
                    <li><a href="img/skabelone.csv" target="_blank">Download denne skabelon</a></li>
                    <li>Udfylde alle felter (pånær dem der står “NULL” i)</li>
                    <li>Eksporter som CSV fil (Web teamet kan hjælpe)</li>
                    <li>Vælg “Boligliste” i menuen </li>
                    <li>Klik på “+ CSV”</li>
                    <li>Vælg filen, vælg dit projekt og klik “upload”</li>
                </ul>
                <p class="listheading">Step 3: Isometri </p>
                <ul>
                    <li>Vælg “Boligliste” i menuen</li>
                    <li>Vælg dit projekt i menuen </li>
                    <li>Klik på download knappen ved listen</li>
                    <li>Fremsend listen samt arkitekttegninger til web@newsec.dk med ejendoms nummer</li>
                    <li>Du får besked når webteamet har uploadet Isometrien</li>
                </ul>
                <p>Isometrierne er nu klar til at blive implementeret til hjemmesiden.</p>
            </div>
        </div>

    </div>

    <div class="popup" id="projektaddpopup"><?php include 'popup/projektadd.php' ?></div>
    <div class="popup" id="possword"><?php include 'popup/passwordchange.php' ?></div>


    <?php include 'inc/footer.php' ?>

    <script>
        // Tilføj et projekt
        let addprojekt = document.querySelector('#addprojekt');
        let projektaddpopup = document.querySelector('#projektaddpopup');

        addprojekt.addEventListener("click", function(){
            projektaddpopup.classList.remove("popup");
            projektaddpopup.classList.add("popupshow");
        });


        // Luk popup - tilføj projekt
        let lukpopup = document.querySelector('#lukpopup');

        lukpopup.addEventListener("click", function(){
            projektaddpopup.classList.remove("popupshow");
            projektaddpopup.classList.add("popup");
        });

        function closepopuppassword(){
            let possword = document.querySelector('#possword');
            possword.classList.remove('popupshow');
            possword.classList.add('popup');
        }

    </script>

    <?php 
        if($password == $passwordnewsec){
            echo "<script>document.querySelector('#possword').classList.remove('popup');</script>";
            echo "<script>document.querySelector('#possword').classList.add('popupshow');</script>";
        }

        if($passwordconn == true){
            echo "<script>closepopuppassword();</script>";
        }
    ?>

</body>
</html>