<!--$result = pg_query($dbconn, "select * from vocabulaire");
var_dump(pg_fetch_all($result)); 
echo "<br />\n"; -->
	
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
		<div><h2><a href="index.php">Home</a></h2><br></div>

		<?php 
			$result1 = pg_query($dbconn, "SELECT * FROM grandecategorie ORDER BY id_grandecategorie");
			while ($row = pg_fetch_row($result1)) {
				echo "<hr />";
				echo "<h1> $row[0] - $row[1] </h1>";
				$result2 = pg_query($dbconn, "SELECT * FROM categorie WHERE id_grandecategorie = ".$row[0]." ORDER BY id_categorie");
				while ($row = pg_fetch_row($result2)) {
					echo "<h2> $row[0] - $row[1] </h2>";
					$result3 = pg_query($dbconn, "SELECT * FROM souscategorie WHERE id_categorie = ".$row[0]." ORDER BY id_souscategorie");
					while ($row = pg_fetch_row($result3)) {
						echo "<h3> $row[0] - $row[1] </h3>";
						/**
						 * Concerne les mots directement liés à la sous-catégorie
						 */
						echo "<ul>";
						$result3b = pg_query($dbconn, "SELECT vocabulaire, traduction FROM vocabulaire WHERE id_souscategorie = ".$row[0]." AND id_branche=0 ORDER BY id");
						while ($rowb = pg_fetch_row($result3b)) {
							//echo "<li> $rowb[0] ($rowb[1]) </li>";
						} echo "</ul>";


						$result4 = pg_query($dbconn, "SELECT * FROM branche WHERE id_souscategorie = ".$row[0]." ORDER BY id_branche");
						while ($row = pg_fetch_row($result4)) {
							echo "<h4> $row[0] - $row[1] </h4>";
							/**
							 * Concerne les mots directement liés à la branche
							 */
							echo "<ul>";
							$result4b = pg_query($dbconn, "SELECT vocabulaire, traduction FROM vocabulaire WHERE id_branche = ".$row[0]." AND id_sousbranche=0 ORDER BY id");
							while ($rowc = pg_fetch_row($result4b)) {
								//echo "<li> $rowc[0] ($rowc[1]) </li>";
							} echo "</ul>";


							$result5 = pg_query($dbconn, "SELECT * FROM sousbranche WHERE id_branche = ".$row[0]." ORDER BY id_sousbranche");
							while ($row = pg_fetch_row($result5)) {
								echo "<h5> $row[0] - $row[1] </h5>";
								/*
								* Concerne les mots directement liés à la sous-branche
								 */
								echo "<ul>";
								$result5b = pg_query($dbconn, "SELECT vocabulaire, traduction FROM vocabulaire WHERE id_sousbranche = ".$row[0]." ORDER BY id");
								while ($rowd = pg_fetch_row($result5b)) {
									//echo "<li> $rowd[0] ($rowd[1]) </li>";
								} echo "</ul>";

									
							} 
						} 
					} 
				} 
			} 
		?>
	</body>
</html>