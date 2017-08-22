<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<link rel="icon" href="favicon.ico" />
		<link href="style.css" rel="stylesheet" media="all" type="text/css"> 
		<title>Vocabulaire de l'anglais contemporain</title>
		<?php include_once('includes/connexion.php'); ?>
	</head>
	<body>
		<div><h2><a href="index.php">Home</a></h2></div>
		<?php 
			$result1 = pg_query($dbconn, "SELECT * FROM grandecategorie ORDER BY id_grandecategorie");
			while ($row = pg_fetch_row($result1)) {
				echo "<hr />";
				//echo "<h1><a href =\"grandecategorie.php?id=$row[0]\"> $row[0] - $row[1] </a></h1>";
				echo "<h1> $row[0] - $row[1] </h1>";
				$result2 = pg_query($dbconn, "SELECT * FROM categorie WHERE id_grandecategorie = ".$row[0]." ORDER BY id_categorie");
				while ($row = pg_fetch_row($result2)) {
					//echo "<hr />";
					echo "<h2><a href =\"categorie.php?id=$row[0]\"> $row[0] - $row[1] </a></h2>";
					$result3 = pg_query($dbconn, "SELECT * FROM souscategorie WHERE id_categorie = ".$row[0]." ORDER BY id_souscategorie");
					while ($row = pg_fetch_row($result3)) {
						//echo "<hr />";
						echo "<h3> $row[0] - <a href =\"souscategorie.php?id=$row[0]\">$row[1] </a></h3>";
						//echo "<h3> $row[0] - $row[1] </h3>";
					} 
				} 
			} 
		?>
		<hr />
		<p>Liens : <a href="plan.php"/>le plan du livre</a>, <a href="touslesmots.php"/>tous les mots</a>.</p>	
	</body>
</html>


<!-- var_dump(pg_fetch_all($result)); 
<pre> print_r($arr); </pre> 
echo "<br />\n"; -->