<?php session_start(); ?>
<!DOCTYPE html>
<html lang="da">
<head>
    <?php include 'inc/head.php' ?>
    <title>Isometri</title>
</head>
<body>
    <?php include 'inc/db.php' ?>
    <?php include 'inc/nav.php' ?>

    <?php 
        if(isset($_SESSION['adgang'])){
            //Sorter tablen efter projekt valget i menuen
            if(isset($_SESSION['projektsorter'])){
                if($_SESSION['projektsorter'] == "NULL"){
                    $sqlisometrier = "SELECT * FROM isometri";
                    $resultisometrier = mysqli_query($conn, $sqlisometrier) or die("Query virker ikke");
                    $isometrier = mysqli_fetch_all($resultisometrier, MYSQLI_ASSOC); 
                }else{
                    $projektsorter = $_SESSION['projektsorter'];
                    $sqlisometrier = "SELECT * FROM isometri WHERE id_projekt = $projektsorter";
                    $resultisometrier = mysqli_query($conn, $sqlisometrier) or die("Query virker ikke");
                    $isometrier = mysqli_fetch_all($resultisometrier, MYSQLI_ASSOC); 
                }
            }else{
                $sqlisometrier = "SELECT * FROM isometri";
                $resultisometrier = mysqli_query($conn, $sqlisometrier) or die("Query virker ikke");
                $isometrier = mysqli_fetch_all($resultisometrier, MYSQLI_ASSOC); 
            }
            


            $iduser = $_SESSION['iduser'];

            $sqluserid = "SELECT * FROM bruger WHERE id_bruger = $iduser";
            $resultuserid = mysqli_query($conn, $sqluserid);
            $userinfo = mysqli_fetch_assoc($resultuserid);

            $username = $userinfo['navn'];
            $useridbruger = $userinfo['id_bruger'];
            $useradmin = $userinfo['admin'];

            $msgsvg = "";
            $svgUniq = true;
            $notsvgUniq = true;

            //Når der tilføjes en svg
            if(isset($_POST['oploadsvg'])){
                $projekt = mysqli_real_escape_string($conn, $_POST['valgtprojekt']);

                // Get image name
                $image = $_FILES['image']['name'];
                $imagename = basename($image);

                //Henter filnavne for at se om filnavnet er taget.
                $sqlsvg = "SELECT * FROM `isometri` WHERE isometrinavn = '$imagename'";
                $resultsvg = mysqli_query($conn, $sqlsvg)  or die("Query virker ikke - henter");
                    if(mysqli_num_rows($resultsvg) == 1){
                        $svgUniq = false;
                        $msgsvg ="SVG er ikke oploadet. Filnavnet er tagt, omdøbt venligst din SVG fil.";
                    };

                if(pathinfo($image, PATHINFO_EXTENSION) !== 'svg'){
                    $notsvgUniq = false;
                    $msgsvg = "Fil er ikke oploadet. <br/>Du har ikke valgt en SVG fil. Det skal være en SVG fil.";
                } 

                if($svgUniq == true AND $notsvgUniq == true){
                    // image file directory
                    $target = "img/svg/".$imagename;

                    $sqluploadsvg = "INSERT INTO `isometri` (`id_isometri`, `isometrinavn`, `id_projekt`) VALUES (NULL, '$imagename', '$projekt');";
                    $result = mysqli_query($conn, $sqluploadsvg) or die("Query virker overhoved ikke - upload");

                    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                        $msgsvg = "Filen er uploadet";
                        echo "<script>window.location.href='isometri.php';</script>";
                    }else{
                        $msgsvg = "Der skete en fejl!";
                    }
                }
            };

            //Slet svg 
            if(isset($_POST['slet'])){
                $sletid = mysqli_real_escape_string($conn, $_POST['sletid']);
                $filename = mysqli_real_escape_string($conn, $_POST['filename']);

                $sql = "DELETE FROM isometri WHERE id_isometri = '$sletid'";

                // Fobindelse til at slette 
                $sletconn = false;
                if(mysqli_query($conn, $sql)){
                    $sletconn = true;

                    $files = glob('img/svg'.$filename); // get all file names
                    foreach($files as $file){ // iterate files
                    if(is_file($file))
                        unlink($file); // delete file
                    };

                    echo "<script>window.location.href='isometri.php';</script>";
                } else {
                    echo "ERROR sql " . mysqli_error($conn);
                    $msgsvg = "SVG filen blev ikke slettet.";
                };
            };

            //Tjekker URL og henter
            if(isset($_GET['idisometri'])){
                $id = mysqli_real_escape_string($conn, $_GET['idisometri']);
            }

        } else{
            echo "<script>window.location.href='index.php';</script>";
        };
    ?>
    
    <div class="container">
        <div class="row h1area">
            <div class="col-md-8">
                <h1>Isometri</h1>
            </div>
            <div class="col-md-4 moveright">
                <button id="addsvg">+ SVG</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
            <?php echo '<p>'.$msgsvg.'</p>' ?>
                <table>
                    <thead>
                        <tr>
                            <th>Navn</th>
                            <th>Projekt</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($isometrier as $isometri):?>
                        <tr>
                            <td><?php echo $isometri['isometrinavn'] ?></td>
                            <td>
                                <?php $projektid = $isometri['id_projekt'];
                                $sqlprojektnavn = "SELECT * FROM projekter WHERE id_projekt = $projektid";
                                $resultprojektnavn = mysqli_query($conn, $sqlprojektnavn);
                                $resultprojektnavn = mysqli_fetch_assoc($resultprojektnavn);
                                echo $resultprojektnavn['projektnavn'] ?>
                            </td>
                            <td>
                                <form>
                                    <input type="text" name="idisometri" value="<?php echo $isometri['id_isometri'] ?>" style="display:none;">
                                    <input type="submit" class="kode" id="seeiframekode" value="">
                                </form>
                            </td>
                            <td>
                                <?php if($useradmin == "ja" OR $username == $useridinfoname['navn']){
                                        $isometriid = $isometri['id_isometri'];
                                        $isometrifilnavn = $isometri['isometrinavn'];
                                        echo'
                                        <form method="POST">
                                        <!-- <img src="img/icons/slet.png" alt="ret ikon"> -->
                                        <input type="text" name="sletid" value="'.$isometriid.'" style="display:none;">
                                        <input type="text" name="filename" value="'.$isometrifilnavn.'" style="display:none;">
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
        </div>
    </div>

    <div class="popup" id="svgaddpopup"><?php include 'popup/svgadd.php' ?></div>
    <div class="popup" id="iframepopup"><?php include 'popup/link.php' ?></div>

    <?php include 'inc/footer.php' ?>

    <script>
        // Tilføj et projekt
        let addsvg = document.querySelector('#addsvg');
        let svgaddpopup = document.querySelector('#svgaddpopup');

        addsvg.addEventListener("click", function(){
            svgaddpopup.classList.remove("popup");
            svgaddpopup.classList.add("popupshow");
        });

        // Luk popup - tilføj et projekt
        let lukpopup = document.querySelector('#lukpopup');

        lukpopup.addEventListener("click", function(){
            svgaddpopup.classList.remove("popupshow");
            svgaddpopup.classList.add("popup");
        });


        // se iframe kode
        let seeiframekode = document.querySelector("#seeiframekode");
        let iframepopup = document.querySelector("#iframepopup");

        function useredit(){
            let seeiframekode = document.querySelector("#seeiframekode");
            let iframepopup = document.querySelector("#iframepopup");
            iframepopup.classList.remove("popup");
            iframepopup.classList.add("popupshow");
        };


        // Luk popup - ret bruger
        let lukpopup2= document.querySelector('#lukpopup2');

        lukpopup2.addEventListener("click", function(){
            window.location.href='isometri.php';
        });

    </script>

<?php 
//Kan først kalde funtionen efter den er indlæst
if(isset($id)){
    echo '<script>
    useredit();
    </script>';
};
?>

</body>
</html>