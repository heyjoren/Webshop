<?php
    session_start();
    include_once "../error/log_sub.php";

    if(!isset($_SESSION['userRol'])){
        $_SESSION['userRol'] = "webuser";
    }
    $id = -1;
    $host = 'localhost';
    $user = 'webuser';
    $password = "Lab2021";

    $link = mysqli_connect($host, $user, $password) or die("Error: er kon geen conectie gemaakt worden.");

    $database = "webshop";

    mysqli_select_db($link, $database) or die("Error: database kon niet geopend worden");

    if(isset($_POST["register"])) {
        header("location:ceate_account.php");
    }
    if(isset($_POST["login"])){
        if(isset($_POST["email"]) and isset($_POST["psswd"])){
            $email = htmlspecialchars($_POST["email"]);     //joren@joren.com of owner2@owner2.be
            $psswd = htmlspecialchars($_POST["psswd"]);     //joren of owner

            try{
                $zoek_query = "SELECT email, paswoord, persoonID, gender, rol, actief  FROM klant WHERE email = '$email' AND actief = 1";
                $resultaat = mysqli_query($link, $zoek_query);

                while($row = mysqli_fetch_array($resultaat)){
                    $db_psswd = $row['paswoord'];
                    if(password_verify($psswd, $db_psswd)){
                        $id = $row['persoonID'];
                        $rol = $row['rol'];
                        $actief = $row['actief'];
                    }
                }

                if($id == -1){
                    throw new MyException("email of wachtwoord onjuist");
                }
            }catch (MyException $e) {
                $e->HandleException();
            }

            
            $zoek_winkelmans_query = "SELECT winkelmandID  FROM winkelmand WHERE persoonID = $id";
            $resultaat_winkelmand = mysqli_query($link, $zoek_winkelmans_query);


            while($row = mysqli_fetch_array($resultaat_winkelmand)){
                $winkelmandID = $row['winkelmandID'];
            }

            if($id >= 0){
                $_SESSION['userID'] = $id;
                $_SESSION['userRol'] = $rol;
                $_SESSION['userActief'] = $actief;
                $_SESSION['winkelmandID'] = $winkelmandID;
                header("location: ../Mijn_account.php");
            }
        }
    }
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <title>mijn account: login</title>
    <?php
	include ("../Standaard/header_sub_pages.php")
	?>
    <link href="../css/login.css" rel="stylesheet" />

    <script>
        function kruis()
            {
                document.getElementById("error").style.display="none"
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
            login
        </h1>
        <div class="middel">
            <form method="post">
                <div><input type="email" name="email" placeholder="email" class="invoer"/></div>
                <div><input type="password" name="psswd" placeholder="wachtwoord" id="psswd" class="invoer"/></div>
                <div><input type="submit" name="login" value="Login" id="login"/></div>
                <div><label>Ben je nog niet bekend bij ons? </label>
                <input type="submit" name="register" value="Registreer je dan nu"/>
                </div>
            </form>
        </div>

        <?php
        ?>

    </div>

    <?php
    include("../Standaard/footer_eind.php");

    mysqli_close($link);

    ?>