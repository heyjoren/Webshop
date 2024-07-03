<?php
session_start();
if(!isset($_SESSION['userRol'])){
	$_SESSION['userRol'] = "webuser";
}

	$host = 'localhost';
    $user = 'webuser';
    $password = "Lab2021";

    $link = mysqli_connect($host, $user, $password) or die("Error: er kon geen conectie gemaakt worden.");
    $database = "webshop";

    mysqli_select_db($link, $database) or die("Error: database kon niet geopend worden");

    if(isset($_SESSION["userID"])){
        $userID = $_SESSION["userID"];
        if(isset($_POST["toevoegen_winkelmand"])){
            $ProductID = $_POST["productID"];

            $aantal=0;

            $zoek_query = "SELECT * FROM productinwinkelmand WHERE winkelmandID = {$_SESSION['winkelmandID']} AND productID = $ProductID";
            $zoek_resultaat = mysqli_query($link, $zoek_query);

            while($row = mysqli_fetch_array($zoek_resultaat)){
                $aantal=$row['aantal'];
            }

            if($aantal > 0){
                $zoek_voorraad_query = "SELECT aantalOpVoorraad FROM producten WHERE productID = $ProductID";
                $zoek_voorraad_resultaat = mysqli_query($link, $zoek_voorraad_query);

                $voorraad = mysqli_fetch_column($zoek_voorraad_resultaat);

                if ($aantal +1 <= $voorraad){
                    $update_aantal_query = "UPDATE productinwinkelmand SET aantal=$aantal+1 WHERE winkelmandID = {$_SESSION['winkelmandID']} and productID = $ProductID";

                    mysqli_query($link, $update_aantal_query);
                }                
            }else{
                $insert_productwinkelmand_query = "INSERT INTO productinwinkelmand (winkelmandID, productID, aantal)
                VALUES
                ('{$_SESSION['winkelmandID']}', $ProductID, 1)";
            
                mysqli_query($link, $insert_productwinkelmand_query);
            }


            

        }
    }else{
        if(isset($_POST["toevoegen_winkelmand"])){
            header('location:./Mijn_account_sub_page/login.php');
        }
    }

	$show_all_query = "SELECT *  FROM producten WHERE actief = 1 and aantalOpVoorraad > 0";

    $resultaat_show = mysqli_query($link, $show_all_query);
?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Producten</title>
    <?php
	include ("./Standaard/header.php")
	?>
	<link href="./css/producten.css" rel="stylesheet" />
</head>

    <script>

        function checkbox(){
            var checkbox = document.getElementById("vazen");
            var subclass = document.getElementsByClassName("sub_check");

            if(checkbox.checked == true){
                for (var i = 0; i < subclass.length; i++) {
                    subclass[i].style.display = "block";
                }
            }else{
                for (var j = 0; j < subclass.length; j++) {
                    subclass[j].style.display = "none";
                }
            }
        }

        function start_filter(){
            xhr = new XMLHttpRequest();
	   
            if (xhr==null) {
                alert ("Browser does not support HTTP Request");
            } else {
                
                var checked = boxSelected();
                var url="./Producten_sub_pages/Filter.php?";
                xhr.onreadystatechange = filter;
                xhr.open("GET",url + checked,true);
                xhr.send(null);
            }
        }

        function boxSelected(){
            var vazen = document.getElementById("vazen");
            var bloemen = document.getElementById("vazen_bloem");
            var kaarsen = document.getElementById("vazen_kaars");
            var schilderij = document.getElementById("schilderijen");
            var checked;
            
            if(vazen.checked == true){
                checked = "vasen=true&"
            }
            else{
                checked = "vasen=false&"
            }

            if(bloemen.checked == true){
                checked += "bloemen=true&"
            }
            else{
                checked += "bloemen=false&"
            }

            if(kaarsen.checked == true){
                checked += "kaarsen=true&"
            }
            else{
                checked += "kaarsen=false&"
            }

            if(schilderij.checked == true){
                checked += "schilderijen=true"
            }
            else{
                checked += "schilderijen=false"
            }

            return checked
        }

        function filter(){
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById("producten").innerHTML=this.responseText;
            }
        }
    </script>

<?php
    	if($_SESSION['userRol'] == 'owner'){
            include ("./Standaard/nav_owner.php");
        }else{
            include ("./Standaard/link_header_nav.php");
        }
?>

<div class="box1">
	<h1 class="welkom">
		Producten
	</h1>
    <div class="box_filter">
        <h2 class="filter">filter</h2>
        <div class="filet_middel">
            <form method="post">
                <p>zoeken op:</p>
                <div class="hoofd_check">
                    <input type="checkbox" id="vazen" name="vazen" value="vazen" onclick="checkbox()">
                    <label for="vazen">vazen</label>
                </div>
                <div class="sub_check">
                    <input type="checkbox" id="vazen_bloem" name="vazen_bloem" value="vazen_bloem">
                    <label for="vazen">voor bloemen</label>
                    <br>
                    <input type="checkbox" id="vazen_kaars" name="vazen_kaars" value="vazen_kaars">
                    <label for="vazen">voor kaarsen</label>
                </div>
                <div class="hoofd_check">
                    <input type="checkbox" id="schilderijen" name="schilderijen" value="schilderijen">
                    <label for="vazen">schilderijen</label>
                </div>
                <input type="button" name="filter" value="zoeken op filter" onclick="start_filter()"/>
            </form>
        </div>
    </div>
    <div id="producten">
        <?php
        
            while($row_show = mysqli_fetch_array($resultaat_show)){
                echo("<div class='box_product' id='box_product'>");
                    echo("<img class='afbeelding_porduxt' src='{$row_show['afbeelding']}' alt='afbeelding {$row_show['naam']}'>");
                    echo("<div class='product_onderstaande'>");
                        echo("<div class='product_text'>");
                            echo("<p class='naam_product'>".$row_show['naam']."");
                            echo("<a class='prijs_product'>€".number_format($row_show['prijs'], 2, ',', ' ')."</a></p>");
                        echo("</div>");
                        echo("<form method='post'>");
                            echo("<p class='button'><input type='submit' name='toevoegen_winkelmand' value='toevoegen aan winkelmandje' onclick='start()' /></p>");
                            echo("<input type='hidden' name='productID' value={$row_show['productID']}>");
                        echo("</form>");
                    echo("</div>");
                echo("</div>");
            }

        ?>
	
    </div>
</div>
<?php
    include("./Standaard/footer_eind.php");

    mysqli_close($link);
?>