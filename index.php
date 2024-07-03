<?php
session_start();
if(!isset($_SESSION['userRol'])){
	$_SESSION['userRol'] = "webuser";
}
?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Enchanted Vases</title>	
	<?php
	include ("./Standaard/header.php")
	?>
	<link href="./css/home.css" rel="stylesheet" />
</head>

<?php
	$file= "Enchanted Vases";
	if($_SESSION['userRol'] == 'owner'){
		include ("./Standaard/nav_owner.php");
	}else{
		include ("./Standaard/link_header_nav.php");
	}
?>

<div class="box1">
	<h1 class="welkom">
		Welkom op mijn site!
	</h1>
	<p class="welkom_klein">
		Hieronder vind je wat informatie over mijn bedrijf en over mezelf
	</p>
	<div class="box1_1">
		<img class="logo_img_links" src="./img/logo/totaal.png" alt="Logo_Enchanted_Vases"/>
		<p class="txt_links">Beste kunstliefhebbers,
			<br><br>
			Welkom bij Enchanted Vazen, waar kunst en betovering samenkomen in een harmonieuze symfonie van kleur, vorm en verbeelding. 
			<br>Mijn naam is Jana Heyvaert, de maker achter deze unieke creaties, en ik nodig jullie uit om de magie van handgeschilderde bloemvazen,
			<br>kaarsvazen en canvassen te ontdekken.
			<br><br>
			Bij Enchanted Vazen gaat elk stuk verder dan alleen maar decoratie; het is een verhaal op zichzelf,
			<br>verteld met penseelstreken vol passie en zorgvuldige overweging.<br>Mijn inspiratie ontspringt uit de natuurlijke schoonheid om me heen,
			<br>en ik geloof dat de alledaagse voorwerpen om ons heen getransformeerd kunnen worden tot kunstwerken die het hart raken.
			<br><br>
			De bloemvazen van Enchanted Vazen vangen de essentie van bloeiende pracht.<br>Elke penseelstreek is doordrenkt met liefde, 
			en elke vaas is een uniek kunstwerk dat de schoonheid van bloemen omhelst. 
			<br>De kaarsvazen, met hun zachte gloed, brengen een sfeer van warmte en betovering in elke ruimte.
			<br><br>
			De canvassen van Enchanted Vazen zijn een weerspiegeling van mijn innerlijke wereld, een reis door emoties en verbeelding. 
			<br>Elk schilderij nodigt uit tot contemplatie en biedt een venster naar een andere wereld, gevuld met kleurrijke dromen en poëtische verhalen.
			<br><br>
			Wat Enchanted Vazen onderscheidt, is niet alleen de esthetiek, maar ook het persoonlijke karakter van elk stuk.
			<br>Handgeschilderd met toewijding en zorg, dragen mijn creaties een stukje van mijn ziel en passie in zich.
			<br>Elk stuk vertelt een uniek verhaal dat wacht om deel uit te maken van jouw verhaal.
			<br><br>
			Bij Enchanted Vazen geloven we dat kunst niet alleen iets is om naar te kijken, maar iets om te ervaren.<br>
			Onze collectie is ontworpen om een vleugje magie en betovering aan je huis toe te voegen,
			<br>een plaats waar elke vaas en elk doek een moment van verwondering creëert.
			<br><br>
			Dank je wel voor het ontdekken van Enchanted Vazen. We hopen dat onze kunstwerken een bron van vreugde en inspiratie worden in jouw wereld.
			<br><br>
			Met betoverende groeten,
			<br><br>
			Jana Heyvaert
			<br>
			Enchanted Vazen</p>
	</div>

	<div class="box1_2">
		<div><img class="logo_img_rechts" src="./img/over_mij/Jana.jpg" alt="afbeelding van mezelf"/></div>
		<p class="txt_rechts">
			Mijn naam is Jana Heyvaert, een gepassioneerde kunstenaar uit het prachtige België, en ik ben verheugd om mijn creatieve reis met jullie te delen.
			<br>Op mijn 21-jarige leeftijd heb ik de unieke kans gehad om mijn liefde voor kunst te combineren met mijn bewondering voor de natuur.
			Met een passie voor kunst en design, <br> heb ik mijn eigen unieke wereld gecreëerd waarin ik beschilderde vazen, kaarsvazen en canvassen tot leven breng.
			<br><br>
			Mijn artistieke reis begon op jonge leeftijd, maar het was pas toen ik bloemen en hun symboliek begon te verkennen dat ik mijn ware passie ontdekte.
			<br>Mijn beschilderde vazen vangen de essentie van bloeiende schoonheid om de betovering van bloemen te vangen en te versterken,
			<br>terwijl mijn kaarsvazen een sfeer van warmte en gezelligheid creëren.<br> De canvassen die ik produceer zijn een expressie van mijn innerlijke
			wereld en mijn interpretatie van de wonderen van het leven. 
			<br><br>
			Als een jonge kunstenaar geloof ik sterk in de kracht van kunst om emoties te wekken en verhalen te vertellen.
			<br>Mijn beschilderde vazen zijn niet alleen decoratieve objecten; ze zijn expressies van mijn visie op de wereld en mijn streven naar schoonheid
			in alledaagse dingen. 
			<br><br>
			Ik nodig jullie uit om deel te nemen aan mijn reis, om de harmonie tussen kunst en natuur te ervaren door de delicate penseelstreken op mijn vazen.
			<br>Elk stuk dat mijn atelier verlaat, is doordrenkt met mijn persoonlijkheid en toewijding aan vakmanschap. 
			<br>Of je nu een bloemenliefhebber bent, een kunstverzamelaar of iemand die gewoon op zoek is naar een vleugje esthetiek in je leven,
			<br>ik hoop dat mijn beschilderde vazen een speciale betekenis voor je krijgen.
			<br><br>
 			Ik ben trots om mijn creaties te delen en hoop dat ze een plekje in jouw huis en hart vinden.
			<br>Samen kunnen we een ruimte creëren waar kunst en emotie samenkomen en waar de schoonheid van het alledaagse wordt gevierd. 
			
				
	</div>

</div>

<?php
    include("./Standaard/footer_eind.php")
?>