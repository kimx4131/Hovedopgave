<?php 
  $admin = "";
  $servicenav = "";

  if(isset($_SESSION['adgang'])){
    $servicenav = '
    <li class="nav-item">
        <a class="nav-link" href="logud.php" id="navbarDropdownMenuLink" aria-expanded="false">Log ud</a>
    </li>';


    if($_SESSION['type'] == "ja"){
      $admin = '
      <li class="nav-item">
          <a class="nav-link" href="brugeradmin.php" aria-haspopup="true" aria-expanded="false">Brugeradmin</a>
      </li>';
    };
  } else{
    $servicenav = '
    <li style="height:24px;"></li>';
  };


  if(isset($_SESSION['projektsorter'])){

  } else {
    $_SESSION['projektsorter'] = NULL;
  }

  if(isset($_POST['valgteprojekt'])){
    $_SESSION['projektsorter'] = mysqli_real_escape_string($conn, $_POST['valgteprojekt']);
  }
  
?>

<nav class="navbar navbar-expand-md navbar-white">
    <div class="navbar-toggler-right">
        <a href="index.php" id="toogle-logo">
            <img src="img/logo.png" alt="Newsec logo" class="logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation" id="navbar-icon">
            <div>
                <span></span>
                <span></span>
                <span></span>
            </div>
        </button>
    </div>

    <div class="w-100 nav-flex">
        <div class="collapse navbar-collapse flex-column" id="navbar">
            <ul class="navbar-nav justify-content-end container">
                <?php echo $admin ?>
                <?php echo $servicenav ?>
            </ul>

            <div class="w-100 bg-light-grey">
                <div class="container nav-flex">
                    <a href="index.php" class="col-2 a-logo" id="desktop-logo">
                        <img src="img/logo.png" alt="Newsec logo" class="logo">
                    </a>
                    <ul class="navbar-nav" style="margin-left:0;">
                      <li class="nav-item">
                        <a class="nav-link" href="projekt.php" id="navbarDropdownMenuLink" aria-expanded="false">Projekter</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="boligliste.php" id="navbarDropdownMenuLink" aria-expanded="false">Boligliste</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="isometri.php" id="navbarDropdownMenuLink" aria-expanded="false">isometri</a>
                      </li>
                      <li>
                      <form method="POST"> 
                        <select name="valgteprojekt" onchange="this.form.submit();">
                          <option value="NULL">Vælg projekt</option>
                          <?php
                          $sqlprojekt = "SELECT * FROM projekter";
                          $resultprojekt = mysqli_query($conn, $sqlprojekt) or die("Query virker ikke");
                          $projekter = mysqli_fetch_all($resultprojekt, MYSQLI_ASSOC); 
                          foreach($projekter as $projekt): ?>
                              <option value="<?php echo $projekt['id_projekt'] ?>" <?php if($_SESSION['projektsorter'] == $projekt['id_projekt']){echo 'selected';} ?>><?php echo $projekt['projektnavn'] ?></option>
                          <?php endforeach; ?>
                        </select>
                      </form>
                      </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>