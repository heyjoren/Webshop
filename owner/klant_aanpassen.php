<?php
session_start();
if(isset($_SESSION["userID"]) >=0  and $_SESSION["userActief"] == 1 and $_SESSION['userRol'] == "owner")
{
	$host = 'localhost';
    $user = 'webuser';
    $password = "Lab2021";

    $link = mysqli_connect($host, $user, $password) or die("Error: er kon geen conectie gemaakt worden.");

    $database = "webshop";

    mysqli_select_db($link, $database) or die("Error: database kon niet geopend worden");

    if(isset($_POST['accout_aanpassen'])){
        header('location:./klant.php');
    }

    $klantID = $_GET['user'];

	$zoek_query = "SELECT *  FROM klant WHERE persoonID = $klantID";
    $resultaat_klant = mysqli_query($link, $zoek_query);

    while($row_klant = mysqli_fetch_array($resultaat_klant)){
        $gender = $row_klant['gender'];
		$email = $row_klant['email'];
		$tel = $row_klant['telefoonnummer'];
		$voornaam = $row_klant['voornaam'];
		$achternaam = $row_klant['achternaam'];
        $rol = $row_klant['rol'];
        $actief = $row_klant['actief'];
	}

	$straat = "";
	$huisnummer = "";
	$postcode = "";
	$gemeente = "";

	$zoek_adres_query = "SELECT straatnaam, huisnummer, postcode, gemeente  FROM adres WHERE persoonID = $klantID";
    $resultaat_adres = mysqli_query($link, $zoek_adres_query);

	while($row_adres = mysqli_fetch_array($resultaat_adres)){
		$straat = (!empty($row_adres['straatnaam'])) ? $row_adres['straatnaam'] : "";
        $huisnummer = (!empty($row_adres['huisnummer'])) ? $row_adres['huisnummer'] : "";
        $postcode = (!empty($row_adres['postcode'])) ? $row_adres['postcode'] : "";
        $gemeente = (!empty($row_adres['gemeente'])) ? $row_adres['gemeente'] : "";
	}
?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Owner klant aanpassen</title>	
	<?php
	include ("../Standaard/header_sub_pages.php")
	?>
	<link href="../css/klant_sub.css" rel="stylesheet" />
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
		account aanpassen
	</h1>
	<div class="box1_1">
		<div class="box3">
			<div class="middel" id="box3_1">
				<form method="post">
					<div class="velden"><label>Voornaam</label> <input type="text" name="voornaam" value="<?php echo"$voornaam";?>" id="voornaam" class="input1"/></div>
					<div class="velden"><label>Achternaam</label> <input type="text" name="achternaam" value="<?php echo"$achternaam";?>" id="achternaam" class="input2"/></div>
					<div class="velden"><label>Email</label> <input type="email" name="email" value="<?php echo"$email";?>" class="input3"/></div>
					<div class="velden"><label>Telefoonnummer</label> <input type='tel' name="telefoonnummer" id="tel" value="<?php echo"$tel";?>" pattern="[0]{2}[0-9]{2} [0-9]{3} [0-9]{2} [0-9]{2} [0-9]{2}" class="input4"/></div>
					<div class="velden"><label>Wachtwoord</label> <input type="password" name="psswd" placeholder="wachtwoord" id="psswd" class="input5"/></div>
					<div class="velden"><label>straatnaam</label> <input type="text" name="straatnaam" value="<?php echo"$straat";?>" id="straatnaam" class="input6"/></div>
					<div class="velden"><label>huisnummer</label> <input type='number' min='1' name="huisnummer" value="<?php echo"$huisnummer";?>" id="huisnummer" class="input7"/></div>
					<div class="velden"><label>postcode</label> <input type='number' min='1000' name="postcode" value="<?php echo"$postcode";?>" id="postcode" class="input8"/></div>
					<div class="velden"><label>gemeente</label> <input type="text" name="gemeente" value="<?php echo"$gemeente";?>" id="gemeente" class="input9"/></div>
					<div class="velden">
						<div class="radio">
						<?php
								if ($gender == 'M')
								{
									echo("<label class='radio_label'>Man</label> <input type='radio' id='M' value='M' name='gender' checked='checked'> ");
								}else{
									echo("<label class='radio_label'>Man</label> <input type='radio' id='M' value='M' name='gender'>");
									
								}
								if ($gender == 'F')
								{
									echo("<label class='radio_label'>Vrouw</label> <input type='radio' id='V' value='F' name='gender' checked='checked'>");
								}else{
									echo("<label class='radio_label'>Vrouw</label> <input type='radio' id='V' value='F' name='gender'>");								
								}
								if ($gender == 'X')
								{
									echo("<label class='radio_label'>X</label> <input type='radio' id='X' value='X' name='gender' checked='checked'>");
								}else{
									echo("<label class='radio_label'>X</label> <input type='radio' id='X' value='X' name='gender'>");									
								}
							?>
							
							
						</div>
					</div>
                    <div class="select_container"><label class="label">rol</label>
                        <select name="kies_rol" id="kies_rol" class="select">
                            <option value="webuser"
                                <?php
                                    if($rol == "webuser"){
                                        echo("selected");
                                    }
                                ?>>Webuser</option>
                            <option value="owner"
                                <?php
                                    if($rol == "owner"){
                                        echo("selected");
                                    }
                                ?>>Owner</option>
                        </select>
					</div>

                    <div class="select_container"><label class="label">actief</label>
                        <select name="actief" id="actief" class="select">
                            <option value="1"
                                <?php
                                    if($actief == 1){
                                        echo("selected");
                                    }
                                ?>>ja</option>
                            <option value="0" 
                                <?php
                                    if($actief == 0){
                                        echo("selected");
                                    }
                                ?>>nee</option>
                        </select>
					</div>
					<div class="button"><input type="submit" name="accout_aanpassen" value="account aanpassen"/></div>

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

}
?>

