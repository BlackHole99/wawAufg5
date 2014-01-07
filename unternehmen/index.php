<?php
require_once 'cms.inc.php';
$cms = new CMS ();
$cms->readMenuItems();
$cms->readMenus();
?>

<!DOCTYPE html>
<html>
<head>
<title>1221953</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="../css/bootstrap.css" rel="stylesheet">
<link href="../css/myStyles.css" rel="stylesheet">

</head>
<body>

	<?php require_once 'header.inc.php';?>

	<div class="container">
		<div class="jumbotron">
			
			<?php
			$cms->writeContent ();
			?>
			
			</div>
	</div>

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://code.jquery.com/jquery.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="../js/bootstrap.js"></script>
	<script src="../js/dropdown_hover.js"></script>

</body>
</html>
<?php unset ($cms) ?>