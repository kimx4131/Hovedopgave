<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table</title>

    <style>
        body{
            font-family:sans-serif;
            font-weight:200;
        }
        table{
            width:100%;
            border-collapse: collapse;
        }

        tr{
            cursor: pointer;
        }

        th,td{
            padding:15px 0;
        }

        th{
            text-align: start;
        }

        tr th:nth-child(2), tr td:nth-child(2){
            padding-left: 10px;
        }

        tr td:nth-child(2), tr th:nth-child(2),tr td:nth-child(4), tr th:nth-child(4),tr td:nth-child(5), tr th:nth-child(5),tr td:nth-child(6), tr th:nth-child(6),tr td:nth-child(7), tr th:nth-child(7){
            width: 12%;
        }

        tbody tr{
            font-size:0.85rem;
        }

        tbody tr:nth-child(odd){
            background-color:white;
        }

        tbody tr:hover{
            opacity:0.5;
        }

        @media (max-width: 768px) {
            .hiddeonmobil {
                display:none;
            } 
        }
}


    </style>
</head>
<body>
    <?php include 'inc/db.php'?>

    <?php
        $id = mysqli_real_escape_string($conn, $_GET['projekt']);
        $sqlboliger = "SELECT * FROM boligliste WHERE id_projekt = $id";
        $resultboliger = mysqli_query($conn, $sqlboliger) or die("Query virker ikke");
        $boliger = mysqli_fetch_all($resultboliger, MYSQLI_ASSOC); 
        
    ?>

    <table>
        <thead>
            <tr>
                <th style="display:none;"></th>
                <th>Lejl nr.</th>
                <th class="hiddeonmobil">Adresse</th>
                <th>Kvm</th>
                <th>Værelser</th>
                <th class="hiddeonmobil">pris</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($boliger as $bolig): ?>
            <tr class="<?php echo $bolig['id_bolig']; ?>">
                <td style="display:none;"><a href="<?php echo $bolig['url']; ?>"></td>
                <td><?php echo $bolig['lejlnr']; ?></td>
                <td class="hiddeonmobil"><?php echo $bolig['vejnavn']." ".$bolig['husnr']." ".$bolig['etage']." ".$bolig['side'].", ".$bolig['postnr']." ".$bolig['bypost']; ?></td>
                <td><?php echo $bolig['kvm']; ?> m<sup>2</sup></td>
                <td><?php echo $bolig['vaerelser']; ?></td>
                <td class="hiddeonmobil"><?php echo $bolig['lejeraw']; ?></td>
                <td><?php 
                if($bolig['status'] == '1'){
                    echo "Udlejet";
                } else if ($bolig['status'] == '2'){
                    echo "Ledig";
                } else if ($bolig['status'] == '3'){
                    echo"Reseveret";
                };
                ?></td>
            </tr>
            </a>
            <?php endforeach; ?>
        </tbody>
    </table>


    <script>
    let rows = document.getElementsByTagName('tr');

    for(i=0;i<rows.length;i++){
        let getatag = rows[i].firstElementChild.firstElementChild;
        
        if(rows[i].lastElementChild.innerHTML == "Ledig"){
            rows[i].addEventListener('click', function hidden(){
            window.open(getatag.href, '_blank');
            });
        }else{
            rows[i].style.cursor = "auto";
        }
        
    }

    </script>
    
</body>
</html>