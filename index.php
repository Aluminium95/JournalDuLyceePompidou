<!DOCTYPE html/>
<html>
<head>
	<title>Journal du lycée</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<link rel='stylesheet' type='text/css' href='general.css'/> <!-- Règles générales -->
	<link rel='stylesheet' type='text/css' href='roles.css'/> <!-- Rôles spécifiques -->
	<link rel='stylesheet' type='text/css' href='head_foot.css'/> <!-- Header Footer -->
	<link rel='stylesheet' type='text/css' href='premierePage.css'/> <!-- Première page spécifique -->
	<link rel='stylesheet' type='text/css' href='asides.css' /> <!-- Règles panneaux latéraux -->
	<link rel="suppleant" type="application/atom+xml" href="synd.php" /> <!-- test syndication -->
</head>
<body>
	<?php include('PremierePage.php'); ?> <!-- inclusion de la première page-->
	<?php include('SecondePage.php'); ?>
	<?php include('TroisiemePage.php'); ?>
	<?php include('DernierePage.php'); ?> <!-- Dernière page n'existe pas -->
</body>
</html>
