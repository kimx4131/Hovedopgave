<div class="w-100 popupbg">
    <div class="container">
        <div class="row">
            <div class="col-md-8 ml-auto mr-auto logindboks">
                <div class="h2area">
                    <h2>Plantegning til <?php echo "Lejlighed nr. ".$planresult['lejlnr'];?></h2>
                    <p id="imgornot" style="display: none;"><?php echo $planresult['plantegning']; ?></p>
                    <div id="lukpopup3">X</div>
                </div>
                <form method="POST" enctype="multipart/form-data" id="noimg">
                    <div class="row">
                        <?php echo "<p>".$msgplan."</p>" ?>
                        <div class="col-md-12 alignform">
                            <div style="display: inline;">
                                <input type="file" id="fileplan" name="image" accept="image/*" required onchange="fileplanprocess(this)">
                                <label for="fileplan" class="filebtn" id="uploadplan">Opload</label>

                                <input type="hidden" name="idbolig" value="<?php echo $planresult['id_bolig'] ?>">

                                <?php $projektid = $planresult['id_projekt'];
                                $sqlprojektnavn = "SELECT * FROM projekter WHERE id_projekt = $projektid";
                                $resultprojektnavn = mysqli_query($conn, $sqlprojektnavn);
                                $resultprojektnavn = mysqli_fetch_assoc($resultprojektnavn);
                                $projektnavn = $resultprojektnavn['projektnavn'] ?>

                                <input type="hidden" name="projektnavn" value="<?php echo $projektnavn ?>">
                            </div>
                            <button name="addimg" type="submit" id="oploadbtn">Opload</button>
                        </div>
                    </div>
                </form>

                <div class="row" id="hasimg">
                    <div class="col-md-12 alignform">
                        <p>Der er uploadet et billede/plantegning<br>For at uploade et nyt billede skal du slette dette</p>
                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="idbolig" value="<?php echo $planresult['id_bolig'] ?>">
                            <input type="hidden" name="plantegning" value="<?php echo $planresult['plantegning'] ?>">
                            <?php $projektid = $planresult['id_projekt'];
                                $sqlprojektnavn = "SELECT * FROM projekter WHERE id_projekt = $projektid";
                                $resultprojektnavn = mysqli_query($conn, $sqlprojektnavn);
                                $resultprojektnavn = mysqli_fetch_assoc($resultprojektnavn);
                                $projektnavn = $resultprojektnavn['projektnavn'] ?>
                            <input type="hidden" name="projektnavn" value="<?php echo $projektnavn ?>">
                            <button name="sletimg" type="submit" id="oploadbtn">slet</button>
                        </form>
                    </div>
                    <div class="col-12">
                        <img src="<?php echo "projekter/".$projektnavn."/".$planresult['plantegning'] ?>" alt="" style="width:100%;">
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
let uploadplan = document.getElementById("uploadplan");
uploadplan.innerHTML = "Vælg fil";

// function getFileExtension(filename) {
//   return filename.split('.').pop();
// }

// let fileplan = document.getElementById("fileplan");

function fileplanprocess(fileInput) {
  var files = fileInput.files;

  for (var i = 0; i < files.length; i++) {
        uploadplan.innerHTML = files[i].name;  

        // if(getFileExtension(files[i].name) != "svg"){
        //     // oploadbtn.style.display = "none";
        //     // ikkesvg.style.display = "block";
        // }
        
    }
}

//Skal billede vises eller skal der uploades.
let imgornot = document.getElementById("imgornot");
let noimg = document.getElementById("noimg");
let hasimg = document.getElementById("hasimg");

if(imgornot.innerText =="tom" || imgornot.innerText == "NULL" ){ 
    noimg.style.display ="block";
    hasimg.style.display="none";
    } else{
    noimg.style.display ="none";
    hasimg.style.display="block";
    }

</script>