<div class="w-100 popupbg">
    <div class="container">
        <div class="row">
            <div class="col-md-8 ml-auto mr-auto logindboks">
                <div class="h2area">
                    <h2>Ret <?php echo "Lejlighed nr. ".$urlboligresult['lejlnr'];?></h2>
                    <div id="lukpopup2">X</div>
                </div>
                <form method="POST">
                    <div class="row">
                        <div class="col-md-4">
                            <label>vejnavn</label>
                            <input type="text" name="vejnavn" value="<?php echo $urlboligresult['vejnavn'];?>">
                        </div>
                        <div class="col-md-2">
                            <label>Hus nr.</label>
                            <input type="text" name="husnr" value="<?php echo $urlboligresult['husnr'];?>">
                        </div>
                        <div class="col-md-2">
                            <label>Etage</label>
                            <input type="text" name="etage" value="<?php echo $urlboligresult['etage'];?>">
                        </div>
                        <div class="col-md-2">
                            <label>Side</label>
                            <input type="text" name="side" value="<?php echo $urlboligresult['side'];?>">
                        </div>
                        <div class="col-md-2">
                            <label>Post nr</label>
                            <input type="text" name="postnr" value="<?php echo $urlboligresult['postnr'];?>">
                        </div>
                        <div class="col-md-4">
                            <label>By</label>
                            <input type="text" name="bypost" value="<?php echo $urlboligresult['bypost'];?>">
                        </div>
                        <div class="col-md-2">
                            <label>Kvm</label>
                            <input type="number" name="kvm" value="<?php echo $urlboligresult['kvm'];?>">
                        </div>
                        <div class="col-md-2">
                            <label>Værelse</label>
                            <input type="number" name="vaerelser" value="<?php echo $urlboligresult['vaerelser'];?>">
                        </div>
                        <div class="col-md-2">
                            <label>Leje raw</label>
                            <input type="number" name="lejeraw" value="<?php echo $urlboligresult['lejeraw'];?>">
                        </div>
                        <div class="col-md-2">
                            <label>Leje Gebyr</label>
                            <input type="number" name="lejegebyr" value="<?php echo $urlboligresult['lejegebyr'];?>">
                        </div>
                        <div class="col-md-2">
                            <label>A.c. varme</label>
                            <input type="number" name="acontovarme" value="<?php echo $urlboligresult['acontovarme'];?>">
                        </div>
                        <div class="col-md-2">
                            <label>A.c. vand</label>
                            <input type="number" name="acontovand" value="<?php echo $urlboligresult['acontovand'];?>">
                        </div>
                        <div class="col-md-4">
                            <label>Depotrum</label>
                            <input type="text" name="depotrum" value="<?php echo $urlboligresult['depotrum'];?>">
                        </div>
                        <div class="col-md-2">
                            <label>Altan</label>
                            <input type="text" name="altan" value="<?php echo $urlboligresult['altan'];?>">
                        </div>
                        <div class="col-md-2">
                            <label>Terasse</label>
                            <input type="text" name="terasse" value="<?php echo $urlboligresult['terasse'];?>">
                        </div>
                        <div class="col-md-2">
                            <label>Elevator</label>
                            <input type="text" name="elevator" value="<?php echo $urlboligresult['elevator'];?>">
                        </div>
                        <div class="col-md-2">
                            <label>Toilet</label>
                            <input type="text" name="toilet" value="<?php echo $urlboligresult['toilet'];?>">
                        </div>
                        <div class="col-md-2">
                            <label>Bad</label>
                            <input type="text" name="bad" value="<?php echo $urlboligresult['bad'];?>">
                        </div>
                        <div class="col-md-4">
                            <label>Ledig pr.</label>
                            <input type="date" name="ledigpr" value="<?php echo $urlboligresult['ledigpr'];?>">
                        </div>
                        <div class="col-md-2">
                            <label>Depositum</label>
                            <input type="text" name="depositum" value="<?php echo $urlboligresult['depositum'];?>">
                        </div>
                        <div class="col-md-4">
                            <label>Forudbetalt leje</label>
                            <input type="number" name="forudbetalt" value="<?php echo $urlboligresult['forudbetalt'];?>">
                        </div>
                        <div class="col-md-6">
                            <label>Link</label>
                            <input type="text" name="url" value="<?php echo $urlboligresult['url'];?>">
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6 moveright">
                            <input type="hidden" name="idbolig" value="<?php echo $urlboligresult['id_bolig'];?>">
                            <button name="opdaterbolig" type="submit">Opdater</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>