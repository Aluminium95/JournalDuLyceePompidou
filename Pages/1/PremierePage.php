<section role='PremierePage'> <!-- Toutes les pages sont définies par des sections -->
	<!-- Header -->
	<header>
		Le Georges <!-- Titre du journal -->
		<!--<img src='Images/yeti.png'/>  Logo du journal -->
	</header>
	<!-- Bannière info tirage ( css dans head_foot.css ) -->
		<ul id='infoTirage'>
			<li><?php echo(date("j.n.Y")); ?></li> <!-- Date -->
			<li>N°1 ( distribution gratuite )</li> <!-- Version ?-->
			<li>http://journalpompidou.free.fr</li> <!-- liens -->
		</ul>
	<!-- Article Principal -->
	<article role='Principal'>
		<?php include("Articles/Principal.php"); ?>
		<div role='clear'></div> <!-- Nécessaire après les flottants --> 
	</article>
	
	<menu> <!-- Menu à la carte pour cette édition du journal :D -->
		<?php include("Articles/Menu.php"); ?>
	</menu>
	<article role='Edito'> <!-- Court éditorial en première page --> 
		<?php include("Articles/Edito.php"); ?>
	</article>
	<footer role='footpage'> <!-- Footer du journal, pour mettre quelque chose si besoin -->
		Remerciements pour cette édition : Curto Ludivine pour le dessin du Georges
	</footer>
</section>
