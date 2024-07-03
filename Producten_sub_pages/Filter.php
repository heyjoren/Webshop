<?php
    session_start();

    $host = 'localhost';
    $user = 'webuser';
    $password = "Lab2021";

    $link = mysqli_connect($host, $user, $password) or die("Error: er kon geen connectie gemaakt worden.");

    $database = "webshop";

    mysqli_select_db($link, $database) or die("Error: database kon niet geopend worden");

    $show_query = "SELECT * FROM producten WHERE actief = 1 and aantalOpVoorraad > 0";

    $vasen = ($_GET['vasen']);
    $bloemen = ($_GET['bloemen']);
    $kaarsen = ($_GET['kaarsen']);
    $schilderijen = ($_GET['schilderijen']);

    $categorie=0;
    $subcategorie=0;

    if($vasen == 'true'){
        if($categorie ==0){
            $show_query .= " and categorie = 'vazen'";
            $categorie =1;
        }else{
            $show_query .= " or categorie = 'vazen'";
        }
        
    }

    if($bloemen == 'true'){
        if($subcategorie ==0){
            $show_query .= " and subcategorie = 'bloemen'";
            $subcategorie =1;
        }else{
            $show_query .= " or subcategorie = 'bloemen'";
        } 
    }

    if($kaarsen == 'true'){
        if($subcategorie ==0){
            $show_query .= " and subcategorie = 'kaarsen'";
            $subcategorie =1;
        }else{
            $show_query .= " or subcategorie = 'kaarsen'";
        }
    }

    if($schilderijen == 'true'){
        if($categorie ==0){
            $show_query .= " and categorie = 'schilderij'";
            $categorie =1;
        }else{
            $show_query .= " or categorie = 'schilderij'";
        }
        
    }

    $resultaat_show = mysqli_query($link, $show_query);

    while($row_show = mysqli_fetch_array($resultaat_show)){
        echo("<div class='box_product' id='box_product'>");
            echo("<img class='afbeelding_porduxt' src='{$row_show['afbeelding']}' alt='afbeelding {$row_show['naam']}'>");
            echo("<div class='product_onderstaande'>");
                echo("<div class='product_text'>");
                    echo("<p class='naam_product'>".$row_show['naam']."");
                    echo("<a class='prijs_product'>€".number_format($row_show['prijs'], 2, ',', ' ')."</a></p>");
                echo("</div>");
                echo("<form method='post'");
                    echo("<p class='button'><input type='submit' name='toevoegen_winkelmand' value='toevoegen aan winkelmandje' onclick='start()' /></p>");
                    echo("<input type='hidden' name='productID' value={$row_show['productID']}>");
                echo("</form>");
            echo("</div>");
        echo("</div>");
    }

    mysqli_close($link);

?>