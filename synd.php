<?php
  header('Content-type: text/xml');

  // Connexion sur le serveur de base de données
  $link = mysql_connect('localhost', 'root', '')  or die('Could not connect: ' . mysql_error());
  // Sélection de la base de données 'football'
  mysql_select_db('Journal') or die('Could not select database');
  
  // Requête SQL
  $query = 'SELECT ID,TITLE,SUBTITLE,AUTHOR,POSTED FROM Articles ORDER BY POSTED DESC limit 25;';
 
  // Exécution et récupération du résultat
  $result = mysql_query($query) or die('Query failed: ' . mysql_error());

  // Affichage de l'entête du flux ATOM
  echo "<?xml version='1.0' encoding='iso-8859-1' ?>
<feed xml:lang='fr-fr' xmlns='http://www.w3.org/2005/Atom'>
  <title>Le Gorges Atom</title>
  <subtitle>Le journal indépendant du lycée Pompidou</subtitle>
  <link href='http://localhost/synd.php' rel='self'/>
  <updated>";
  echo date(DATE_ATOM);
  echo "</updated>
  <author>
       <name>Votre Nom</name>
       <email>contact@monclub.fr</email>
  </author>
  <id> tag:LeGorges,http://localhost/synd.php </id>";
?>
<?php
// Parcours des résultats et création du flux ATOM
$i = 0;
while($row = mysql_fetch_array($result)) {
  if ($i > 0) {
    echo "</entry>";
  }
  echo "<entry>";
  echo "<title>";
  echo $row['TITLE'];
  echo "</title>";
  echo "<link type='text/html' href='http://www.monclub.fr/reports/report.php?id=".$row['ID']."'/>";
  echo "<id>";
  echo "tag:monclub.fr,2011:http://www.monclub.fr/reports/report.php?id=".$row['ID'];
  echo "</id>";
  echo "<updated>";
  echo date(DATE_ATOM, strtotime($row['POSTED']));
  echo "</updated>";
  echo "<author>";
  echo "<name>";
  echo $row['AUTHOR'];
  echo "</name>";
  echo "</author>";
  echo "<summary>";
  echo $row['SUBTITLE'];
  echo "</summary>";
  $i++;
}
echo "</entry>
</feed>";
?>

