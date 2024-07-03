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

    if(isset($_POST['product_aanpassen'])){
        header('location:./producten.php');
    }

    $productID = $_GET['product'];

    $zoek_query = "SELECT *  FROM producten WHERE productID = $productID";
    $resultaat_product = mysqli_query($link, $zoek_query);

    while($row_product = mysqli_fetch_array($resultaat_product)){
        $naamZoek = $row_product['naam'];
		$prijsZoek = $row_product['prijs'];
		$aantalZoek = $row_product['aantalOpVoorraad'];
		$categorieZoek = $row_product['categorie'];
		$actiefZoek = $row_product['actief'];
        $afbeeldingZoek = $row_product['afbeelding'];
        $subcategorieZoek = $row_product['subcategorie'];
	}
?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Owner product aanpassen</title>	
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
		Product aanpassen
	</h1>
	<div class="box1_1">
		<div class="box3">
			<div class="middel" id="box3_1">
				<form method="post" enctype="multipart/form-data">
					<p class="velden"><label>Naam</label> <input type="text" name="naam" value="<?php echo"$naamZoek";?>" id="naam" class="input1"/></p>
					<p class="velden"><label>Prijs in euro</label> <input type="number" step="0.01" min="0" name="prijs" value="<?php echo"$prijsZoek";?>" id="prijs" class="input2"/></p>
					<p class="velden"><label>Aantal op voorraad</label> <input type="number" min="0" name="aantal" value="<?php echo"$aantalZoek";?>" class="input3"/></p>
                    <p class="velden"><label>categorie</label> <input type='text' name="categorie" id="categorie" value="<?php echo"$categorieZoek";?>" class="input4"/></p>
					<p class="velden"><label>subcategorie</label> <input type="text" name="subcategorie" id="subcategorie" value="<?php echo"$subcategorieZoek";?>" class="input5"/></p>
					<p class="velden"><label>Afbeelding met pad</label> <input type="text" name="afbeelding" id="afbeelding" value="<?php echo"$afbeeldingZoek";?>" class="input6"/></p>
                    <p class="select_container"><label class="label">actief</label>
                        <select name="actief" id="actief" class="select">
                            <option value="1" 
                                <?php
                                    if($actiefZoek == 1){
                                        echo("selected");
                                    }
                                ?>>ja</option>
                            <option value="0"
                                <?php
                                    if($actiefZoek == 0){
                                        echo("selected");
                                    }
                                ?>>nee</option>
                        </select>
                    </p>
					<p class="button"><input type="submit" name="product_aanpassen" value="product aanpassen"/></p>

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
    if(isset($_POST['product_aanpassen'])){
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
                    $product_maken_subcat_query = "UPDATE producten SET naam = '$naam', prijs = '$prijs', aantalOpVoorraad = '$aantal', categorie = '$categorie', actief = '$actief', afbeelding = '$afbeelding', subcategorie = '$subcategorie'
                    WHERE productID = $productID";
        
                    mysqli_query($link, $product_maken_subcat_query);
                }else{
                    $product_maken__query = "UPDATE producten SET naam = '$naam', prijs = '$prijs', aantalOpVoorraad = '$aantal', categorie = '$categorie', actief = '$actief', afbeelding = '$afbeelding'
                    WHERE productID = $productID";
        
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