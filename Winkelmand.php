<?php
session_start();
include_once "./error/log.php";

if(!isset($_SESSION['userRol'])){
	$_SESSION['userRol'] = "webuser";
}
if(!isset($_SESSION["userID"]) or $_SESSION["userActief"] == 0){
	header('location:./Mijn_account_sub_page/login.php');
}elseif(isset($_SESSION["userID"]) >=0  and $_SESSION["userActief"] == 1)
{
	$host = 'localhost';
    $user = 'webuser';
    $password = "Lab2021";

    $link = mysqli_connect($host, $user, $password) or die("Error: er kon geen conectie gemaakt worden.");

    $database = "webshop";

    mysqli_select_db($link, $database) or die("Error: database kon niet geopend worden");


    $counter=0;
    $leeg_bestellen_query = "SELECT * FROM productinwinkelmand WHERE winkelmandID = {$_SESSION['winkelmandID']}";
    $leeg_bestellen_resultaat = mysqli_query($link, $leeg_bestellen_query);

    while($leeg_bestellen_row = mysqli_fetch_array($leeg_bestellen_resultaat)){
        $counter++;
    }
    
    if(isset($_POST["betaal"]) && $counter > 0){
        if(isset($_POST["betaal"])){
            $winkelmandID = $_SESSION['winkelmandID'];

            $afrekening_query = "INSERT INTO afrekening (persoonID, betaling, totaalPrijs, datum)
            VALUES
            ('{$_SESSION['userID']}', '{$_POST['betaal_methode']}', '{$_POST['totaalprijs']}', now())";
            mysqli_query($link, $afrekening_query);

            // update afrekenig product
            // gegevens opvragen uit database
            $zoek_afrekenigID_query = "SELECT afrekeningID FROM afrekening WHERE persoonID = {$_SESSION['userID']} AND betaling = '{$_POST['betaal_methode']}'
            AND totaalPrijs = {$_POST['totaalprijs']} AND datum = now()";
            $zoek_afrekenigID_result = mysqli_query($link, $zoek_afrekenigID_query);
            $afrekeningID = mysqli_fetch_column($zoek_afrekenigID_result);

            $windelmand_query = "SELECT productID, aantal FROM productinwinkelmand WHERE winkelmandID = {$_SESSION['winkelmandID']}";
            $resultaat_windelmand_query = mysqli_query($link, $windelmand_query);

            while($row = mysqli_fetch_array($resultaat_windelmand_query)){
                $productID = $row['productID'];
                $aantal = $row['aantal'];
                
                $toon_product_query = "SELECT prijs FROM producten WHERE productID = $productID";
                $resultaat_toon_product_select = mysqli_query($link, $toon_product_query);
                $productPrijs = mysqli_fetch_column($resultaat_toon_product_select);

                // uiteindelijke update
                $afrekening_product_query="INSERT INTO productinafrekening (productID, afrekeningID, aantal, eenheidsPrijs)
                VALUES
                ($productID, $afrekeningID, $aantal, $productPrijs)";
                mysqli_query($link, $afrekening_product_query);

                // update stock
                $toon_product_query = "SELECT aantalOpVoorraad FROM producten WHERE productID = $productID";
                $resultaat_toon_product_select = mysqli_query($link, $toon_product_query);
                $productAantalOpVoorraad = mysqli_fetch_column($resultaat_toon_product_select);

                $update_stock = $productAantalOpVoorraad - $aantal;

                if($update_stock == 0){
                    $inactief_query = "UPDATE producten SET actief = 0 WHERE productID = $productID";
                    mysqli_query($link, $inactief_query);    
                }
                $update_stock_query = "UPDATE producten SET aantalOpVoorraad = $update_stock WHERE productID = $productID";
                mysqli_query($link, $update_stock_query);
            }

            $delete_all_query = "DELETE FROM productinwinkelmand WHERE winkelmandID = $winkelmandID";
            $resultaat_delete = mysqli_query($link, $delete_all_query); 
        }
    }
    else{
        if(isset($_POST["verwijder"])){
            $persoonID = $_SESSION["userID"];
            $verwijder = $_POST["verwijder"];
            $productID = $_POST["productID"];
            $winkelmandID = $_SESSION['winkelmandID'];
    
            $delete_query = "DELETE FROM productinwinkelmand WHERE winkelmandID = $winkelmandID and productID = $productID";
    
            $resultaat_delete = mysqli_query($link, $delete_query);
        }
    
        
        if(isset($_POST["update"])){
            $aantal = htmlspecialchars($_POST['aantal']);

            $zoek_voorraad_query = "SELECT aantalOpVoorraad FROM producten WHERE productID = {$_POST['productID']}";
            $zoek_voorraad_resultaat = mysqli_query($link, $zoek_voorraad_query);
    
            $voorraad = mysqli_fetch_column($zoek_voorraad_resultaat);

            try{
                if ($aantal <= $voorraad){
                    $update_aantal_query = "UPDATE productinwinkelmand SET aantal=$aantal WHERE winkelmandID = {$_SESSION['winkelmandID']} and productID = {$_POST['productID']}";
            
                    mysqli_query($link, $update_aantal_query);
                }else{
                    throw new MyException("We hebben niet zo veel in stock");
                }
            } catch (MyException $e) {
                $update_aantal_query = "UPDATE productinwinkelmand SET aantal=$voorraad WHERE winkelmandID = {$_SESSION['winkelmandID']} and productID = {$_POST['productID']}";
    
                mysqli_query($link, $update_aantal_query);

                $e->HandleException();
            }
            
        }
    }
    
?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Winkelmandje</title>	
    <?php
	include ("./Standaard/header.php")
	?>
	<link href="./css/Winkelmand.css" rel="stylesheet" />

    <script src="jQuery/JQuerry.js"></script>

    <script>

        function kruis()
        {
            document.getElementById("error").style.display="none"
        }

        function kruis_betalen(){
            document.getElementById("betalen").style.display="none"
        }
        
        function kruis_bedankt(){
            document.getElementById("bedankt").style.display="none"
        }

        function betalen()
        {
            document.getElementById("betalen").style.display="block"
        }

        function bedankt()
        {
            document.getElementById("bedankt").style.display="block"
        }
    </script>

    <script>
    $(document).ready(function() {
        $("#bestellen").click(function() {
            $('html, body').animate({
                scrollTop: '0px'
            });
        });
    });

    </script>

</head>
	
<?php
    	if($_SESSION['userRol'] == 'owner'){
            include ("./Standaard/nav_owner.php");
        }else{
            include ("./Standaard/link_header_nav.php");
        }
?>

<div class="box1">
	<h1 class="welkom">
		Winkelmandje
	</h1>

    <div>
        <table>
    <?php
        $toon_select_query = "SELECT * FROM productinwinkelmand WHERE winkelmandID = {$_SESSION['winkelmandID']}";

        $resultaat_toon_select = mysqli_query($link, $toon_select_query);

        $totaalPrijs = 0;

        while($row = mysqli_fetch_array($resultaat_toon_select)){
            $winkelmandID = $row['winkelmandID'];
            $productID = $row['productID'];
            $aantal = $row['aantal'];
            
            $toon_product_query = "SELECT * FROM producten WHERE productID = $productID";

            $resultaat_toon_product_select = mysqli_query($link, $toon_product_query);

            while($rowproduct = mysqli_fetch_array($resultaat_toon_product_select)){
                $productNaam = $rowproduct['naam'];
                $productProductID = $rowproduct['productID'];
                $productPrijs = $rowproduct['prijs'];
                $productAantalOpVoorraad = $rowproduct['aantalOpVoorraad'];
                $productAfbeelding = $rowproduct['afbeelding'];
                $productCategorie = $rowproduct['categorie'];
                $productSubCategorie = $rowproduct['subcategorie'];
                $productActief = $rowproduct['actief'];
            }

            echo("<tr class='box_product'>");
                echo("<td>");
                    echo("<img class='afbeelding_porduct' src='$productAfbeelding' alt='afbeelding $productNaam'>");
                echo("</td>");
                echo("<td>");
                    echo("<table>");
                        echo("<tr>");
                            echo("<td>");
                                echo("<p class='product_text'>");
                                    echo("$productNaam");
                                echo("</p>");
                            echo("</td>");
                        echo("</tr>");
                        echo("<tr>");
                        echo("<td>");
                            echo("<p class='product'>");
                                echo("eenheidsprijs €".number_format($productPrijs, 2, ',', ' '));
                            echo("</p>");
                        echo("</td>");
                    echo("</tr>");
                        echo("<tr>");
                            echo("<td>");
                                echo("<p class='product'>");
                                    echo("aantal $aantal");
                                echo("</p>");
                            echo("</td>");
                        echo("</tr>");
                        echo("</tr>");
                        echo("<tr>");
                            echo("<td>");
                                echo("<p class='product'>");
                                    echo("product totaal prijs: €".number_format(($aantal * $productPrijs), 2, ',', ' '));
                                echo("</p>");
                            echo("</td>");
                        echo("</tr>");
                        echo("<tr>");
                            echo("<td>");
                                echo("<p id='voorraad'>");
                                    echo("in stock: $productAantalOpVoorraad");
                                echo("</p>");
                            echo("</td>");
                        echo("</tr>");
                    echo("</table>");
                    echo("<td class='form'>");
                        echo("<form method='post'>");
                            echo("<label>Hoeveel producten wilt u?</label>");
                            echo("<br>");
                            echo("<input type='number' min='1' name='aantal' value=$aantal>");
                            echo("<input type='submit' value='update' name='update'>");
                            echo("<input type='submit' value='verwijder' name='verwijder' id='verwijder'>");
                            echo("<input type='hidden' name='productID' value='$productProductID'>");
                        echo("</form>");
                    echo("</td>");
            echo("</tr>");
            echo("</div>");
            $totaalPrijs = $totaalPrijs + ($aantal * $productPrijs);

        }
    ?>
        </table>
        <div class='totaalprijs'>
            <?php
                echo("<p class='totaalprijs'>");
                    echo("Totaal prijs: €".number_format($totaalPrijs, 2, ',', ' '));
                echo("</p>");
            ?>
            <form method="post">
            <input type="button" value="bestellen" name="bestellen" id="bestellen" onclick="betalen()">
            </form>
        </div>

        <div class="bestel_popup" id="betalen">
            <input class="kruis" type="button" value="x" onclick="kruis_betalen()">
            <h2>Hoe wil je betalen?</h2>
            <form method="post">
                <label for="paypal">paypal</label>
                <input type="radio" name="betaal_methode" id="paypal" value="paypal" checked="checked">
                <label for="creditcard">bancontact</label>
                <input type="radio" name="betaal_methode" id="bancontact" value="bancontact">
                <input type="submit" name="betaal" value="betaal" onclick="bedankt()">
                <input type='hidden' name='totaalprijs' value='<?php echo($totaalPrijs) ?>'>
            </form>
        </div>

    </div>		

</div>

<?php
    include("./Standaard/footer_eind.php");

	mysqli_close($link);
}
?>