<?php
    include("../Standaard/footer_eind.php");

	if(isset($_POST["accout_aanpassen"])){
		if(!empty($_POST["voornaam"]) and !empty($_POST["achternaam"]) and !empty($_POST["email"]) and !empty($_POST["telefoonnummer"]))
		{
			
			$voornaamAanpassen = htmlspecialchars($_POST["voornaam"]);
			$achternaamAanpassen = htmlspecialchars($_POST["achternaam"]);
			$emailAangepast = htmlspecialchars($_POST["email"]);
			$telAanpassen = htmlspecialchars($_POST["telefoonnummer"]);
			$genderAanpassen = htmlspecialchars($_POST["gender"]);
			$straatAanpassen = htmlspecialchars($_POST["straatnaam"]);
			$huisnummerAanpassen = htmlspecialchars($_POST["huisnummer"]);
			$postcodeAanpassen = htmlspecialchars($_POST["postcode"]);
			$gemeenteAanpassen = htmlspecialchars($_POST["gemeente"]);

			$psswd_gevonden = 0;
			if(isset($_POST["psswd"]) and $_POST["psswd"] != ""){
				$psswdAanpassen = htmlspecialchars($_POST["psswd"]);
				$hashpsswdAanpassen = password_hash($psswdAanpassen, PASSWORD_BCRYPT);

				$zoek_psswd_query = "SELECT paswoord FROM klant";
                $resultaat_zoek_psswd = mysqli_query($link, $zoek_psswd_query);

                while ($row = mysqli_fetch_assoc($resultaat_zoek_psswd))
                {
                    $verifypsswd = password_verify($psswdAanpassen, $row['paswoord']);
                    if($verifypsswd == 1){
                        $psswd_gevonden = 1;
                    }
                }
                
                if($psswd_gevonden == 1){
?>
	<script>
        document.getElementById("tekst2").innerHTML = "Dit wachtwoord is niet veilig."
        document.getElementById("tekst3").innerHTML = "Kies een ander paswoord"
        document.getElementById("alert").style.display="block"
    </script>

<?php
				}else{
					$klant_psswd_aanpas_query = "UPDATE klant set paswoord = '$hashpsswdAanpassen' WHERE persoonID = '{$_SESSION["userID"]}'";
					mysqli_query($link, $klant_psswd_aanpas_query);
				}
			}

            

			$klant_aanpas_query = "UPDATE klant set voornaam = '$voornaamAanpassen', achternaam = '$achternaamAanpassen', email = '$emailAangepast', telefoonnummer = '$telAanpassen', gender = '$genderAanpassen', rol = '{$_POST['kies_rol']}', actief = '{$_POST['actief']}' WHERE persoonID = '$klantID'";
			mysqli_query($link, $klant_aanpas_query);

            echo($klant_aanpas_query);

			if(!empty($_POST["straatnaam"]) or !empty($_POST["huisnummer"]) or !empty($_POST["postcode"]) or !empty($_POST["gemeente"])){

				if(!empty($_POST["straatnaam"]) and !empty($_POST["huisnummer"]) and !empty($_POST["postcode"]) and !empty($_POST["gemeente"])){

					if ($straat == "" and $huisnummer == "" and $postcode == "" and $gemeente == "")
					{
						$insert_query = "INSERT INTO adres (persoonID, straatnaam, huisnummer, postcode, gemeente)    
							VALUES
							({$_SESSION["userID"]}, '$straatAanpassen', '$huisnummerAanpassen', '$postcodeAanpassen', '$gemeenteAanpassen')";
		
						mysqli_query($link, $insert_query);
					}else{
						$adres_aanpas_query = "UPDATE adres set straatnaam = '$straatAanpassen', huisnummer = '$huisnummerAanpassen', postcode = '$postcodeAanpassen', gemeente = '$gemeenteAanpassen'  WHERE persoonID = '$klantID'";
						mysqli_query($link, $adres_aanpas_query);
					}
				}
			}
		}
	}

	mysqli_close($link);
?>