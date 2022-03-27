<?php
	require 'database.php';
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	if ( $id==null) {
		header("Location: index.php");
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			#$sql = 'SELECT * FROM auto natural join marca ORDER BY idauto';
			#$sql = 'select * FROM Usuario Join Cuenta ON Usuario.idCuenta=Cuenta.idCUenta';
		$sql = "SELECT * FROM Usuario Join Cuenta ON Usuario.idCuenta=Cuenta.idCUenta where idUsuario = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		Database::disconnect();
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
	    <meta 	charset="utf-8">
	    <link   href=	"css/bootstrap.min.css" rel="stylesheet">
	    <script src=	"js/bootstrap.min.js"></script>
	</head>

	<body>
    	<div class="container">

    		<div class="span10 offset1">
    			<div class="row">
		    		<h3>Detalles de un Usuario</h3>
		    	</div>

	    		<div class="form-horizontal" >

					<div class="control-group">
						<label class="control-label">id</label>
					    <div class="controls">
							<label class="checkbox">
								<?php echo $data['idUsuario'];?>
							</label>
					    </div>
					</div>

					<div class="control-group">
					    <label class="control-label">Nombre Titular</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['nombreTitular'];?>
						    </label>
					    </div>
					</div>

					<div class="control-group">
					    <label class="control-label">Saldo</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['saldo'];?>
						    </label>
					    </div>
					</div>
<!--
					<div class="control-group">
						<label class="control-label">aire acondicionado</label>
					    <div class="controls">
					      	<label class="checkbox">
						    	<?php echo ($data['ac'])?"SI":"NO";?>
						    </label>
					    </div>
					</div>
-->
				    <div class="form-actions">
						<a class="btn" href="index.php">Regresar</a>
					</div>

				</div>
			</div>
		</div> <!-- /container -->
  	</body>
</html>
