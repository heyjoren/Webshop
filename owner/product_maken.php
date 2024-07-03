<?php
session_start();
if(isset($_SESSION["userID"]) && $_SESSION["userID"] >=0  and $_SESSION["userActief"] == 1 and $_SESSION['userRol'] == "owner")
{
    $psswd_gevonden = 0;
	$host = 'localhost';
    $user = 'webuser';
    $password = "Lab2021";

    $link = mysqli_connect($host, $user, $password) or die("Error: er kon geen conectie gemaakt worden.");

    $database = "webshop";

    mysqli_select_db($link, $database) or die("Error: database kon niet geopend worden");

    if(isset($_POST['maken_product'])){
        header('location:./producten.php');
    }

?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Owner product maken</title>	
	<?php
	include ("../Standaard/header_sub_pages.php")
	?>
	<link href="../css/product_owner_sub.css" rel="stylesheet" />
    <script>
	function kruis()
		{
			document.getElementById("alert").style.display="none";
		}

    </script>
</head>
<?php
	include ("../Standaard/nav_owner_sub_pages.php");

?>

<div class="box1">
	<h1 class="welkom">
		Voeg product toe
	</h1>
	<div class="box1_1">
		<div class="box3">
			<div class="middel" id="box3_1">
				<form method="post" enctype="multipart/form-data">
					<p class="velden"><label>Naam</label> <input type="text" name="naam" id="naam" class="input1"/></p>
					<p class="velden"><label>Prijs in euro</label> <input type="number" step="0.01" min="0" name="prijs" id="prijs" class="input2"/></p>
					<p class="velden"><label>Aantal op voorraad</label> <input type="number" min="0" name="aantal" class="input3"/></p>
                    <p class="velden"><label>categorie</label> <input type='text' name="categorie" id="categorie" class="input4"/></p>
					<p class="velden"><label>subcategorie</label> <input type="text" name="subcategorie" id="subcategorie" class="input5"/></p>
					<p class="velden"><label>Afbeelding met pad</label> <input type="text" name="afbeelding" id="afbeelding" class="input6"/></p>
                    <p class="select_container"><label class="label">actief</label>
                        <select name="actief" id="actief" class="select">
                            <option value="1" selected>ja</option>
                            <option value="0">nee</option>
                        </select>
                    </p>
					<p class="button"><input type="submit" name="maken_product" value="product toe voegen"/></p>

				</form>
			</div>
            <div class="alert" id="alert">
				<div>
					<input class="kruis" type="button" value="x" onclick="kruis()">
				</div>
				<p class="tekst1">
					U hebt niet alles correct ingevuld.
				</p>
				<p class="tekst2" id="tekst2"></p>
				<p class="tekst3" id="tekst3"></p>

			</div>
		</div>
	</div>
</div>

<?php
    if(isset($_POST['maken_product'])){
        if(!empty($_POST["naam"]) and (!empty($_POST["prijs"])) and (!empty($_POST["aantal"])) and (!empty($_POST["categorie"])) and (!empty($_POST["afbeelding"])) and (!empty($_POST["actief"])))
            {
            $naam = htmlspecialchars($_POST['naam']);
            $prijs = htmlspecialchars($_POST['prijs']);
            $aantal = htmlspecialchars($_POST['aantal']);
            $categorie = htmlspecialchars($_POST['categorie']);
            $subcategorie = htmlspecialchars($_POST['subcategorie']);
            $afbeelding = htmlspecialchars($_POST['afbeelding']);
            $actief = htmlspecialchars($_POST['actief']);

            $prijs = number_format($prijs, 2);

            $lastDotPosition = strrpos($afbeelding, '.');

            if ($lastDotPosition !== false) {
                $afbeelding_extension = strtolower(substr($afbeelding, $lastDotPosition + 1));
            }else{
                $afbeelding_extension="";
            }


            if($afbeelding_extension != "jpeg" &&  $afbeelding_extension != "jpg")
            {
?>
<script>
    document.getElementById('tekst2').innerHTML = 'Een verkeerd bestand.'
    document.getElementById('tekst3').innerHTML = 'Geef een andere bestand. Het moet een \".jpg\" of \".jpeg\" zijn'
    document.getElementById('alert').style.display='block'
</script>
<?php
            }
            else{

                if(isset($subcategorie) && !empty($subcategorie))
                {
                    $product_maken_subcat_query = "INSERT INTO producten (naam, prijs, aantalOpVoorraad, categorie, actief, afbeelding, subcategorie)    
                    VALUE
                    ('$naam', '$prijs', '$aantal', '$categorie', '$actief', '$afbeelding', '$subcategorie')";
        
                    mysqli_query($link, $product_maken_subcat_query);
                }else{
                    $product_maken__query = "INSERT INTO producten (naam, prijs, aantalOpVoorraad, categorie, actief, afbeelding)    
                    VALUE
                    ('$naam', '$prijs', '$aantal', '$categorie', '$actief', '$afbeelding')";
        
                    mysqli_query($link, $product_maken__query);
                }
            }
        }
    }
?>

<?php
mysqli_close($link);

}
?>