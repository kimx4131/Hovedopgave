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
                      <form method="POST"> <!-- class="custom-select"   -->
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

<!-- https://www.w3schools.com/howto/howto_custom_select.asp -->


<script>
var x, i, j, selElmnt, a, b, c;
/*look for any elements with the class "custom-select":*/
x = document.getElementsByClassName("custom-select");
for (i = 0; i < x.length; i++) {
  selElmnt = x[i].getElementsByTagName("select")[0];
  /*for each element, create a new DIV that will act as the selected item:*/
  a = document.createElement("DIV");
  a.setAttribute("class", "select-selected");
  a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
  x[i].appendChild(a);
  /*for each element, create a new DIV that will contain the option list:*/
  b = document.createElement("DIV");
  b.setAttribute("class", "select-items select-hide");
  for (j = 1; j < selElmnt.length; j++) {
    /*for each option in the original select element,
    create a new DIV that will act as an option item:*/
    c = document.createElement("DIV");
    c.innerHTML = selElmnt.options[j].innerHTML;
    c.addEventListener("click", function(e) {
        /*when an item is clicked, update the original select box,
        and the selected item:*/
        var y, i, k, s, h;
        s = this.parentNode.parentNode.getElementsByTagName("select")[0];
        h = this.parentNode.previousSibling;
        for (i = 0; i < s.length; i++) {
          if (s.options[i].innerHTML == this.innerHTML) {
            s.selectedIndex = i;
            h.innerHTML = this.innerHTML;
            y = this.parentNode.getElementsByClassName("same-as-selected");
            for (k = 0; k < y.length; k++) {
              y[k].removeAttribute("class");
            }
            this.setAttribute("class", "same-as-selected");
            break;
          }
        }
        h.click();
    });
    b.appendChild(c);
  }
  x[i].appendChild(b);
  a.addEventListener("click", function(e) {
      /*when the select box is clicked, close any other select boxes,
      and open/close the current select box:*/
      e.stopPropagation();
      closeAllSelect(this);
      this.nextSibling.classList.toggle("select-hide");
      this.classList.toggle("select-arrow-active");
    });
}
function closeAllSelect(elmnt) {
  /*a function that will close all select boxes in the document,
  except the current select box:*/
  var x, y, i, arrNo = [];
  x = document.getElementsByClassName("select-items");
  y = document.getElementsByClassName("select-selected");
  for (i = 0; i < y.length; i++) {
    if (elmnt == y[i]) {
      arrNo.push(i)
    } else {
      y[i].classList.remove("select-arrow-active");
    }
  }
  for (i = 0; i < x.length; i++) {
    if (arrNo.indexOf(i)) {
      x[i].classList.add("select-hide");
    }
  }
}
/*if the user clicks anywhere outside the select box,
then close all select boxes:*/
document.addEventListener("click", closeAllSelect);
</script>

