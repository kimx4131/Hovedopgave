<div class="w-100 popupbg">
    <div class="container">
        <div class="row">
            <div class="col-md-8 ml-auto mr-auto logindboks">
                <div class="h2area">
                    <h2>Opret bruger</h2>
                    <div id="lukpopup">X</div>
                </div>
                <form method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" name="navn" placeholder="Navn *" required>
                        </div>
                         <div class="col-md-6 switcharea">
                            <label>Admin</label>
                            <div class="moveright">
                                <label class="switch">
                                    <input type="checkbox" name="admin" value="admin" style="display:none;">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="email" name="email" placeholder="E-mail *" pattern="^\w+[-+.\w]*@\w+[-\w]*[.]{1,1}[a-z]{2,4}$" required>
                        </div>
                        <div class="col-md-6">
                            <input type="email" name="emailgentag" placeholder="Gentag e-mail *" pattern="^\w+[-+.\w]*@\w+[-\w]*[.]{1,1}[a-z]{2,4}$" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6 moveright">
                            <!-- <input name="opretbruger" type="submit" value="Opret bruger"> -->
                            <button name="opretbruger" type="submit">Opret</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: transparent;
  border: 1px solid #5d6a70;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 3px;
  background-color: white;
  box-shadow: 0 0 0 1px #5d6a70;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #5d6a70;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}


/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>