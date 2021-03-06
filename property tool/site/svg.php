<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'inc/head.php' ?>
    <title>Isometri</title>

    <style>
    @font-face{
        font-family: 'interstatecompressed';
        src: url('font/interstate-boldcompressed-webfont.eot');
        src: url('font/interstate-boldcompressed-webfont.eot') format('embedded-opentype'),
         url('font/interstate-boldcompressed-webfont.woff2') format('woff2'),
         url('font/interstate-boldcompressed-webfont.woff') format('woff'),
         url('font/interstate-boldcompressed-webfont.ttf') format('truetype'),
         url('font/interstate-boldcompressed-webfont.svg#interstate-boldcompressed-webfont') format('svg'); 
    }

    @font-face {
    font-family: 'interstate';
    src: url('font/interstate-light-webfont.eot');
    src: url('font/interstate-light-webfont.eot') format('embedded-opentype'),
         url('font/interstate-light-webfont.woff2') format('woff2'),
         url('font/interstate-light-webfont.woff') format('woff'),
         url('font/interstate-light-webfont.ttf') format('truetype'),
         url('font/interstate-light-webfont.svg#interstate-light-webfont') format('svg');
    }

        polygon{
            opacity: 0.7;
        }

        .popup{
            display: none;
            position: absolute;
            width: 120px;
            padding: 10px;
            text-align: left;
            color: black;
            background: rgb(246, 245, 237);
            top: 150px;
            left:300px;
            border: 1px solid lightgrey;
            width: 400px;
            
        }

        .popup p{
            margin:0;
        }

        hr{
            margin-top:0.5rem;
            margin-bottom:0.5rem;
        }

        .banner{
            transform: rotate(-45deg);
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: space-evenly;
            position: absolute;
            top: 31px;
            left: -37px;
            width: 200px;
        }

        .nobanner{
            display:none;
        }

        .banner p {
            display: inline-block;
            position: absolute;
            padding: 6px;
            text-transform: uppercase;
            font-weight:normal;
        }

        .reseveretpopup{
            border-bottom: 35px solid rgba(252, 215, 3, 0.85); /*Gul*/
            border-left: 35px solid transparent;
            border-right: 35px solid transparent;
            width: 100%;
        }

        .udlejerpopup{
            border-bottom: 35px solid rgba(196, 33, 39, 0.85);/*Rød*/
            border-left: 35px solid transparent;
            border-right: 35px solid transparent;
            width: 100%;
        }

        small{
            font-weight: 200;
            color:grey;
        }

        .popupheader{
            font-family: 'interstatecompressed', Arial, sans-serif;
            font-size: 1.65rem;
            line-height: 1.65rem;
            text-transform: uppercase;
        }

        .informationarea img{
            width:100%;
            z-index: 8;
            position: inherit;
            filter: invert(1);
            margin-left: 3.2px;
            padding: 1px;
        }

        .cirkelimg{
            background-color: grey;
            width: 120%;
            height: 120%;
            position: absolute;
            top: -4px;
            border-radius: 50%;
        }

        .informationarea .row{
            margin-right: 0;
            margin-left: 0;
        }

        .informationarea .colnopadding .col-4{
            padding: 0;
        }

        .colnopadding{
            margin-top:10px;
            align-items: center;
        }

        .colnopadding .col-3{
            padding-right:0;
        }

        .colnopadding .col-9{
            padding-left:7px;
            padding-right:0;
            line-height: 0.95rem;
        }

        .prisarea{
            text-align:center;
            line-height:0.95rem;
        }

        .prisarea small{
            display:block;
        }

        polygon:hover{
            fill:blue;
            cursor: pointer;
        }

        .popupclose{
            display: flex;
            justify-content: flex-end;
        }

        .mobillink .col-12{
            display:flex;
            justify-content: center;
            margin-top: 10px;
        }
        

    </style>
