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

    if(isset($_POST['verwijder'])){
        $inactief_query = "UPDATE producten SET actief = 0 WHERE productID = {$_POST['productID']}";
        mysqli_query($link, $inactief_query);
    }

    if(isset($_POST['aanpassen'])){
        header('location:./product_aanpassen.php?product=' .$_POST['productID']);
    }

    if(isset($_POST['maken_product'])){
        header('location:./product_maken.php');
    }

?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Owner Producten</title>	
	<?php
    include ("../Standaard/header_sub_pages.php")
	?>
	<link href="../css/owner_product.css" rel="stylesheet" />

</head>
<?php
	include ("../Standaard/nav_owner_sub_pages.php");
?>

<div class="box1">
	<h1 class="welkom">
		Producten
	</h1>
	<div class="box1_1">
        <div class="box1_2">
            <form method="post">
            <input type="submit" name="maken_product" value="Maak een nieuw product."/>
            </form>
            <form>

            </form>
        </div>
        <table>
            <tr>
            <th>
                    <p>Afbeelding</p>
                </th>
                <th>
                    <p>Naam</p>
                </th>
                <th>
                    <p>Prijs</p>
                    <p>Per Stuk</p>
                </th>
                <th>
                    <p>Aantal op</p>
                    <p>Voorraad</p>
                </th>
                <th>
                    <p>Categorie</p>
                </th>
                <th>
                    <p>Actief</p>
                </th>
                <th>
                    <p>Bewerken</p>
                </th>
                <th>
                    <p>Verwijderen</p>
                </th>
            </tr>
            <?php
                $product_toon_query = "SELECT * FROM producten";

                $resultaat_product_toon = mysqli_query($link, $product_toon_query);

                while($row_toon_product = mysqli_fetch_array($resultaat_product_toon)){
                    $productID = $row_toon_product['productID'];
                    $naam = $row_toon_product['naam'];
                    $prijs = $row_toon_product['prijs'];
                    $aantalOpVoorraad = $row_toon_product['aantalOpVoorraad'];
                    $categorie = $row_toon_product['categorie'];
                    $actief = $row_toon_product['actief'];
                    $afbeelding = $row_toon_product['afbeelding'];
                    $subcategorie = $row_toon_product['subcategorie'];



                    echo("<tr>");
                        echo("<td>");
                            echo("<img class='afbeelding' src='.$afbeelding' alt='afbeelding $naam'>");
                        echo("</td>");
                        echo("<td>");
                            echo("<p>$naam</p>");
                        echo("</td>");
                        echo("<td>");
                            echo("<p>€ ".number_format($prijs, 2, ',', ' ')."</p>");
                        echo("</td>");
                        echo("<td>");
                            echo("<p>$aantalOpVoorraad</p>");
                        echo("</td>");
                        echo("<td>");
                            echo("<p>$categorie</p>");
                            if($subcategorie != NULL){
                                echo("<br><p><b>subcategorie</b>:<p>");
                                echo($subcategorie);
                            }
                        echo("</td>");
                        echo("<td>");
                            if ($actief == 1){
                                echo("<p>ja</p>");
                            }
                            else{
                                echo("<p>nee</p>");
                            }
                        echo("</td>");
                        echo("<td>");
                            echo("<form method='post'>");
                                echo("<input type='submit' value='aanpassen' name='aanpassen' id='verwijder'>");
                                echo("<input type='hidden' name='productID' value='$productID'>");
                            echo("</form>");
                        echo("</td>");
                        echo("<td>");
                            echo("<form method='post'>");
                                echo("<input type='submit' value='verwijder' name='verwijder' id='verwijder'>");
                                echo("<input type='hidden' name='productID' value='$productID'>");
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