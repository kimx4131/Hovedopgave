

<div class="w-100 popupbg">
    <div class="container">
        <div class="row">
            <div class="col-md-8 ml-auto mr-auto logindboks">
                <div class="h2area">
                    <h2>Kodeord</h2>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p>Du har et standard kodeord. Du skal ændre dit kodeord.</p>
                        <?php echo $passworderrormsg ?>
                    </div>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="password" name="passwordone" placeholder="Kodeord" required>
                        </div>
                        <div class="col-md-6">
                            <input type="password" name="passwordtwo" placeholder="Gentag kodeord" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 moveright">
                            <button name="changepassword" type="submit">Ændre</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

