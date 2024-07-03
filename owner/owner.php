<?php
session_start();
if(!isset($_SESSION["userID"]) or $_SESSION["userActief"] == 0 and $_SESSION['userRol'] != "owner"){
	header('location:./Mijn_account_sub_page/login.php');
}elseif(isset($_SESSION["userID"]) >=0  and $_SESSION["userActief"] == 1 and $_SESSION['userRol'] == "owner")
{
	$host = 'localhost';
    $user = 'webuser';
    $password = "Lab2021";

    $link = mysqli_connect($host, $user, $password) or die("Error: er kon geen conectie gemaakt worden.");

    $database = "webshop";

    mysqli_select_db($link, $database) or die("Error: database kon niet geopend worden");

    if(isset($_POST['factuur'])){
        header('location:./show_Factuur.php?nr=' .$_POST['afrekeningID']);
    }

?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Owner</title>	
	<?php
    include ("../Standaard/header_sub_pages.php")
	?>
	<link href="../css/owner.css" rel="stylesheet" />

</head>
<?php
	include ("../Standaard/nav_owner_sub_pages.php");
?>

<div class="box1">
	<h1 class="welkom">
        Owner
	</h1>
	<div class="box1_1">
        <div class="box1_2">
            <p>Je kan hier alle facturen zien.</p>
        </div>
        <table>
            <tr>
                <th>
                    <p>Naam Klant</p>
                </th>
                <th>
                    <p>Email Klant</p>
                </th>
                <th>
                    <p>Totaalprijs</p>
                </th>
                <th>
                    <p>Totaal Aantal</p>
                    <p>Producten</p>
                </th>
                <th>
                    <p>Producten</p>
                </th>
                <th>
                    <p>Datum</p>
                </th>
                <th>
                    <p>Bekijk</p>
                    <p>Geheel</p>
                </th>
            </tr>
            <?php
                $afrekening_toon_query = "SELECT afrekeningID, persoonID, datum, totaalPrijs FROM afrekening";
                $resultaat_afrekening_toon = mysqli_query($link, $afrekening_toon_query);

                while($row_toon_afrekening = mysqli_fetch_array($resultaat_afrekening_toon)){
                    $persoonID = $row_toon_afrekening['persoonID'];
                    $afrekeningID = $row_toon_afrekening['afrekeningID'];
                    $datum = $row_toon_afrekening['datum'];
                    $datumenkel = date("d-m-Y", strtotime($datum));
                    $totaalPrijs = $row_toon_afrekening['totaalPrijs'];

                    $klant_toon_query = "SELECT voornaam, achternaam, email FROM klant WHERE persoonID = $persoonID";
                    $resultaat_klant_toon = mysqli_query($link, $klant_toon_query);

                    while($row_toon_klant = mysqli_fetch_array($resultaat_klant_toon)){
                        $voornaam = $row_toon_klant['voornaam'];
                        $achternaam = $row_toon_klant['achternaam'];
                        $email = $row_toon_klant['email'];
                    }

                        $productInAfrekening_toon_query = "SELECT aantal, productID FROM productinafrekening WHERE afrekeningID = $afrekeningID";
                        $resultaat_productInAfrekening_toon = mysqli_query($link, $productInAfrekening_toon_query);
                        
                        $aantal=0;
                        while($row_toon_productInAfrekening = mysqli_fetch_array($resultaat_productInAfrekening_toon)){
                            $aantal += $row_toon_productInAfrekening['aantal'];
                        }
                            

                            echo("<tr>");
                                echo("<td>");
                                    echo("<p>$voornaam $achternaam</p>");
                                echo("</td>");
                                echo("<td>");
                                    echo("<p>$email</p>");
                                echo("</td>");
                                echo("<td>");
                                    echo("<p>€ $totaalPrijs</p>");
                                echo("</td>");
                                echo("<td>");
                                    echo("<p>$aantal</p>");
                                echo("</td>");
                                echo("<td>");
                                    $productInAfrekening_toon_query = "SELECT aantal, productID FROM productinafrekening WHERE afrekeningID = $afrekeningID";
                                    $resultaat_productInAfrekening_toon = mysqli_query($link, $productInAfrekening_toon_query);
                                    
                                    $aantal=0;
                                    while($row_toon_productInAfrekening = mysqli_fetch_array($resultaat_productInAfrekening_toon)){
                                        $aantal += $row_toon_productInAfrekening['aantal'];
                                        $productID = $row_toon_productInAfrekening['productID'];

                                        $producten_toon_query = "SELECT naam FROM producten WHERE productID = $productID";
                                        $resultaat_producten_toon = mysqli_query($link, $producten_toon_query);
            
                                        while($row_toon_producten = mysqli_fetch_array($resultaat_producten_toon)){
                                            $naam = $row_toon_producten['naam'];
                                            echo("<p>$naam</p>");
                                        }
                                    }
                                echo("</td>");
                                echo("<td>");
                                    echo("<p>$datumenkel</p>");
                                echo("</td>");
                                echo("<td>");
                                    echo("<form method='post'>");
                                        echo("<input type='submit' value='bekijk' name='factuur' id='bekijk'>");
                                        echo("<input type='hidden' name='afrekeningID' value='$afrekeningID'>");
                                    echo("</form>");
                                echo("</td>");
                            echo("</tr>");
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