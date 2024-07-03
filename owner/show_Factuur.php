<?php
session_start();
if(!isset($_SESSION["userID"]) or $_SESSION["userActief"] == 0 and $_SESSION['userRol'] != "owner"){
	header('location:./Mijn_account_sub_page/login.php');
}elseif(isset($_SESSION["userID"]) >=0  and $_SESSION["userActief"] == 1)
{
	$host = 'localhost';
    $user = 'webuser';
    $password = "Lab2021";

    $link = mysqli_connect($host, $user, $password) or die("Error: er kon geen conectie gemaakt worden.");

    $database = "webshop";

    mysqli_select_db($link, $database) or die("Error: database kon niet geopend worden");

    $factuurnr = $_GET['nr'];

?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Factuur</title>	
	<?php
    include ("../Standaard/header_sub_pages.php")
	?>
	<link href="../css/show_factuur_owner.css" rel="stylesheet" />

</head>
<?php
    if($_SESSION['userRol'] == 'owner'){
        include ("../Standaard/nav_owner_sub_pages.php");
    }else{
        include ("../Standaard/link_header_nav_sub_page.php");
    }
?>

<div class="box1">
	<h1 class="welkom">
        Factuur
	</h1>
	<div class="box1_1">
        <?php
            $afrekening_toon_query = "SELECT * FROM afrekening WHERE afrekeningID = $factuurnr";
            $resultaat_afrekening_toon = mysqli_query($link, $afrekening_toon_query);

            while($row_toon_afrekening = mysqli_fetch_array($resultaat_afrekening_toon)){
                $persoonID = $row_toon_afrekening['persoonID'];
                $afrekeningID = $row_toon_afrekening['afrekeningID'];
                $datum = $row_toon_afrekening['datum'];
                $datumenkel = date("d-m-Y", strtotime($datum));
                $totaalPrijs = $row_toon_afrekening['totaalPrijs'];
                $betaling = $row_toon_afrekening['betaling'];

                $klant_toon_query = "SELECT *  FROM klant WHERE persoonID = $persoonID";
                $resultaat_klant_toon = mysqli_query($link, $klant_toon_query);

                while($row_toon_klant = mysqli_fetch_array($resultaat_klant_toon)){
                    $voornaam = $row_toon_klant['voornaam'];
                    $achternaam = $row_toon_klant['achternaam'];
                    $email = $row_toon_klant['email'];
                    $gender = $row_toon_klant['gender'];
                    $telefoonnummer = $row_toon_klant['telefoonnummer'];
                }

                    $productInAfrekening_toon_query = "SELECT aantal, productID, eenheidsPrijs FROM productinafrekening WHERE afrekeningID = $afrekeningID";
                    $resultaat_productInAfrekening_toon = mysqli_query($link, $productInAfrekening_toon_query);
                     
                     $aantal=0;
                    while($row_toon_productInAfrekening = mysqli_fetch_array($resultaat_productInAfrekening_toon)){
                        $aantal += $row_toon_productInAfrekening['aantal'];
                    }

                    echo("<h2>Klant</h2>");
                    echo("<p><b>naam</b>: $voornaam $achternaam</p>");
                    echo("<p><b>email</b>: $email</p>");
                    echo("<p><b>telefoonnummer</b>: $telefoonnummer</p>");
                    echo("<p><b>gender</b>: $gender</p>");
            
            
                    echo("<h2>Factuur</h2>");
                    echo("<p><b>betaal methode</b>:$betaling</p>");
                    echo("<p><b>datum</b>:$datumenkel</p>");
                    echo("<p><b>totaal prijs</b>: € $totaalPrijs</p>");
                    echo("<p><b>totaal stukken gekocht</b>: $aantal</p>");

                    echo("<h2>Product</h2>");

                        $productInAfrekening_toon_query = "SELECT aantal, productID FROM productinafrekening WHERE afrekeningID = $afrekeningID";
                        $resultaat_productInAfrekening_toon = mysqli_query($link, $productInAfrekening_toon_query);
                                    
                        $aantal=0;
                        while($row_toon_productInAfrekening = mysqli_fetch_array($resultaat_productInAfrekening_toon)){
                            $aantal += $row_toon_productInAfrekening['aantal'];
                            $productID = $row_toon_productInAfrekening['productID'];

                            $producten_toon_query = "SELECT naam, categorie, subcategorie FROM producten WHERE productID = $productID";
                            $resultaat_producten_toon = mysqli_query($link, $producten_toon_query);
            
                            while($row_toon_producten = mysqli_fetch_array($resultaat_producten_toon)){
                                $naam = $row_toon_producten['naam'];
                                $categorie = $row_toon_producten['categorie'];
                                $subcategorie = $row_toon_producten['subcategorie'];

                                echo("<p><b>product</b>:$naam</p>");
                                echo("<p><b>eenheidsprijs</b>:");
                                    $productInAfrekening2_toon_query = "SELECT eenheidsPrijs FROM productinafrekening WHERE afrekeningID = $afrekeningID AND productID = $productID";
                                    $resultaat_productInAfrekening2_toon = mysqli_query($link, $productInAfrekening2_toon_query);
                                    $eenheidsPrijs = mysqli_fetch_column($resultaat_productInAfrekening2_toon);
                                    echo("€ $eenheidsPrijs");
                                echo("</p>");
                                echo("<p><b>categorie</b>: $categorie");
                                if ($subcategorie != NULL){
                                    echo(": $subcategorie");
                                }
                                echo("</p>");
                                echo("<p><b>aantal gekocht</b>: ");
                                $productInAfrekening3_toon_query = "SELECT aantal FROM productinafrekening WHERE afrekeningID = $afrekeningID AND productID = $productID";
                                    $resultaat_productInAfrekening3_toon = mysqli_query($link, $productInAfrekening3_toon_query);
                                    $aantalProduct = mysqli_fetch_column($resultaat_productInAfrekening3_toon);
                                    echo("$aantalProduct");
                                echo("</p>");
                                echo("<br>");
                            }
                        }

                        

                        
                        
                }
            ?>
            
        </table>
        
	</div>

</div>

<?php

}
?>

<?php
    include("../Standaard/footer_eind.php");

	mysqli_close($link);
?>