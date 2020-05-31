<?php session_start(); ?>
<!DOCTYPE html>
<html lang="da">
<head>
    <?php include 'inc/head.php' ?>
    <title>Vejledning</title>
</head>
<body>
    <?php include 'inc/db.php' ?>
    <?php include 'inc/nav.php' ?>

    <?php
    if(isset($_SESSION['adgang'])){
    } else{
        echo "<script>window.location.href='index.php';</script>";
    };
    ?>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 id="test">Vejledninger</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-3 tabmenu">
                <a href="#intro" class="sidemenu" id="tabintro" onclick="funcintro()">Intro</a>
                <a href="#step1" class="sidemenu" id="tabstep1" onclick="funcstep1()">Step 1: Opret nyt projekt</a>
                <a href="#step2" class="sidemenu" id="tabstep2" onclick="funcstep2()">Step 2: Upload CSV fil </a>
                <a href="#step3" class="sidemenu" id="tabstep3" onclick="funcstep3()">Step 3: Isometri</a>
            </div>
            <div class="col-9">
                <div id="intro">
                    <h3>Intro</h3>
                    <p>Der er flere steps med til at få en interaktiv arkitekttegning aka. isometri.<br>Vejledningen er del op i tre overordnede dele. Nogle af opagverne vil web teamet klare, andre opgaver skal du selv klare.</p>
                    <ul>
                        <li><a href="#step1">Step 1: Opret nyt projekt</a></li>
                        <li><a href="#step2">Step 2: Upload CSV fil</a></li>
                        <li><a href="#step3">Step 3: Isometri</a></li>
                    </ul>
                    <p>Her på siden kan du også finde svar på diverse spørgsmål.</p>
                    <p>Har du nogle spørgsmål er du velkommen til at kontakte web afdelingen på <a href="mailto:web@newsec.dk?Subject=Spørgsmål%20ang.%20isometri">web@newsec.dk</a></p>
                    <b>Som udgngspunkt skal du bruge følgende:</b>
                    <ul>
                        <li>Informationer omkring ejendommene/lejlighederne</li>
                        <li>Plantegninger</li>
                        <li>Arkitekt tegning</li>
                    </ul>
                </div>
                <div id="step1">
                    <h3>Step 1: Opret nyt projekt</h3>
                    <p>Før at der kan oploades noget til hjemmesiden skal der først oprettes et projekt.</p>
                    <p>Du kan på <a href="projekt.php">projekt siden</a> oprette et nyt projekt. Det projekt du opretter skal have et unikt navn, dvs. det projekt du opretter må ikke have sammen navn som et allerede eksiterende projekt.</p>
                    <h4>Sådan opretter du et nyt projekt</h4>
                    <ol>
                        <li>Gå til <a href="projekt.php">projekt siden</a></li>
                        <li>Klik på knappen "+ projekt"</li>
                        <li>Indtast navnet på dit projekt og klik på opret</li>
                    </ol>
                    <p><a href="#step2">Gå til step 2: Upload CSV fil</a></p>
                </div>
                <div id="step2">
                    <h3>Step 2: Upload CSV fil</h3>
                    <p>Før at isometrien kan laves, skal du udfylde et Excel ark med informationer omkring ejendommen i dit projekt. Dette er fordi at ejendoms/lejligheds numrene skal matches med et systemnummer og disse to numre skal bruges til at lave isometrien.</p>
                    <h4>Sådan laver du Excel filen</h4>
                    <ol>
                        <li><a href="img/skabelone.csv" target="_blank">Download skabelonen her</a></li>
                        <li>Udfyld skabelonen, jo mere du kan udfylde, jo bedre<br>Du må ikke fjerne eller tilføje kolonner i Excel arket 
                            <ul>
                                <b>Beskrivelse af felterne</b>
                                <li><b>id_bolig:</b> Skal udfyldes med "NULL"</li>
                                <li><b>lejlnr:</b> Skriv ejendoms/område/lejligheds nummer</li>
                                <li><b>id_projekt:</b> Skal udfyldes med "NULL"</li>
                                <li><b>postnr:</b> Skriv det post nummer ejendommen er i (Kun tal)</li>
                                <li><b>vejnavn:</b> Skriv vejnavnet og kun vejnavnet</li>
                                <li><b>husnr:</b> Skriv hus nummer (Kun tal)</li>
                                <li><b>etage:</b> skriv 0 eller stue for stueetage, 1 for første sal osv. Er dette ikke relevant lad felt være tomt.</li>
                                <li><b>side:</b> f.eks. th, tv, lejl 1, a, b osv. Er dette ikke relevant lad felt være tomt</li>
                                <li><b>bypost:</b> By navn</li>
                                <li><b>kvm:</b> kvm størrelsen på ejendomen/lejligheden/enheden</li>
                                <li><b>vaerelser:</b> Antal værelser i ejendommen/lejligheden/enheden</li>
                                <li><b>lejeraw:</b> Lejen uden gebyrer (Kun tal)</li>
                                <li><b>Lejegebyr:</b> Lejen med gebyrer</li>
                                <li><b>acontovarme:</b> prisen på aconto varme (Kun tal). Er dette ikke relevant lad felt være tomt </li>
                                <li><b>acontovand</b> prisen på aconto vand (Kun tal). Er dette ikke relevant lad felt være tomt </li>
                                <li><b>depositum:</b> oplyst i antal måneder (kun tal)</li>
                                <li><b>forudbetalt:</b> Oplyst i antal måneder (kun tal)</li>
                                <li><b>toilet:</b> Nummer på antal toiletter</li>
                                <li><b>bad:</b> Nummer på antal bade</li>
                                <li><b>ledigpr:</b> Datoen skal skrive dd.mm.åååå</li>
                                <li><b>boligstatus:</b> 1 = udleje, 2 = ledig, 3 = reseveret</li>
                                <li><b>plantegning:</b> Navnet på plantegning billedet f.eks. lejl2b.jpg. Har du ikke dette klar skriv "NULL" eller "tom"</li>
                                <li><b>url:</b> URL'en til ejendomen på portal.newsec.dk</li>
                                <li><b>deportum:</b> antal depotum og evt. hvor de er. Feltet kan efterlades tomt</li>
                                <li><b>altan:</b> antal antaler. Kan efterledes tomt</li>
                                <li><b>terasser:</b> antal terasser. Kan efterlades tomt</li>
                                <li><b>Elevator:</b> 1 = ja, 0 = nej</li>
                            </ul>
                            <li>Konverter Excel filen til en CSV fil. <br>Web teamet kan hjælpe med dette<br>CSV filen skal være semikolon(;) seperaret</li>
                            <li>Efter at Excel filen er konverteret skal den øverste linje med overskrifterne slettes<br>Web teamet kan hjælpe</li>
                            <li>Gå til <a href="boligliste.php">boligliste siden</a></li>
                            <li>Klik på "+ CSV"</li>
                            <li>Vælg din CSV fil, vælg projektet og klik på upload.<br>Web teamet kan hjælpe</li>
                        </li>
                        <li>Hvis du i filen har skrevet filnavnet på plantegningerne skal du sende billederne til web teamet på <a href="mailto:web@newsec.dk">web@newsec.dk</a><br>Hvis du ikke har skrevet filnavnet på plantegninger, kan du selv opload billederne efter at filen er indlæst.</li>
                        <ul>
                            <b>Sådan tilføjer du en plantegning til en ejendom/bolig</b>
                            <li>Gå til <a href="boligliste.php">boligliste siden</a></li>
                            <li>Vælg dit projekt i sorteringts knappen i menuen</li>
                            <li>Ud for hver ejendom/lejlighed er det er billede ikoner. Når du klikker på det, kan du vælge et billede til den ejendom/bolig.</li>
                        </ul>
                    </ol>
                    <p><a href="#step3">Gå til step 3: Isometri</a></p>
                </div>
                <div id="step3">
                    <h3>Step 3: Isometri</h3>
                    <p>Det sidste step er primært web teamet som skal klare.</p>
                    <h4>Her er hvad du skal gøre:</h4>
                    <ol>
                        <li>Gå ind på <a href="boligliste.php">boligliste siden</a></li>
                        <li>Bruge knappen i menuen til at sortere efter dit projekt</li>
                        <li>Klik på download ikonet i tabellen</li>
                        <li>Send den downloade fil samt arkitekttegningerne til web teamet på <a href="mailto:web@newsec.dk">web@newsec.dk</a></li>
                        <li>Web teamet laver isometrien/erne og ligger dem på her på siden</li>
                        <li>Afhængig af hvad der er aftalt med web teamet så vil de ligge isometrien på kampagnesiderne eller sende et kode strykke til dig</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <?php include 'inc/footer.php' ?>

    <script>
        let url = window.location.href;
        let seturl = "http://localhost:8888/tool/site/vejledning.php";

        let tabintro = document.getElementById('tabintro');
        let tabstep1 = document.getElementById('tabstep1');
        let tabstep2 = document.getElementById('tabstep2');
        let tabstep3 = document.getElementById('tabstep3');
        
        let intro = document.getElementById('intro');
        let step1 = document.getElementById('step1');
        let step2 = document.getElementById('step2');
        let step3 = document.getElementById('step3');


        tabmenu();

        function tabmenu(){
            if(url == seturl || url==seturl+"#intro" ){
                tabintro.classList.add("sidemenushow");
                tabstep1.classList.remove("sidemenushow");
                tabstep2.classList.remove("sidemenushow");
                tabstep3.classList.remove("sidemenushow");

                intro.style.display="block";
                step1.style.display="none";
                step2.style.display="none";
                step3.style.display="none";

            }else if(url == seturl+"#step1"){
                tabintro.classList.remove("sidemenushow");
                tabstep1.classList.add("sidemenushow");
                tabstep2.classList.remove("sidemenushow");
                tabstep3.classList.remove("sidemenushow");

                intro.style.display="none";
                step1.style.display="block";
                step2.style.display="none";
                step3.style.display="none";

            }else if(url == seturl+"#step2" ){
                tabintro.classList.remove("sidemenushow");
                tabstep1.classList.remove("sidemenushow");
                tabstep2.classList.add("sidemenushow");
                tabstep3.classList.remove("sidemenushow");

                intro.style.display="none";
                step1.style.display="none";
                step2.style.display="block";
                step3.style.display="none";

            }
            else if(url == seturl+"#step3" ){
                tabintro.classList.remove("sidemenushow");
                tabstep1.classList.remove("sidemenushow");
                tabstep2.classList.remove("sidemenushow");
                tabstep3.classList.add("sidemenushow");

                intro.style.display="none";
                step1.style.display="none";
                step2.style.display="none";
                step3.style.display="block";

            }
        }
        
        function funcintro(){
            url = seturl+"#intro";
            tabmenu();
        }
        function funcstep1(){
            url = seturl+"#step1";
            tabmenu();
        }
        function funcstep2(){
            url = seturl+"#step2";
            tabmenu();
        }
        function funcstep3(){
            url = seturl+"#step3";
            tabmenu();
        }

    </script>
</body>
</html>