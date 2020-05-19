<?php 
    $vejledninger = "";
    if(isset($_SESSION['adgang'])){
        $vejledninger = '
        <p>
            <a href="vejledning.php">Vejledning</a>
        </p>
        <p>
            <a href="vejledning.php#step1">Step 1: Opret projekt</a>
        </p>
        <p>
            <a href="vejledning.php#step2">Step 2: CSV filen</a>
        </p>
        <p>
            <a href="vejledning.php#step3">Step 3: Isometri</a>
        </p>';
    };
?>

<footer>   
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <img src="img/logo.png" alt="" class="logo">
                    </div>
                    <div class="col-12 col-md-4">
                        <a href="mailto:web@newsec.dk">web@newsec.dk</a>
                    </div>
                    <div class="col-12 col-md-4">
                        <?php echo $vejledninger; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>