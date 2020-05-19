

<div class="w-100 popupbg">
    <div class="container">
        <div class="row">
            <div class="col-md-8 ml-auto mr-auto logindboks">
                <div class="h2area">
                    <h2>Tilføj CSV</h2>
                    <div id="lukpopup">X</div>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12 alignform">
                            <div>
                                <input type="file" name="file" id="file" required accept=".csv" onchange="processSelectedFiles(this)">
                                <label for="file" class="filebtn" id="uploadcsvtekst">Opload</label>
                            </div>

                            <select name="valgtprojekt" class="valgtprojekt">
                                <option disabled selected value>Vælg projekt</option>
                                <?php
                                $sqlprojekt = "SELECT * FROM projekter";
                                $resultprojekt = mysqli_query($conn, $sqlprojekt) or die("Query virker ikke");
                                $projekter = mysqli_fetch_all($resultprojekt, MYSQLI_ASSOC); 
                                foreach($projekter as $projekt): ?>
                                    <option value="<?php echo $projekt['id_projekt'] ?>"><?php echo $projekt['projektnavn'] ?></option>
                                <?php endforeach; ?>
                            </select>

                            <button name="oploadcsv" type="submit" id="oploadbtn">Opload</button>
                            <!-- <p id="ikkecsv">Det skal være en CSV fil.</p> -->
                        </div>
                    </div>
                    

                </form>
            </div>
        </div>
    </div>
</div>

<script>
let uploadcsvtekst = document.getElementById("uploadcsvtekst");
uploadcsvtekst.innerHTML = "Vælg fil";

let oploadbtn = document.getElementById("oploadbtn");

let ikkecsv = document.getElementById("ikkecsv");
ikkecsv.style.display = "none";


function getFileExtension(filename) {
  return filename.split('.').pop();
}

function processSelectedFiles(fileInput) {
  var files = fileInput.files;

  for (var i = 0; i < files.length; i++) {
        uploadcsvtekst.innerHTML = files[i].name;  

        if(getFileExtension(files[i].name) != "csv"){
            oploadbtn.style.display = "none";
            ikkecsv.style.display = "block";
        }
        
    }
}
</script>
