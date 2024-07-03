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

	$zoek_query = "SELECT gender, email, telefoonnummer, voornaam, achternaam  FROM klant WHERE persoonID = '{$_SESSION["userID"]}'";
    $resultaat_klant = mysqli_query($link, $zoek_query);

    while($row_klant = mysqli_fetch_array($resultaat_klant)){
        $gender = $row_klant['gender'];
		$email = $row_klant['email'];
		$tel = $row_klant['telefoonnummer'];
		$voornaam = $row_klant['voornaam'];
		$achternaam = $row_klant['achternaam'];
	}

	$straat = "";
	$huisnummer = "";
	$postcode = "";
	$gemeente = "";

	$zoek_adres_query = "SELECT straatnaam, huisnummer, postcode, gemeente  FROM adres WHERE persoonID = '{$_SESSION["userID"]}'";
    $resultaat_adres = mysqli_query($link, $zoek_adres_query);

	while($row_adres = mysqli_fetch_array($resultaat_adres)){
		$straat = (!empty($row_adres['straatnaam'])) ? $row_adres['straatnaam'] : "";
        $huisnummer = (!empty($row_adres['huisnummer'])) ? $row_adres['huisnummer'] : "";
        $postcode = (!empty($row_adres['postcode'])) ? $row_adres['postcode'] : "";
        $gemeente = (!empty($row_adres['gemeente'])) ? $row_adres['gemeente'] : "";
	}

	if(isset($_POST['factuur'])){
        header('location:./owner/show_Factuur.php?nr=' .$_POST['afrekeningID']);
    }

?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<title>mijn account</title>	
	<?php
	include ("./Standaard/header.php")
	?>
	<link href="./css/Mijn_account.css" rel="stylesheet" />
	<script>

		function bekijk_factuur(){
			document.getElementById("box1_2").style.display="block";
		};

		function kruis()
		{
			document.getElementById("alert").style.display="none";
		};
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
		Mijn account
	</h1>
	<div class="box1_1">

		<div class="box2" id='box2'>
			<p class="subonderdeel">gegevens</p>
			<table class="table">
				<tr class="table_row">
					<td class="table_links">naam
					</td>
					<td class="table_midden">:
					</td>
					<td class="table_rechts">
						<?php
							echo"$voornaam"
						?>
					</td>
				</tr>
				<tr class="table_row">
					<td class="table_links">achternaam
					</td>
					<td class="table_midden">:
					</td>
					<td class="table_rechts">
						<?php
							echo"$achternaam"
						?>
					</td>
				</tr>
				<tr>
					<td class="table_links">email adres
					</td>
					<td class="table_midden">:
					</td>
					<td class="table_rechts">
						<?php
							echo"$email"
						?>
					</td>
				</tr>
				<tr>
					<td class="table_links">telefoonnummer
					</td>
					<td class="table_midden">:
					</td>
					<td class="table_rechts">
						<?php
							echo"$tel"
						?>
					</td>
				</tr>
				<tr>
					<td class="table_links">gender
					</td>
					<td class="table_midden">:
					</td>
					<td class="table_rechts">
						<?php
							echo"$gender"
						?>
					</td>
				</tr>
				<tr>
					<td class="table_links">straatnaam
					</td>
					<td class="table_midden">:
					</td>
					<td class="table_rechts">
						<?php
							echo"$straat"
						?>
					</td>
				</tr>
				<tr>
					<td class="table_links">huisnummer
					</td>
					<td class="table_midden">:
					</td>
					<td class="table_rechts">
						<?php
							echo"$huisnummer"
						?>
					</td>
				</tr>
				<tr>
					<td class="table_links">postcode
					</td>
					<td class="table_midden">:
					</td>
					<td class="table_rechts">
						<?php
							echo"$postcode"
						?>
					</td>
				</tr>
				<tr>
					<td class="table_links_laatste">gemeente
					</td>
					<td class="table_midden_laatste">:
					</td>
					<td class="table_rechts_laatste">
						<?php
							echo"$gemeente"
						?>
					</td>
				</tr>
			</table>
			
		</div>

		<div class="box3">
			<p class="subonderdeel">aanpassen</p>
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

	<div>
		<form method="post" action="./Mijn_account_sub_page/logout.php">
			<div class="log_out"><input type="submit" name="log_out" value="log uit" /></div>
		</form>
	</div>
	<div>
		<form form method="post" action="">
			<div class="bekijk_factuur"><input type="button" name="bekijk_facturen" value="bekijk hier jouw facturen" onclick="bekijk_factuur()"/></div>
		</form>
	</div>

	<div class="box1_2" id="box1_2">
        <div class="box1_3">
            <p>Je kan hier jouw facturen zien.</p>
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
                $afrekening_toon_query = "SELECT afrekeningID, persoonID, datum, totaalPrijs FROM afrekening WHERE persoonID=" . $_SESSION["userID"] . " ORDER BY datum DESC";
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
    include("./Standaard/footer_eind.php");

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

			$klant_aanpas_query = "UPDATE klant set voornaam = '$voornaamAanpassen', achternaam = '$achternaamAanpassen', email = '$emailAangepast', telefoonnummer = '$telAanpassen', gender = '$genderAanpassen' WHERE persoonID = {$_SESSION['userID']}";
			mysqli_query($link, $klant_aanpas_query);

			if(!empty($_POST["straatnaam"]) or !empty($_POST["huisnummer"]) or !empty($_POST["postcode"]) or !empty($_POST["gemeente"])){

				if(!empty($_POST["straatnaam"]) and !empty($_POST["huisnummer"]) and !empty($_POST["postcode"]) and !empty($_POST["gemeente"])){

					try{
						if($huisnummerAanpassen <= 0){
							throw new MyException("Je kan geen huisnummer gelijk aan of onder 0 hebben");
						}
						if ($straat == "" and $huisnummer == "" and $postcode == "" and $gemeente == "")
						{
							$insert_query = "INSERT INTO adres (persoonID, straatnaam, huisnummer, postcode, gemeente)    
								VALUES
								({$_SESSION["userID"]}, '$straatAanpassen', '$huisnummerAanpassen', '$postcodeAanpassen', '$gemeenteAanpassen')";
			
							mysqli_query($link, $insert_query);
						}else{
							$adres_aanpas_query = "UPDATE adres set straatnaam = '$straatAanpassen', huisnummer = '$huisnummerAanpassen', postcode = '$postcodeAanpassen', gemeente = '$gemeenteAanpassen'  WHERE persoonID = '{$_SESSION["userID"]}'";
							mysqli_query($link, $adres_aanpas_query);
						}
					}catch (MyException $e) {
						$update_aantal_query = "UPDATE productinwinkelmand SET aantal=$voorraad WHERE winkelmandID = {$_SESSION['winkelmandID']} and productID = {$_POST['productID']}";
			
						mysqli_query($link, $update_aantal_query);
		
						$e->HandleException();
					}
				}
			}
		}

	}

	mysqli_close($link);
?>