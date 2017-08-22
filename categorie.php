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
			$id_categorie = $_GET["id"];
			$result2 = pg_query($dbconn, "SELECT * FROM categorie WHERE id_categorie = ".$id_categorie." ORDER BY id_categorie");
			while ($row = pg_fetch_row($result2)) {
				echo "<hr />";
				echo "<h2><a href =\"categorie.php?id=$row[0]\"> $row[0] - $row[1] ($row[2]) </a></h2>";
				
				$result3 = pg_query($dbconn, "SELECT * FROM souscategorie WHERE id_categorie = ".$id_categorie." ORDER BY id_souscategorie");
				while ($row1 = pg_fetch_row($result3)) {
					echo "<hr />";
					echo "<h3><a href =\"souscategorie.php?id=$row1[0]\"> $row1[0] - $row1[1] ($row1[2]) </a></h3>";
					/**
					 * Concerne les mots directement liés à la sous-catégorie
					 */
					$sql1 = "SELECT id_groupedemot2 FROM vocabulaire WHERE id_categorie = ".$id_categorie." AND id_souscategorie = ".$row1[0]." AND id_branche=0 ORDER BY id";
					//echo $sql1;
					$result3b = pg_query($dbconn, $sql1);						
					$id_groupedemot2 = array();
					while ($rowb = pg_fetch_assoc($result3b)) {
						$id_groupedemot2[] = $rowb["id_groupedemot2"];
					}
					if (!empty($id_groupedemot2)) {
						$gpm = array_unique($id_groupedemot2);
						//print_r($gpm); // Les différents paragraphes
						foreach ($gpm as $k => $v) {
							//echo "$v\n";
							echo "<hr />"; // Permet de les séparer
							$result3c = pg_query($dbconn, "SELECT id_groupedemot FROM vocabulaire WHERE id_souscategorie = ".$row1[0]." AND id_groupedemot2 = ".$v." ORDER BY id");
							$id_groupedemot = array();
							while ($rowc = pg_fetch_assoc($result3c)) {
								$id_groupedemot[] = $rowc["id_groupedemot"];
							}
							if (!empty($id_groupedemot)) {
								$gp = array_unique($id_groupedemot);
								//print_r($gp); // Les différents mots liés
								foreach ($gp as $k2 => $v2) {
									//echo "$v2\n";
									echo "<br />"; // Permet de les séparer
									$result3d = pg_query($dbconn, "SELECT id FROM vocabulaire WHERE id_souscategorie = ".$row1[0]." AND id_groupedemot = ".$v2." ORDER BY id");
									$id = array();
									while ($rowd = pg_fetch_assoc($result3d)) {
										$id[] = $rowd["id"];
									}
									$g = array_unique($id);
									//print_r($g); // Les différents mots
									foreach ($g as $k3 => $v3) {
										echo "<br />"; // Permet de sauter une ligne entre les mots
										$result3e = pg_query($dbconn, "SELECT vocabulaire, traduction, vocabulaire_plus, traduction_plus FROM vocabulaire WHERE id_souscategorie = ".$row1[0]." AND id = ".$v3." ORDER BY id");
										while ($rowe = pg_fetch_assoc($result3e)) {
											$vocabulaire = $rowe["vocabulaire"];
											$traduction = $rowe["traduction"];
											$vocabulaire_plus = $rowe["vocabulaire_plus"];
											$traduction_plus = $rowe["traduction_plus"];
										}
										echo "<b>".$vocabulaire."</b> (".$traduction.")";
										if ($vocabulaire_plus != "NULL") {
											echo " --- <b>".$vocabulaire_plus."</b> : ".$traduction_plus;
										}
									}
								}
							}
						}
					}

					$result4 = pg_query($dbconn, "SELECT * FROM branche WHERE id_souscategorie = ".$row1[0]." ORDER BY id_branche");
					while ($row2 = pg_fetch_row($result4)) {
						echo "<hr />";
						echo "<h4> $row2[0] - $row2[1] ($row2[2]) </h4>";
						/**
						 * Concerne les mots directement liés à la branche
						 */
						$result4b = pg_query($dbconn, "SELECT id_groupedemot2 FROM vocabulaire WHERE id_branche = ".$row2[0]." AND id_categorie = ".$id_categorie." AND id_sousbranche=0 ORDER BY id");						
						$id_groupedemot2b = array();
						while ($row2b = pg_fetch_assoc($result4b)) {
							$id_groupedemot2b[] = $row2b["id_groupedemot2"];
						}
						if (!empty($id_groupedemot2b)) {
							$gpm2 = array_unique($id_groupedemot2b);
							//print_r($gpm2); // Les différents paragraphes
							foreach ($gpm2 as $kb => $vb) {
								//echo "$vb\n";
								echo "<hr />"; // Permet de les séparer
								$result4c = pg_query($dbconn, "SELECT id_groupedemot FROM vocabulaire WHERE id_branche = ".$row2[0]." AND  id_groupedemot2 = ".$vb." ORDER BY id");
								$id_groupedemotb = array();
								while ($row2c = pg_fetch_assoc($result4c)) {
									$id_groupedemotb[] = $row2c["id_groupedemot"];
								}
								if (!empty($id_groupedemotb)) {
									$gp2 = array_unique($id_groupedemotb);
									//print_r($gp2); // Les différents mots liés
									foreach ($gp2 as $k2b => $v2b) {
										//echo "$v2b\n";
										echo "<br />"; // Permet de les séparer
										$result4d = pg_query($dbconn, "SELECT id FROM vocabulaire WHERE id_branche = ".$row2[0]." AND  id_groupedemot = ".$v2b." ORDER BY id");
										$idb = array();
										while ($row2d = pg_fetch_assoc($result4d)) {
											$idb[] = $row2d["id"];
										}
										$g2 = array_unique($idb);
										//print_r($g2); // Les différents mots
										foreach ($g2 as $k3b => $v3b) {
											echo "<br />"; // Permet de sauter une ligne entre les mots
											$result4e = pg_query($dbconn, "SELECT vocabulaire, traduction, vocabulaire_plus, traduction_plus FROM vocabulaire WHERE id_branche = ".$row2[0]." AND id = ".$v3b." ORDER BY id");
											while ($row2e = pg_fetch_assoc($result4e)) {
												$vocabulaireb = $row2e["vocabulaire"];
												$traductionb = $row2e["traduction"];
												$vocabulaireb_plus = $row2e["vocabulaire_plus"];
												$traductionb_plus = $row2e["traduction_plus"];												
											}
											echo "<b>".$vocabulaireb."</b> (".$traductionb.")";
											if ($vocabulaireb_plus != "NULL") {
												echo " --- <b>".$vocabulaireb_plus."</b> : ".$traductionb_plus;
											}
										}
									}
								}
							}
						}

						$result5 = pg_query($dbconn, "SELECT * FROM sousbranche WHERE id_branche = ".$row2[0]." ORDER BY id_sousbranche");
						while ($row3 = pg_fetch_row($result5)) {
							echo "<hr />";
							echo "<h5> $row3[0] - $row3[1] ($row3[2]) </h5>";
							/**
							 * Concerne les mots directement liés à la sous-branche
							 */
							$result5b = pg_query($dbconn, "SELECT id_groupedemot2 FROM vocabulaire WHERE id_sousbranche = ".$row3[0]." ORDER BY id");						
							$id_groupedemot2c = array();
							while ($row3b = pg_fetch_assoc($result5b)) {
								$id_groupedemot2c[] = $row3b["id_groupedemot2"];
							}
							if (!empty($id_groupedemot2c)) {
								$gpm3 = array_unique($id_groupedemot2c);
								//print_r($gpm3); // Les différents paragraphes
								foreach ($gpm3 as $kc => $vc) {
									//echo "$v\n";
									echo "<hr />"; // Permet de les séparer
									$result5c = pg_query($dbconn, "SELECT id_groupedemot FROM vocabulaire WHERE id_sousbranche = ".$row3[0]." AND  id_groupedemot2 = ".$vc." ORDER BY id");
									$id_groupedemotc = array();
									while ($row3c = pg_fetch_assoc($result5c)) {
										$id_groupedemotc[] = $row3c["id_groupedemot"];
									}
									if (!empty($id_groupedemotc)) {
										$gp3 = array_unique($id_groupedemotc);
										//print_r($gp3); // Les différents mots liés
										foreach ($gp3 as $k2c => $v2c) {
											//echo "$v2c\n";
											echo "<br />"; // Permet de les séparer
											$result5d = pg_query($dbconn, "SELECT id FROM vocabulaire WHERE id_sousbranche = ".$row3[0]." AND  id_groupedemot = ".$v2c." ORDER BY id");
											$idc = array();
											while ($row3d = pg_fetch_assoc($result5d)) {
												$idc[] = $row3d["id"];
											}
											$g3 = array_unique($idc);
											//print_r($g3); // Les différents mots
											foreach ($g3 as $k3c => $v3c) {
												echo "<br />"; // Permet de sauter une ligne entre les mots
												$result5e = pg_query($dbconn, "SELECT vocabulaire, traduction, vocabulaire_plus, traduction_plus FROM vocabulaire WHERE id_sousbranche = ".$row3[0]." AND id = ".$v3c." ORDER BY id");
												while ($row3e = pg_fetch_assoc($result5e)) {
													$vocabulairec = $row3e["vocabulaire"];
													$traductionc = $row3e["traduction"];
													$vocabulairec_plus = $row3e["vocabulaire_plus"];
													$traductionc_plus = $row3e["traduction_plus"];
												}
												echo "<b>".$vocabulairec."</b> (".$traductionc.")";
												if ($vocabulairec_plus != "NULL") {
													echo " --- <b>".$vocabulairec_plus."</b> : ".$traductionc_plus;
												}
											}
										}
									}
								}
							}					
						} 
					} 
				} 
			} 
		?>
		
	</body>
</html>