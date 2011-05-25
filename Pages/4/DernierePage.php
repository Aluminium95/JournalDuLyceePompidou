<?php include("Articles/sudoku.php"); ?>
<section>
	<article>
		<h1>Sudoku</h1>
		<div style='padding-left: 100px;'>
			<table style='float: left'> <!-- Conteneur du sudoku -->
				<?php aff(); ?>
			</table>
			<div style='height: 280px;float: left;border:1px solid black'></div>
			<table> <!-- Conteneur du sudoku -->
				<?php aff(); ?>
			</table>
		</div>
	</article>
	<?php include("Articles/Normaux.php"); ?>
</section>
