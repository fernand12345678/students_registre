<?php
  echo'<meta charset="utf-8">'; //pour gérer les accents
   //On vérifie si les champs sont vides
  if(empty($_POST['matricule']) OR empty($_POST['nom']) OR empty($_POST['sexe']))
    {
    echo '<font color="red" size="20">Attention, vérifiez que vous avez rempli les champs <b>Matricule, Nom et Sexe</b></font>';
    }
   else // Aucun champ n'est vide, on peut enregistrer les données dans la table  
  {
  //On récupère les données dans des variables
  $mat=$_POST['matricule'];
  $nom=$_POST['nom'];
  $prenom=$_POST['prenom'];
  $j=$_POST['jour'];
  $m=$_POST['mois'];
  $a=$_POST['annee'];
  if(empty($_POST['diplome']))
  $d=" ";
  else
  $d=$_POST['diplome']; //$d est un tableau de diplômes
  $s=$_POST['sexe'];
  $date=$a."-".$m."-".$j;
  //affectation de tous les diplomes dans une seule variable
  $diplomes=" ";
    for($i=0;$i<count($d);$i++) //count($d) retoune la taille du tableau $d
	 $diplomes.=$d[$i]." "; //équivaut à $diplomes=$diplomes.$d[$i]." ";
	$bd="BD_ELEVES";
    $host="localhost";
    $root="root";
    $pass="";
    $connection=mysql_connect($host,$root,$pass) or die ("ERREUR DE CONNEXION"); //connexion au serveur mySQL. On s'arrête si erreur de connexion
    mysql_select_db($bd,$connection); //sélection de la base si connexion à la base réussie                 
        $sql = "INSERT INTO eleve(Matricule, Nom, Prenom, DateNais, Sexe, Diplomes) VALUES('$mat','$nom','$prenom','$date','$s','$diplomes')";
        mysql_query($sql) or die(mysql_error()); //on exécute la requête en s'aarurant l'opération a réussie
        
        // on informe le visiteur que l'opération a réussi
        echo '<font color="skyblue" size="20">Vos infos ont été ajoutées dans la base de données.</font>';
       
	/*le code suivant permet d'afficher le contenu de la table dans un navigateur web*/
	$sql = "SELECT * FROM eleve";
    $req = mysql_query($sql) or die(mysql_error()); 
	$res = mysql_num_rows($req);
	if($res == 0)
	  echo '<font color="red" size="20">La table est vide</font>';
    else
	{
	echo '<table border=1>
	      <tr><th>Matricule</th><th>Nom</th><th>Prenom</th><th>Date de naissance</th><th>Sexe</th><th>Diplômes</th></tr>'; 
	 while($ligne=mysql_fetch_array($req)){
		echo '<tr>';
		echo'<td>'.$ligne[0].'</td>';
		echo'<td>'.$ligne[1].'</td>';
		echo'<td>'.$ligne[2].'</td>';
		echo'<td>'.$ligne[3].'</td>';
	    echo'<td>'.$ligne[4].'</td>';
		echo'<td>'.$ligne[5].'</td>';
	    echo'</tr>';
	}
	echo '</table>';
	}
    mysql_close();  // on ferme la connexion 
	}
?>