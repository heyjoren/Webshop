<?php
    session_start();
    if(!isset($_SESSION['userRol'])){
        $_SESSION['userRol'] = "webuser";
    }
    $psswd_gevonden = 0;
    $host = 'localhost';
    $user = 'webuser';
    $password = "Lab2021";

    $link = mysqli_connect($host, $user, $password) or die("Error: er kon geen conectie gemaakt worden.");

    $database = "webshop";

    mysqli_select_db($link, $database) or die("Error: database kon niet geopend worden");
?>


<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <title>mijn account: create account</title>
    <?php
	include ("../Standaard/header_sub_pages.php")
	?>
    <link href="../css/Create_account.css" rel="stylesheet" />

    <script>

        function kruis()
        {
            document.getElementById("alert").style.display="none"
        }
    </script>

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
            Account aanmaken
        </h1>
        <div class="middel">
            <form method="post">
                <div class="velden"><label>Voornaam</label> <input type="text" name="voornaam" placeholder="Jolien" id="voornaam" class="input1"/></div>
                <div class="velden"><label>Achternaam</label> <input type="text" name="achternaam" placeholder="Druits" id="achternaam" class="input2"/></div>
                <div class="velden"><label>Email</label> <input type="email" name="email" placeholder="jolien.Druits@gmail.com" class="input3"/></div>
                <div class="velden"><label>Telefoonnummer</label> <input type='tel' name="telefoonnummer" id="tel" placeholder="0032 123 45 67 89" pattern="[0]{2}[0-9]{2} [0-9]{3} [0-9]{2} [0-9]{2} [0-9]{2}" class="input4"/></div>
                <div class="velden"><label>Wachtwoord</label> <input type="password" name="psswd" placeholder="wachtwoord" id="psswd" class="input5"/></div>
                <div class="velden">
                    <div class="radio">
                        <label>Man</label> <input type="radio" id="M" value="M" name="gender" checked="checked"> 
                        <label>Vrouw</label> <input type="radio" id="V" value="F" name="gender">
                        <label>X</label> <input type="radio" id="X" value="X" name="gender">
                    </div></div>
                <div class="button"><input type="submit" name="accout_aanmaken" value="account aanmaken" /></div>

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

    <?php
    include("../Standaard/footer_eind.php");
    if (isset($_POST["accout_aanmaken"])){
        if(isset($_POST["voornaam"]) and (isset($_POST["achternaam"])) and (isset($_POST["email"])) and (isset($_POST["telefoonnummer"])) and (isset($_POST["psswd"])) and (isset($_POST["gender"]))){
            $voornaam = htmlspecialchars($_POST["voornaam"]);
            $achternaam = htmlspecialchars($_POST["achternaam"]);
            $email = htmlspecialchars($_POST["email"]);
            $tel = htmlspecialchars($_POST["telefoonnummer"]);
            $psswd = htmlspecialchars($_POST["psswd"]);
            $hashpsswd = password_hash($psswd, PASSWORD_BCRYPT);
            $rol = "webuser";
            $active = 1;


            $gender =($_POST["gender"]);
            if ($gender == "M"){
                $gender = "M";
            }
            if ($gender == "F"){
                $gender = "F";
            }
            if ($gender == "X"){
                $gender = "X";
            }

            //voor een unieke email te hebben:
            $zoek_email_query = "SELECT email FROM klant WHERE email = '$email'";
            $resultaat_zoek_email = mysqli_query($link, $zoek_email_query);
            $resultaat_zoek_email_rijen = mysqli_num_rows($resultaat_zoek_email);

            if($resultaat_zoek_email_rijen == 1){ 
    ?>
    <script>
        document.getElementById('tekst2').innerHTML = 'Dit mail adres is al in gebruik.'
        document.getElementById('tekst3').innerHTML = 'Geef een andere email in of log in met je bestaande account'
        document.getElementById('alert').style.display='block'
    </script>
<?php

            }else{
                //voor een uniek passwoord te hebben:
                $zoek_psswd_query = "SELECT paswoord FROM klant";
                $resultaat_zoek_psswd = mysqli_query($link, $zoek_psswd_query);

                while ($row = mysqli_fetch_assoc($resultaat_zoek_psswd))
                {
                    $verifypsswd = password_verify($psswd, $row['paswoord']);
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
                }else
                {
                    $insert_query = "INSERT INTO klant (voornaam, achternaam, email, telefoonnummer, paswoord, gender, rol, actief)    
                    VALUE
                    ('$voornaam', '$achternaam', '$email', '$tel', '$hashpsswd', '$gender', '$rol', '$active')";

                    mysqli_query($link, $insert_query);

                    $persoonID_query = "SELECT persoonID FROM klant WHERE email='$email'";

                    $resultaat_persoonID = mysqli_query($link, $persoonID_query);

                    while($row = mysqli_fetch_array($resultaat_persoonID)){
                        $persoonID = $row['persoonID'];
                    }

                    $insert_query = "INSERT INTO winkelmand (persoonID)    
                    VALUE
                    ('$persoonID')";

                    mysqli_query($link, $insert_query);

                }
            }
        }
    }

?>
    <?php
    mysqli_close($link);

    if (isset($insert_query)){
        header("location:login.php");
    }

    ?>