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
        $inactief_query = "UPDATE klant SET actief = 0 WHERE persoonID = {$_POST['persoonId']}";
        mysqli_query($link, $inactief_query);
    }

    if(isset($_POST['aanpassen'])){
        header('location:./klant_aanpassen.php?user=' .$_POST['persoonId']);
    }

    if(isset($_POST['accout_maken'])){
        header('location:./klant_maken.php');
    }

?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Owner klant</title>	
	<?php
    include ("../Standaard/header_sub_pages.php")
	?>
	<link href="../css/klant.css" rel="stylesheet" />

</head>
<?php
	include ("../Standaard/nav_owner_sub_pages.php");
?>

<div class="box1">
	<h1 class="welkom">
		Klanten
	</h1>
	<div class="box1_1">
        <div class="box1_2">
            <form method="post">
            <input type="submit" name="accout_maken" value="Maak zelf een nieuwe klant aan."/>
            </form>
            <form>

            </form>
        </div>
        <table>
            <tr>
                <th>
                    <p>Naam</p>
                </th>
                <th>
                    <p>Email</p>
                </th>
                <th>
                    <p>Telefoonnummer</p>
                </th>
                <th>
                    <p>Gender</p>
                </th>
                <th>
                    <p>Rol</p>
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
                $klant_toon_query = "SELECT * FROM klant";

                $resultaat_klant_toon = mysqli_query($link, $klant_toon_query);

                while($row_toon_klant = mysqli_fetch_array($resultaat_klant_toon)){
                    $persoonID = $row_toon_klant['persoonID'];
                    $voornaam = $row_toon_klant['voornaam'];
                    $achternaam = $row_toon_klant['achternaam'];
                    $email = $row_toon_klant['email'];
                    $telefoonnummer = $row_toon_klant['telefoonnummer'];
                    $paswoord = $row_toon_klant['paswoord'];
                    $gender = $row_toon_klant['gender'];
                    $rol = $row_toon_klant['rol'];
                    $actief = $row_toon_klant['actief'];


                    echo("<tr>");
                        echo("<td>");
                            echo("<p>$voornaam $achternaam</p>");
                        echo("</td>");
                        echo("<td>");
                            echo("<p>$email</p>");
                        echo("</td>");
                        echo("<td>");
                            echo("<p>$telefoonnummer</p>");
                        echo("</td>");
                        echo("<td>");
                            echo("<p>$gender</p>");
                        echo("</td>");
                        echo("<td>");
                            echo("<p>$rol</p>");
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
                                echo("<input type='hidden' name='persoonId' value='$persoonID'>");
                            echo("</form>");
                        echo("</td>");
                        echo("<td>");
                            echo("<form method='post'>");
                                echo("<input type='submit' value='verwijder' name='verwijder' id='verwijder'>");
                                echo("<input type='hidden' name='persoonId' value='$persoonID'>");
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