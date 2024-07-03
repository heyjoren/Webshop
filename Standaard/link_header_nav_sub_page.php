<?php
$counter=0;
if(isset($_SESSION["userID"])){
	$host = 'localhost';
    $user = 'webuser';
    $password = "Lab2021";

    $link = mysqli_connect($host, $user, $password) or die("Error: er kon geen conectie gemaakt worden.");

    $database = "webshop";

    mysqli_select_db($link, $database) or die("Error: database kon niet geopend worden");
    $leeg_bestellen_query = "SELECT aantal FROM productinwinkelmand WHERE winkelmandID = {$_SESSION['winkelmandID']}";
    $leeg_bestellen_resultaat = mysqli_query($link, $leeg_bestellen_query);

    while($leeg_bestellen_row = mysqli_fetch_array($leeg_bestellen_resultaat)){
        $counter += $leeg_bestellen_row['aantal'];
    }
}
?>

<body>
	<div class="wrapper">
		<header>
			<img class="logo" src="../img/logo/totaal.png" alt="Logo_Enchanted_Vases"/>
		</header>

		<nav>
			<ul>
				<li><a href="../index.php">Enchanted Vases</a></li>
				<li><a href="../Producten.php">Producten</a></li>
				<li class="navl">
					<a href="../Winkelmand.php" class="nav_rechts">
						<?php
							if($counter > 0){
								echo("<span class='counter'>");
									echo($counter);
								echo("</span>");
							}
						?>
						<img class="icon_nav" src="../img/Icoon/shopping_cart_blauwsite.png" alt="icon winkelkar">
						<p class="icon_p">winkelmandje</p>
					</a>
				</li>
				<li class="navl">
					<a href="../Mijn_account.php">
					<img class="icon_nav" src="../img/Icoon/onlog_icoon_blauwsite.png" alt="icon acount">Mijn account</a>
				</li>
			</ul>
		</nav>