</head>
<body>
    <?php include 'inc/db.php'?>

    <?php
        $id = mysqli_real_escape_string($conn, $_GET['id_isometri']);
        $query = 'SELECT * FROM isometri WHERE id_isometri = '.$id;
        $result = mysqli_query($conn, $query);
        $isometri = mysqli_fetch_assoc($result);
        $projektidfromis = $isometri['id_projekt'];

        $sqlboliger = "SELECT * FROM boligliste WHERE id_projekt = $projektidfromis";
        $resultboliger = mysqli_query($conn, $sqlboliger) or die("Query virker ikke");
        $boliger = mysqli_fetch_all($resultboliger, MYSQLI_ASSOC); 

        $urlsvg =  'img/svg/'.$isometri['isometrinavn'];
        $myfile = fopen("$urlsvg", "r") or die("Unable to open file!");
        echo stream_get_contents($myfile);

        
    ?>


    <?php foreach($boliger as $bolig): 
        //Boligstatus
        if($bolig['status'] == '1'){
            $ikkeledig = "Udlejet";
            $ikkeledigclass = "udlejerpopup";
            $banner = "banner";
        } else if ($bolig['status'] == '2'){
            $ikkeledig = "";
            $ikkeledigstyle ="";
            $banner = "nobanner";
        } else if ($bolig['status'] == '3'){
            $ikkeledig = "Reseveret";
            $ikkeledigclass = "reseveretpopup";
            $banner = "banner";
        };

        //Projekt navn til pantegning sti
        $projektid = $bolig['id_projekt'];
        $sqlprojekt = "SELECT * FROM projekter WHERE id_projekt = $projektid";
        $resultprojekt = mysqli_query($conn, $sqlprojekt) or die("Query virker ikke");
        $projekt = mysqli_fetch_assoc($resultprojekt);
        ?>

        <div id="pop<?php echo $bolig['id_bolig'] ?>" class="popup">
            <div class="status<?php echo $bolig['status'] ?>">
            <a href="<?php echo $bolig['url'] ?>"></a>
                <div class="row">
                    <div class="col-9">
                        <div class="<?php echo $banner ?>">
                            <p><?php echo $ikkeledig ;?></p>
                            <div class="<?php echo $ikkeledigclass;?>"></div>
                        </div>
                        <p class="popupheader"><?php echo $bolig['vejnavn']." ".$bolig['husnr']." ".$bolig['etage']." ".$bolig['side'] ?></p>
                        <small>Lejlighed <?php echo $bolig['lejlnr'] ?></small>
                    </div>
                    <div class="col-3 popupclose"><p>X</p></div>
                </div>

                <img src="<?php echo 'projekter/'.$projekt['projektnavn'].'/'.$bolig['plantegning'] ?>" alt="Plantegning" style="width:100%;">

                <div class="row informationarea">

                        <div class="row colnopadding col-4">
                            <div class="col-4">
                                <img src="img/icons/areal.png" alt="Ikon">
                                <div class="cirkelimg"></div>
                            </div>
                            <div class="col-8">
                                <p><?php echo $bolig['kvm']?><small>m<sup>2</sup></small></p>
                            </div>
                        </div>

                        <div class="row colnopadding col-4">
                            <div class="col-4">
                                <img src="img/icons/etage.png" alt="Ikon">
                                <div class="cirkelimg"></div>
                            </div>
                            <div class="col-8">
                                <p><?php if($bolig['etage'] == 0){
                                    echo "Stue";
                                } else{
                                    Echo $bolig['etage'];
                                } ?></p>
                                <small>Etage</small>
                            </div>
                        </div>

                        <div class="row colnopadding col-4">
                            <div class="col-4">
                                <img src="img/icons/room.png" alt="Ikon">
                                <div class="cirkelimg"></div>
                            </div>
                            <div class="col-8">
                                <p><?php echo $bolig['vaerelser'] ?></p>
                                <small><?php if($bolig['vaerelser'] == 1){
                                    echo "Værelse";
                                }else{
                                    echo "Værelser";
                                } ?></small>
                            </div>
                        </div>

                        <div class="row colnopadding col-4">
                            <div class="col-4">
                                <img src="img/icons/elevator.png" alt="Ikon">
                                <div class="cirkelimg"></div>
                            </div>
                            <div class="col-8">
                                <p><?php if($bolig['elevator'] == 0){
                                    echo "Nej";
                                } else{
                                    echo "Ja";
                                } ?></p>
                                <small>Elevator</small>
                            </div>
                        </div>

                        <div class="row colnopadding col-4">
                            <div class="col-4">
                                <img src="img/icons/shower.png" alt="Ikon">
                                <div class="cirkelimg"></div>
                            </div>
                            <div class="col-8">
                                <p><?php echo $bolig['bad'] ?></p>
                                <small><?php if($bolig['bad'] == 1){
                                    echo "Bad";
                                } else{
                                    echo "Bade";
                                } ?></small>
                            </div>
                        </div>

                        <div class="row colnopadding col-4">
                            <div class="col-4">
                                <img src="img/icons/toilet.png" alt="Ikon">
                                <div class="cirkelimg"></div>
                            </div>
                            <div class="col-8">
                                <p><?php echo $bolig['toilet'] ?></p>
                                <small><?php if($bolig['toilet'] == 1){
                                    echo "Toilet";
                                }else{
                                    echo "Toileter";
                                } ?></small>
                            </div>
                        </div>

                        <?php if($bolig['altan'] != 0){
                            if($bolig['altan'] == 0 OR $bolig['altan'] == 1){
                                $textaltan = "Altan";
                            }else {
                                $textaltan = "Altaner";
                            } 

                            echo '<div class="row colnopadding col-4">
                            <div class="col-4">
                                <img src="img/icons/altan.png" alt="Ikon">
                                <div class="cirkelimg"></div>
                            </div>
                            <div class="col-8"><p>'.$bolig['altan'].'</p>
                            <small>'.$textaltan.'</small>
                            </div>
                            </div>';
                            }
                        ?>

                        <?php if($bolig['terasse'] != 0){
                            if($bolig['terasse'] == 0 OR $bolig['terasse'] == 1){
                                $textterrasse = "Terrasse";
                            }else{
                                $textterrasse = "Terrasser";
                            } 

                            echo '<div class="row colnopadding col-4">
                            <div class="col-4">
                                <img src="img/icons/terasse.png" alt="Ikon">
                                <div class="cirkelimg"></div>
                            </div>
                            <div class="col-8">
                                <p>'.$bolig['terasse'].'</p>
                                <small>'.$textterrasse.'</small>
                                </div>
                            </div>';
                        }
                        ?>
                    
                </div>
                <hr>
                <div class="prisarea">
                    <?php 
                        if($bolig['status'] == '1'){
                            echo "<p>Boligen er udlejet</p>";
                        }else{
                            echo "<p>Leje: " .number_format($bolig['lejeraw'], 0, ',', '.'). ",-</p>
                            <small>Aconto varme: " .number_format($bolig['acontovarme'],0,',','.'). ",-</small>       
                            <small>Aconto vand: " .number_format($bolig['acontovand'],0,',','.'). ",-</small>        
                            <small>Depositum + forudbetalt: " .number_format(($bolig['depositum']*$bolig['lejegebyr'])+($bolig['forudbetalt']*$bolig['lejegebyr']),0,',','.'). ",-</small>";
                        }
                    ?>
                </div>
                <div class="row mobillink">
                    <div class="col-12">
                        <button>se mere</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>


    <script>   

    let mobiluser = false;
    //Hvis matcher regex (i = case-insensitive)
    if( navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/webOS/i) || navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPod/i) || navigator.userAgent.match(/BlackBerry/i) || navigator.userAgent.match(/Windows Phone/i)){
        mobiluser = true;
    }else{
        mobiluser = false;
        let popupclose = document.getElementsByClassName('popupclose');
        let mobillink = document.getElementsByClassName('mobillink');

        for(k=0;k<popupclose.length; k++){
            popupclose[k].style.display = "none";
        }

        for(k=0;k<mobillink.length; k++){
            mobillink[k].style.display = "none";
        }
    }

    let i;

    //laver htmlcollection med g tags  
    let idarray = document.getElementsByTagName("g");

    //laver htmlcollection til array uden nr.
    let singelid = [];
    for(i = 0;i < idarray.length; i++){
        let singel = idarray[i].id;
        singelid.push(singel.slice(2));
    };
    //De første to i arryen er baggrund og lejlighed, dem fjerne jeg
    singelid.shift();
    singelid.shift();
    
    //Gennemgår arrayen "singelid"
    for(i=0;i<singelid.length; i++){
        //Henter popupen og får klasse navnet
        childofpopup = document.getElementById('pop'+singelid[i]).children;
        classofpopup = childofpopup[0].className;

        for(j=0;j<childofpopup.length;j++){
            let classliste = childofpopup[j].className;
        }
        //Hvis klasse navnet er ....
        if(classofpopup == "status2"){
            //Henter polygonen
            let ledig = document.getElementById('nr'+singelid[i]).children;
            ledig[0].style.fill="transparent";
            //Farve polygonen når mussen kommer ind over den
            ledig[0].addEventListener('mouseover', function(){
                ledig[0].style.fill="b2d234"; //Grøn
            });
            ledig[0].addEventListener('mouseout', function(){
                ledig[0].style.fill="transparent";
            });

        } else if(classofpopup == "status1"){
            //Henter polygonen og farver
            let ledig = document.getElementById('nr'+singelid[i]).children;
            ledig[0].style.fill="#c62127"; //Rød

        }else if(classofpopup == "status3"){
            //Henter polygonen og farver
            let ledig = document.getElementById('nr'+singelid[i]).children;
            ledig[0].style.fill="#fcd703"; //Gul
        }
    }

    //Lytter på alle polygoner og "afspiller" funktioner ved mus over og ud
    let theParent = document.querySelector("#Lejligheder");
    for (i = 0; i < theParent.children.length; i++) {
        let childElement = theParent.children[i];
        childElement.addEventListener('mouseover', mouseover);
        childElement.addEventListener('mouseout', mouseout);
    }

    // Hvad der skal gøre ved mus over
    function mouseover() {
        //Henter id når man mouseover
        let boksid = this.id.slice(2);
        let boks = document.getElementById('pop'+boksid);
        let bokspoligon = document.getElementById('nr'+boksid);

        boks.style.display = "block";

        //Størrelse på popup vinduet
        let popupwidth = boks.offsetWidth; //400
        let popupheight = boks.offsetHeight; //525

        //Størrelse på billedet som danner iframe
        let windowwidth = document.getElementsByTagName('image')[0].width.animVal.value; //1000
        let windowheigth = document.getElementsByTagName('image')[0].height.animVal.value; //667

        //Henter musen posistion ud fra den side som iframes
        let x = event.clientX;
        let y = event.clientY;

        //Hvis det er fra mobilen eller tablets
        if(mobiluser == true){
            //Popup fylder hele iframen
            boks.style.display = "block";
            boks.style.top = "0px";
            boks.style.left = "0px";
            boks.style.width = "100%";
            boks.style.height = "100%";

            //Hvis der klikkes på mere knappen
            let readmorebtn = boks.getElementsByTagName('button')[0];
            readmorebtn.addEventListener('click', function hiddenfunc(){
                togolink(boksid);
            }); 

            //Hvis der klikkes på kryds
            let test = boks.getElementsByClassName('popupclose')[0];
            test.addEventListener('click', function hiddenfunc(){
                boks.style.display = "none";
            });

        }else{
            //Fra computeren
            //WIDTH
            //Hvis afstanden fra musen x til kanten højre er mindre en popupens brede
            if((windowwidth - x)<popupwidth){
                //Placere popupboksen på venstre side af musen
                boks.style.left = (x-popupwidth-10)+'px';
            } else{
                boks.style.left = (x+10)+'px';
            }

            //HEIGHT
            //Hvis afstanden fra musen y til bunden er mindre en højden på popupen
            if((windowheigth - y)<popupheight){
                //Placere popupen over musen
                //Tjekker om popupen er højre end fra musen til toppen
                if(popupheight > y){
                    //Placere popupen over musen og flytter ned ned det stykke som går over kanten
                    boks.style.top = ((y-popupheight)+(popupheight-y))+'px';
                }else{
                    //Placere popupen over musen
                    boks.style.top = (y-popupheight-10)+'px';
                }

            } else {
                boks.style.top = (y+10)+'px';
            }

            //Hvis der klikkes på polygonen
            bokspoligon.addEventListener('click', function hiddenfunc(){
                togolink(boksid);
            }); 
        }
    }

    function mouseout() {
        let boksid = this.id.slice(2);
        let boks = document.getElementById('pop'+boksid);

        if(mobiluser == false){
            boks.style.display = "none";
        }
        
    }

    //Åbener en ny side med flere informationer hvos status er ledig
    function togolink(boksid){
        let boks = document.getElementById('pop'+boksid);
        let link = boks.firstElementChild;

        if(link.className != "status1"){
            window.open(link.firstElementChild.href, '_blank');
        }
    }

    </script>

</body>
</html>