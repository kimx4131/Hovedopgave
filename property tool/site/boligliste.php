<?php session_start(); ?>
<!DOCTYPE html>
<html lang="da">
<head>
    <?php include 'inc/head.php' ?>
    <title>Boligliste</title>
</head>
<body>
    <?php include 'inc/db.php' ?>
    <?php include 'inc/nav.php' ?>

    <?php 
    $message = " ";
        if(isset($_SESSION['adgang'])){
            //Sorter tablen efter projekt valget i menuen
            if(isset($_SESSION['projektsorter'])){
                if($_SESSION['projektsorter'] == "NULL"){
                    //Henter informationer fra boligliste tabellen
                    $sqlbolig = "SELECT * FROM boligliste";
                    $resultbolig = mysqli_query($conn, $sqlbolig) or die("Query virker ikke");
                    $boliger = mysqli_fetch_all($resultbolig, MYSQLI_ASSOC); 

                    //Henter informationer fra projekt tabellen
                    $projekttiliframe = "SELECT * FROM projekter";
                    $resultiframeprojekt = mysqli_query($conn, $projekttiliframe) or die("Query virker ikke");
                    $iframeprojekter = mysqli_fetch_all($resultiframeprojekt, MYSQLI_ASSOC); 

                }else{
                    $projektsorter = $_SESSION['projektsorter'];
                    //Henter informationer omkring valgt projekt fra boligliste tabellen
                    $sqlbolig = "SELECT * FROM boligliste WHERE id_projekt = $projektsorter";
                    $resultbolig = mysqli_query($conn, $sqlbolig) or die("Query virker ikke");
                    $boliger = mysqli_fetch_all($resultbolig, MYSQLI_ASSOC); 

                    //Henter informationer fra projekt tabellen
                    $projekttiliframe = "SELECT * FROM projekter WHERE id_projekt = $projektsorter";
                    $resultiframeprojekt = mysqli_query($conn, $projekttiliframe) or die("Query virker ikke");
                    $iframeprojekter = mysqli_fetch_all($resultiframeprojekt, MYSQLI_ASSOC); 
                }
            }else{
                //Henter informationer fra boligliste tabellen
                $sqlbolig = "SELECT * FROM boligliste";
                $resultbolig = mysqli_query($conn, $sqlbolig) or die("Query virker ikke");
                $boliger = mysqli_fetch_all($resultbolig, MYSQLI_ASSOC); 

                //Henter informationer fra projekt tabellen
                $projekttiliframe = "SELECT * FROM projekter";
                $resultiframeprojekt = mysqli_query($conn, $projekttiliframe) or die("Query virker ikke");
                $iframeprojekter = mysqli_fetch_all($resultiframeprojekt, MYSQLI_ASSOC); 
            }

            $msgplan = "";

            //Opload CSV fil
            if (isset($_POST["oploadcsv"])) {
                $fileName = $_FILES["file"]["tmp_name"];
                
                if ($_FILES["file"]["size"] > 0) {
                    $file = fopen($fileName, "r");
                    
                    while (($column = fgetcsv($file, 10000, ";")) !== FALSE) {
                        
                        $idb = NULL; 
                        if (isset($column[0])) { $userId = mysqli_real_escape_string($conn, $column[0]);}
                        
                        $lejlnr = NULL; 
                        if (isset($column[1])) { $lejlnr = mysqli_real_escape_string($conn, $column[1]);}

                        // $idp = ""; 
                        // if (isset($column[2])) { $idp = mysqli_real_escape_string($conn, $column[2]);}
                        $idp = mysqli_real_escape_string($conn, $_POST['valgtprojekt']);
                        
                        $postnr = ""; 
                        if (isset($column[3])) { $postnr = mysqli_real_escape_string($conn, $column[3]);}
                        
                        $vejnavn = ""; 
                        if (isset($column[4])) { $vejnavn = mysqli_real_escape_string($conn, $column[4]);}
                        
                        $husnr = ""; 
                        if (isset($column[5])) { $husnr = mysqli_real_escape_string($conn, $column[5]);}
                        
                        $etage = ""; 
                        if (isset($column[6])) { $etage = mysqli_real_escape_string($conn, $column[6]);}
                        
                        $side = ""; 
                        if (isset($column[7])) { $side = mysqli_real_escape_string($conn, $column[7]);}
                        
                        $bypost = ""; 
                        if (isset($column[8])) { $bypost = mysqli_real_escape_string($conn, $column[8]);}
                        
                        $kvm = ""; 
                        if (isset($column[9])) { $kvm = mysqli_real_escape_string($conn, $column[9]);}
                        
                        $vaerelser = ""; 
                        if (isset($column[10])) { $vaerelser = mysqli_real_escape_string($conn, $column[10]);}
                       
                        $lejeraw = ""; 
                        if (isset($column[11])) { $lejeraw = mysqli_real_escape_string($conn, $column[11]);}
                        
                        $lejegebyr = ""; 
                        if (isset($column[12])) { $lejegebyr = mysqli_real_escape_string($conn, $column[12]);}
                        
                        $acontovarme = ""; 
                        if (isset($column[13])) { $acontovarme = mysqli_real_escape_string($conn, $column[13]);}
                        
                        $acontovand = ""; 
                        if (isset($column[14])) { $acontovand = mysqli_real_escape_string($conn, $column[14]);}
                        
                        $depositum = ""; 
                        if (isset($column[15])) { $depositum = mysqli_real_escape_string($conn, $column[15]);}
                        
                        $forudbetalt = ""; 
                        if (isset($column[16])) { $forudbetalt = mysqli_real_escape_string($conn, $column[16]);}
                        
                        $toilet = ""; 
                        if (isset($column[17])) { $toilet = mysqli_real_escape_string($conn, $column[17]);}
                        
                        $bad = ""; 
                        if (isset($column[18])) { $bad = mysqli_real_escape_string($conn, $column[18]);}
                        
                        $ledigpr = ""; 
                        if (isset($column[19])) { $ledigpr = mysqli_real_escape_string($conn, $column[19]);}
                        
                        $bolistatus = ""; 
                        if (isset($column[20])) { $bolistatus = mysqli_real_escape_string($conn, $column[20]);}
                        
                        $plantegning = ""; 
                        if (isset($column[21])) { $plantegning = mysqli_real_escape_string($conn, $column[21]);}
                        
                        $url = ""; 
                        if (isset($column[22])) { $url = mysqli_real_escape_string($conn, $column[22]);}
                        
                        $depotrum = ""; 
                        if (isset($column[23])) { $depotrum = mysqli_real_escape_string($conn, $column[23]);}
                        
                        $altan = ""; 
                        if (isset($column[24])) { $altan = mysqli_real_escape_string($conn, $column[24]);}
                        
                        $terasse = ""; 
                        if (isset($column[25])) { $terasse = mysqli_real_escape_string($conn, $column[25]);}
                        
                        $elevator = ""; 
                        if (isset($column[26])) { $elevator = mysqli_real_escape_string($conn, $column[26]);}


                        $sqlInsert = "INSERT INTO `boligliste` (`id_bolig`, `lejlnr`, `id_projekt`, `postnr`, `vejnavn`, `husnr`, `etage`, `side`, `bypost`, `kvm`, `vaerelser`, `lejeraw`, `lejegebyr`, `acontovarme`, `acontovand`, `depositum`, `forudbetalt`, `toilet`, `bad`, `ledigpr`, `status`, `plantegning`, `url`, `depotrum`, `altan`, `terasse`, `elevator`) VALUES (NULL, '$lejlnr', '$idp', '$postnr', '$vejnavn', '$husnr', '$etage', '$side', '$bypost', '$kvm', '$vaerelser', '$lejeraw', '$lejegebyr','$acontovarme', '$acontovand', '$depositum', '$forudbetalt', '$toilet', '$bad', '$ledigpr', '$bolistatus', '$plantegning','$url', '$depotrum', '$altan', '$terasse', '$elevator');";
                        $result = mysqli_query($conn, $sqlInsert) or die("Query virker overhoved ikke - upload");
                        
                        if (! empty($sqlInsert)) {
                            $type = "success";
                            $message = "CSV Data Imported into the Database";
                            echo "<script>window.location.href='boligliste.php';</script>";
                        } else {
                            $type = "error";
                            $message = "Problem in Importing CSV Data";
                        }
                     
                        
                    }
                }
            }

            //ret bruger
            if(isset($_POST['opdaterbolig'])){
                $vejnavn = mysqli_real_escape_string($conn, $_POST['vejnavn']);
                $husnr = mysqli_real_escape_string($conn, $_POST['husnr']);
                $etage = mysqli_real_escape_string($conn, $_POST['etage']);
                $side = mysqli_real_escape_string($conn, $_POST['side']);
                $postnr = mysqli_real_escape_string($conn, $_POST['postnr']);
                $bypost = mysqli_real_escape_string($conn, $_POST['bypost']);
                $kvm = mysqli_real_escape_string($conn, $_POST['kvm']);
                $vaerelser = mysqli_real_escape_string($conn, $_POST['vaerelser']);
                $lejeraw = mysqli_real_escape_string($conn, $_POST['lejeraw']);
                $lejegebyr = mysqli_real_escape_string($conn, $_POST['lejegebyr']);
                $acontovarme = mysqli_real_escape_string($conn, $_POST['acontovarme']);
                $acontovand = mysqli_real_escape_string($conn, $_POST['acontovand']);
                $depotrum = mysqli_real_escape_string($conn, $_POST['depotrum']);
                $altan = mysqli_real_escape_string($conn, $_POST['altan']);
                $terasse = mysqli_real_escape_string($conn, $_POST['terasse']);
                $elevator = mysqli_real_escape_string($conn, $_POST['elevator']);
                $toilet = mysqli_real_escape_string($conn, $_POST['toilet']);
                $bad = mysqli_real_escape_string($conn, $_POST['bad']);
                $ledigpr = mysqli_real_escape_string($conn, $_POST['ledigpr']);
                $depositum = mysqli_real_escape_string($conn, $_POST['depositum']);
                $forudbetalt = mysqli_real_escape_string($conn, $_POST['forudbetalt']);
                $url = mysqli_real_escape_string($conn, $_POST['url']);
                $idbolig = mysqli_real_escape_string($conn, $_POST['idbolig']);


                $sql = "UPDATE boligliste SET vejnavn='$vejnavn', husnr='$husnr', etage='$etage', side='$side', postnr='$postnr', bypost='$bypost', kvm='$kvm', vaerelser='$vaerelser', lejeraw='$lejeraw', lejegebyr='$lejegebyr', acontovarme='$acontovarme', acontovand='$acontovand', depotrum='$depotrum', altan='$altan', terasse='$terasse', elevator='$elevator', toilet='$toilet', bad='$bad', ledigpr='$ledigpr', depositum='$depositum', forudbetalt='$forudbetalt', url='$url'  WHERE id_bolig='$idbolig'";

                $usersconn = false;
                if(mysqli_query($conn, $sql)){
                    $usersconn = true;

                    echo "<script>window.location.href='boligliste.php';</script>";
                } else {
                    echo "ERROR sql " . mysqli_error($conn);
                };

            };

            //Ret status
            if(isset($_POST['boligstatus'])){
                $boligstatus = mysqli_real_escape_string($conn, $_POST['boligstatus']);
                $boligid = mysqli_real_escape_string($conn, $_POST['boligid']);

                $sql = "UPDATE boligliste SET status='$boligstatus' WHERE id_bolig='$boligid'";

                $usersconn = false;
                if(mysqli_query($conn, $sql)){
                    $usersconn = true;

                    echo "<script>window.location.href='boligliste.php';</script>";
                } else {
                    echo "ERROR sql " . mysqli_error($conn);
                };

            }

            //Tilføj billede/plantegning
            if(isset($_POST['addimg'])){
                $idbolig = mysqli_real_escape_string($conn, $_POST['idbolig']);
                $projektnavn = mysqli_real_escape_string($conn, $_POST['projektnavn']);

                // Get image name
                $image = $_FILES['image']['name'];
                $imagename = basename($image);

                //Henter filnavne for at se om filnavnet er taget.
                $sqlplan = "SELECT * FROM `boligliste` WHERE plantegning = '$imagename'";
                $resultplan = mysqli_query($conn, $sqlplan)  or die("Query virker ikke - henter");
                    if(mysqli_num_rows($resultplan) == 1){
                        $planUniq = false;
                        $msgplan ="Filen er ikke oploadet. Filnavnet er tagt, omdøbt venligst fil.";
                    }else{$planUniq=true;};

                if($planUniq == true){
                    $sql = "UPDATE boligliste SET plantegning='$imagename' WHERE id_bolig='$idbolig'";

                    $usersconn = false;
                    if(mysqli_query($conn, $sql)){
                        $usersconn = true;
                    } else {
                        echo "ERROR sql " . mysqli_error($conn);
                    };

                    // image file directory
                    $target = "projekter/".$projektnavn."/".$imagename;

                    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                        $msgplan = "Filen er uploadet";
                        echo "<script>window.location.href='boligliste.php';</script>";
                    }else{
                        $msgplan = "Der skete en fejl!";
                    }
                }
            }

            //Slet img 
            if(isset($_POST['sletimg'])){
                $idbolig = mysqli_real_escape_string($conn, $_POST['idbolig']);
                $plantegning = mysqli_real_escape_string($conn, $_POST['plantegning']);
                $projektnavn = mysqli_real_escape_string($conn, $_POST['projektnavn']);

                $sql = "UPDATE boligliste SET plantegning='tom' WHERE id_bolig='$idbolig'";

                // Fobindelse til at slette 
                $sletconn = false;
                if(mysqli_query($conn, $sql)){
                    $sletconn = true;

                    $files = glob("projekter/".$projektnavn."/".$plantegning); // get all file names
                    foreach($files as $file){ // iterate files
                    if(is_file($file))
                        unlink($file); // delete file
                    };

                    echo "<script>window.location.href='boligliste.php';</script>";
                } else {
                    echo "ERROR sql " . mysqli_error($conn);
                    $msgplan = "Filen blev ikke slettet.";
                };
            }

            //Slet bolig
            if(isset($_POST['slet'])){
                $sletid = mysqli_real_escape_string($conn, $_POST['sletid']);
                $plantegning = mysqli_real_escape_string($conn, $_POST['plantegning']);
                $projektnavn = mysqli_real_escape_string($conn, $_POST['projektnavn']);

                $sql = "DELETE FROM boligliste WHERE id_bolig = '$sletid'";

                // Fobindelse til at slette bruger
                $sletconn = false;
                if(mysqli_query($conn, $sql)){
                    $sletconn = true;

                    $files = glob("projekter/".$projektnavn."/".$plantegning); // get all file names
                    foreach($files as $file){ // iterate files
                    if(is_file($file))
                        unlink($file); // delete file
                    };

                    echo "<script>window.location.href='boligliste.php';</script>";
                } else {
                    echo "ERROR sql " . mysqli_error($conn);
                    $message = "Boligen blev ikke slettet";
                };
            };


            //Tjekker URL og henter (Ret)
            if(isset($_GET['ret'])){
                $id = mysqli_real_escape_string($conn, $_GET['ret']);
                $sql = "SELECT * FROM boligliste WHERE id_bolig = $id";
                $result = mysqli_query($conn, $sql);
                $urlboligresult = mysqli_fetch_assoc($result);
            }

            //Tjekker URL og henter (plantegning/billede)
            if(isset($_GET['plan'])){
                $idplan = mysqli_real_escape_string($conn, $_GET['plan']);
                $sql = "SELECT * FROM boligliste WHERE id_bolig = $idplan";
                $result = mysqli_query($conn, $sql);
                $planresult = mysqli_fetch_assoc($result);
            }



        } else{
            echo "<script>window.location.href='index.php';</script>";
        };
    ?>
    
    <div class="container">
        <div class="row h1area">
            <div class="col-md-8">
                <h1>Boligliste</h1>
            <?php 
                echo $message.$msgplan;
            ?>
            </div>
            <div class="col-md-4 moveright">
                <button id="addcsv">+ SCV</button>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <table>
                    <thead>
                        <tr>
                            <th class="csvprint">Bolig id</th>
                            <th class="csvprint">Lejligheds nr.</th>
                            <th class="csvprint">Adresse</th>
                            <th class="csvprint">Projekt</th>
                            <th>Status</th>
                            <th></th>
                            <th></th>
                            <th>
                                <button onclick="exportTableToCSV('boligliste.csv')" class="download" id="download" ></button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($boliger as $bolig): ?>
                        <tr>
                            <td class="csvprint"><?php echo $bolig['id_bolig'] ?></td>
                            <td class="csvprint"><?php echo $bolig['lejlnr'] ?></td>
                            <td class="csvprint"><?php echo $bolig['vejnavn']." ".$bolig['husnr']." ".$bolig['side'].", ".$bolig['postnr']." ".$bolig['bypost'] ?></td>
                            <td class="csvprint">
                                <?php $projektid = $bolig['id_projekt'];
                                $sqlprojektnavn = "SELECT * FROM projekter WHERE id_projekt = $projektid";
                                $resultprojektnavn = mysqli_query($conn, $sqlprojektnavn);
                                $resultprojektnavn = mysqli_fetch_assoc($resultprojektnavn);
                                echo $resultprojektnavn['projektnavn'] ?>
                            </td>
                            <td>
                                <form method="POST">
                                    <?php $status = $bolig['status']; ?>
                                    <select class="status" name="boligstatus" onchange="this.form.submit();" style="height: 27px;font-size: 0.65rem;background: <?php if($status == 1){echo "#c60018";}else if($status == 2){echo "#6b840a";} else if($status == 3){echo '#f9a900';}  ?>;">
                                        <option value="1" <?php if($status == 1){echo 'selected';} ?>>Udlejet</option>
                                        <option value="2" <?php if($status == 2){echo 'selected';} ?>>Ledig</option>
                                        <option value="3" <?php if($status == 3){echo 'selected';} ?>>Reseveret</option>
                                    </select>
                                    <input type="hidden" name="boligid" value="<?php echo $bolig['id_bolig']; ?>">
                                </form>
                            </td>
                            <td>
                                <form>
                                    <!-- <input type="text" name="idbolig" value="" style="display:none;"> -->
                                    <input type="text" name="ret" value="<?php echo $bolig['id_bolig'] ?>" style="display:none;">
                                    <input type="submit" class="ret" id="ret" value="">
                                </form>
                            </td>
                            <td>
                                <form>
                                    <input type="text" name="plan" value="<?php echo $bolig['id_bolig'] ?>" style="display:none;">
                                    <input type="submit" class="billede" id="billede" value="">
                                </form> 
                            </td>
                            <td>
                                <form method="POST">
                                    <input type="text" name="sletid" value="<?php echo $bolig['id_bolig']; ?>" style="display:none;">
                                    <input type="hidden" name="plantegning" value="<?php echo $bolig['plantegning']; ?>">
                                    <input type="hidden" name="projektnavn" value="<?php echo $resultprojektnavn['projektnavn'] ?>">
                                    <input type="submit" name="slet" class="slet" value="">
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div><!--  Row -->
        <div class="row space">
            <div class="col-12">
                <h3>Iframe kode til boligliste</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Projekt</th>
                            <th>Iframe</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($iframeprojekter as $iframeprojekt): ?>
                        <tr>
                            <td><?php echo $iframeprojekt['projektnavn'] ?></td>
                            <td>&lt;iframe style="width:100%;height:400px;" scrolling="yes" frameborder="0" src="<?php echo $url."table.php?projekt=".$iframeprojekt['id_projekt']?>"&gt; &lt;/iframe&gt;</td>
                            <td></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div> <!--  Container -->

    <div class="popup" id="addcsvpopup"><?php include 'popup/csvadd.php' ?></div>
    <div class="popup" id="editcsvpopup"><?php include 'popup/csvedit.php' ?></div>
    <div class="popup" id="billedepopup"><?php include 'popup/billede.php' ?></div>

    <?php include 'inc/footer.php' ?>

    <script>
    // Tilføj CSV
    let addcsv = document.querySelector('#addcsv');
    let addcsvpopup = document.querySelector('#addcsvpopup');

    addcsv.addEventListener("click", function(){
        addcsvpopup.classList.remove("popup");
        addcsvpopup.classList.add("popupshow");
    });

    // Ret en bolig
    let ret = document.querySelector("#ret");
    let editcsvpopup = document.querySelector("#editcsvpopup");

   function useredit(){
        let ret = document.querySelector("#ret");
        let editcsvpopup = document.querySelector("#editcsvpopup");
        editcsvpopup.classList.remove("popup");
        editcsvpopup.classList.add("popupshow");
    };

    // Plantegning
    let billede = document.querySelector("#billede");
    let billedepopup = document.querySelector("#billedepopup");

   function plan(){
        let billede = document.querySelector("#billede");
        let billedepopup = document.querySelector("#billedepopup");
        billedepopup.classList.remove("popup");
        billedepopup.classList.add("popupshow");
    };
    

    // Luk popup - tilføj CSV
    let lukpopup = document.querySelector('#lukpopup');

    lukpopup.addEventListener("click", function(){
        addcsvpopup.classList.remove("popupshow");
        addcsvpopup.classList.add("popup");
    });

    // Luk popup - ret en bolig
    let lukpopup2= document.querySelector('#lukpopup2');

    lukpopup2.addEventListener("click", function(){
        window.location.href='boligliste.php';
    });

    // Luk popup - ret en plan/billede
    let lukpopup3= document.querySelector('#lukpopup3');

    lukpopup3.addEventListener("click", function(){
        window.location.href='boligliste.php';
    });


    //
    function downloadCSV(csv, filename) {
        var csvFile;
        var downloadLink;

        // CSV file
        csvFile = new Blob([csv], {type: "text/csv"});

        // Download link
        downloadLink = document.createElement("a");

        // File name
        downloadLink.download = filename;

        // Create a link to the file
        downloadLink.href = window.URL.createObjectURL(csvFile);

        // Hide download link
        downloadLink.style.display = "none";

        // Add the link to DOM
        document.body.appendChild(downloadLink);

        // Click download link
        downloadLink.click();
    }

    function exportTableToCSV(filename) {
        var csv = [];
        var rows = document.querySelectorAll("table tr");
        
        for (var i = 0; i < rows.length; i++) {
            var row = [], cols = rows[i].querySelectorAll("td.csvprint, th.csvprint");
            
            for (var j = 0; j < cols.length; j++) 
                row.push(cols[j].innerText);
            
            csv.push(row.join(";"));        
        }

        // Download CSV file
        downloadCSV(csv.join("\n"), filename);
    }






    </script>

<?php 
if(isset($id)){
    echo '<script>
    useredit();
    </script>';
};
?>

<?php 
if(isset($idplan)){
    echo '<script>
    plan();
    </script>';
};
?>

</body>
</html>