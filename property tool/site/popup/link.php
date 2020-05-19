

<div class="w-100 popupbg">
    <div class="container">
        <div class="row">
            <div class="col-md-8 ml-auto mr-auto logindboks">
                <div class="h2area">
                    <h2>Iframe</h2>
                    <div id="lukpopup2">X</div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p>Kopier og indsæt iframe kode der på din hjemmeside, hvor du ønsker isometrien skal være.</p>
                        <input id="iframe" style="border:none;" value='&lt;iframe style="width:100%;height:800px;" scrolling="no" frameborder="0" src="<?php echo $url."svg.php?id_isometri=".$id?>"&gt; &lt;/iframe&gt;'></input>
                        <button onclick="kopieriframe()">Kopier</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function kopieriframe() {
  var copyText = document.getElementById("iframe");
  copyText.select();
  copyText.setSelectionRange(0, 99999)
  document.execCommand("copy");
}
</script>
