<style>
	table table{
		text-align: center;
		width: 90px;
		height: 90px;
	}
	
	table tr td table tr td{
		border: 1px solid black;
	}
	
</style>
<!-- code php -->
<?
print " <br>\n";
/*********         les variables                                  *************/
// grille 'sudoku', caractères de "1" à "9", case $i,$j
$grille = array();
// masque de la grille: 0 = non masquable, 1 = la case peut être masquée
$masque = array();
// loterie est une chaine de caractères pour le tirage des cases restantes
$loterie = "";
// variable collision pour tester le cas où on tirerais la même case
$collision = 0; 
// la grille est divisée en 9 régions, 9 lignes et 9 colonnes
// les tableaux $reg,$lgn,$col sont indexés 'numéro,chiffre' ($n,$m m=chiffre-1)
// les valeurs sont des chaines de caractères indiquant les positions possibles
$reg = array();
$lgn = array();
$col = array();
//
/*********         fonctions                                      *************/
function initialisation(){
  global $grille ,$masque ,$loterie ,$collision;
  global $reg, $lgn, $col;
  $loterie = "";
  $collision = 0;
  // iniatisation, grille et masque, d'abord initialisée à '0'
  for ($i=0; $i<=8; $i++){
    for ($j=0; $j<=8; $j++){
      $grille[$i][$j] = "0";
      $masque[$i][$j] = 0;
      $loterie = $loterie.chr(97+$i).chr(48+$j);
    }
  }
  // au début toutes les positions sont possibles
  for ($n=0; $n<=8; $n++){
    for ($m=0; $m<=8; $m++){
      $reg[$n][$m] = "012345678";
      $lgn[$n][$m] = "012345678";
      $col[$n][$m] = "012345678";
    }
  }
}
//
function elimination($i,$j,$m){
  global $grille ,$masque ,$loterie ,$collision;
  global $reg, $lgn, $col;
  // case $i,$j , chiffre= $m+1
  // élimination du chiffre en mettant les positions possibles à rien (= "")
  $n = floor($i/3)*3+floor($j/3); // région concernée numéro $n
  $reg[$n][$m] = "";
  $n = $i; // ligne concernée numéro $n
  $lgn[$n][$m] = "";
  $n = $j; // colonne concernée numéro $n
  $col[$n][$m] = "";
  // élimination sélective des positions possibles  dans les régions voisines
  for($n=0; $n<=8; $n++){
    for ($p=0; $p<=8; $p++){
      // $p est la position d'une case dans une région
      // position de la case en coordonnées 'grille', $ic,$jc
      $ic = floor($n/3)*3+floor($p/3);
      $jc = ($n-floor($n/3)*3)*3+($p-floor($p/3)*3);
      if ($ic==$i or $jc==$j){
        $posi = chr(48+$p);
        $reg[$n][$m] = str_replace($posi,"",$reg[$n][$m]);
      }
    }
  }
  // élimination sélective des positions possibles  dans les lignes voisines
  $posi = chr(48+$j);
  for($n=0; $n<=8; $n++){
    $lgn[$n][$m] = str_replace($posi,"",$lgn[$n][$m]);
  }
  // élimination sélective des positions possibles  dans les colonnes voisines
  $posi = chr(48+$i);
  for($n=0; $n<=8; $n++){
    $col[$n][$m] = str_replace($posi,"",$col[$n][$m]);
  }
  // élimination sélective des positions possibles, lignes-colonnes/région
  $n = floor($i/3)*3+floor($j/3); // région concernée numéro $n
  for($p=0; $p<=8; $p++){
    // position de la case en coordonnées 'grille', $ic,$jc
    $ic = floor($n/3)*3+floor($p/3);
    $jc = ($n-floor($n/3)*3)*3+($p-floor($p/3)*3);
    $posi = chr(48+$jc);
    $lgn[$ic][$m] = str_replace($posi,"",$lgn[$ic][$m]);
    $posi = chr(48+$ic);
    $col[$jc][$m] = str_replace($posi,"",$col[$jc][$m]);
  }
  // élimination de la position occupée quelque soit le chiffre
  for($mc=0; $mc<=8; $mc++){
    // régions (la région concernée, numéro $n)
    $n = floor($i/3)*3+floor($j/3);
    $p = ($i-floor($i/3)*3)*3+($j-floor($j/3)*3);
    $posi = chr(48+$p);
    $reg[$n][$mc] = str_replace($posi,"",$reg[$n][$mc]);
    // lignes
    $posi = chr(48+$j);
    $lgn[$i][$mc] = str_replace($posi,"",$lgn[$i][$mc]);
    // colonnes
    $posi = chr(48+$i);
    $col[$j][$mc] = str_replace($posi,"",$col[$j][$mc]);
  }
}
//
function affectation($i,$j,$m,$d){
  global $grille ,$masque ,$loterie ,$collision;
  if ($grille[$i][$j]== "0"){
    $grille[$i][$j]= chr(48+$m+1);
    $posi = chr(97+$i).chr(48+$j);
    $loterie = str_replace($posi,"",$loterie);
    elimination($i,$j,$m);
    if ($d== "1") $masque[$i][$j]= 1;
  }
  else{
    $collision++;
  }
}
/*********         boucle                                         *************/
$tentative = 0;
$tentative_max = 10;
initialisation();
while (strlen($loterie)>0 and $tentative<$tentative_max){
$tentative++;
initialisation();
$iter = 0;
$itermax = 82;
while ($loterie<>"" and $iter<$itermax){
  $iter++;
  // placement déterministe d'un chiffre dans une case
  $bingo = 0;
  for ($n=0; $n<=8; $n++){
    for ($m=0; $m<=8; $m++){
      // en premier les régions
      if (strlen($reg[$n][$m])== 1){
        $p = ord($reg[$n][$m])-48;
        $i = floor($n/3)*3+floor($p/3);
        $j = ($n-floor($n/3)*3)*3+($p-floor($p/3)*3);
        affectation($i,$j,$m,"1");
        $bingo = 1;
        break;
      }
      // en second les lignes
      if (strlen($lgn[$n][$m])== 1){
        $p = ord($lgn[$n][$m])-48;
        $i = $n;
        $j = $p;
        affectation($i,$j,$m,"1");
        $bingo = 1;
        break;
      }
      // en troisième les colonnes
      if (strlen($col[$n][$m])== 1){
        $p = ord($col[$n][$m])-48;
        $i = $p;
        $j = $n;
        affectation($i,$j,$m,"1");
        $bingo = 1;
        break;
      }
    }
    if ($bingo== 1) break;
  }
  // placement par tirage au sort, si le placement déterministe n'a pas abouti
  if ($bingo== 0){
    // tirage d'une case $i,$j parmis les cases libres
    $ncase2 = strlen($loterie);
    $ncase = strlen($loterie)/2;
    $index = rand(0,$ncase-1)*2;
    $posi = substr($loterie,$index,2);
    // détermination des coordonnées de la case: $i,$j
    $i = ord(substr($posi,0))-97;
    $j = ord(substr($posi,1))-48;
    // tirage d'un chiffre parmis les chiffres libres
    $liste = "";
    for ($m=0; $m<=8; $m++){
      $libre = 1;
      // régions
      $n = floor($i/3)*3+floor($j/3);
      if ($reg[$n][$m]== "") $libre = 0;
      // lignes
      $n = $i;
      if ($lgn[$n][$m]== "") $libre = 0;
      // colonnes
      $n = $j;
      if ($col[$n][$m]== "") $libre = 0;
      // concaténation
      if ($libre== 1) $liste = $liste.chr(48+$m);
    }
    if (strlen($liste)>0){
      $m = ord(substr($liste,floor(rand(0,strlen($liste)-1))))-48;
      affectation($i,$j,$m,"0");
    }
  }
}
}
/************* fin de la boucle     *******************************************/
if (strlen($loterie)!= 0){
  print("désolé, la recherche d'une grille a échouée après les $tentative_max tentatives.<br>\n");
  print("il reste des cases non résolues <i>(case \"0\" sur fond jaune)</i>.<br>\n");
  print("(<i style=color:green> rechargez ou actualisez la page (f5) pour un autre essais </i>)<br>\n");
}
?>

<?
// affichage de la grille
$nalea = 0;
  for ($ri=0; $ri<=2; $ri++){
    print("<tr>\n");
    for ($rj=0; $rj<=2; $rj++){
      print("<td>\n");
      print("<table>\n");
        for ($ii=0; $ii<=2; $ii++){
        print("<tr>\n");
          for ($jj=0; $jj<=2; $jj++){
            // calcul de ($i,$j)
            $i = $ri*3+$ii;
            $j = $rj*3+$jj;
            if ($grille[$i][$j]== "0"){
              print("<td bgcolor=yellow><b>".$grille[$i][$j]."</b></td>\n");
            }
            else{
              if ($masque[$i][$j]==  1){
                print("<td><b style=color:white>".$grille[$i][$j]."</b></td>\n");
              }
              else{
                $nalea++;
                print("<td><b>".$grille[$i][$j]."</b></td>\n");
              }
            }
          }
        print("</tr>\n");
        }
        print("</table>\n");
      print("</td>\n");
    }
    print("</tr>\n");
  }
?>

