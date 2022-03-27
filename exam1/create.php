<?php

	require 'database.php';
//Cuenta origen
		$f_idError = null;
		$montoError = null;
		$CuentaOrigenError = null;
		$BeneficiarioError   = null;

//Revisamos si ya viene de otra pag (guarda para no empezar desde 0)
	if ( !empty($_POST)) {

		// keep track post values
		$f_id = $_POST['f_id'];
		$Monto = $_POST['Monto'];
		$CuentaOrigen = $_POST['CuentaOrigen'];
		$Beneficiario   = $_POST['Beneficiario'];

		// validate input - asumir que es valido
		$valid = true;

		if (empty($Monto)) {
			$montoError = 'Porfavor escriba su monto';
			$valid = false;
		}
		if (empty($CuentaOrigen)) {
			$cuentaOrigenError = 'Porfavor selecciona una Cuenta Origen';
			$valid = false;
		}
		if (empty($Beneficiario)) {
			$BeneficiarioError = 'Porfavor seleccione si el vehículo tiene aire acondicionado';
			$valid = false;
		}

		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			/*
			$sql = "INSERT INTO auto (idauto,nombrec,idmarca, ac) values(null, ?, ?, ?)";
			$q = $pdo->prepare($sql);
			($ac=="S")?$acq=true:$acq=false;
			$q->execute(array($Monto,$marc,$acq));

						$gbd = "START TRANSACTION;
						UPDATE Cuenta SET saldo=saldo-200 WHERE idCuenta=2;
						UPDATE Cuenta SET saldo=saldo+100 WHERE idCuenta=1;
						COMMIT;";
						$q = $pdo->prepare($sql);
						Database::disconnect();
						header("Location: index.php");

						
*/
			try {
				// First of all, let's begin a transaction
				$pdo->beginTransaction();

				// A set of queries; if one fails, an exception should be thrown
				$pdo->query('UPDATE Cuenta SET saldo=saldo-'.$Monto.' WHERE idCuenta='.$CuentaOrigen.';');
				$pdo->query('UPDATE Cuenta SET saldo=saldo+'.$Monto.' WHERE idCuenta='.$Beneficiario.';');
				//bindParam(':Monto', $Monto);
				// If we arrive here, it means that no exception was thrown
				// i.e. no query has failed, and we can commit the transaction
				$pdo->commit();
			} catch (\Throwable $e) {
				// An exception has been thrown
				// We must rollback the transaction
				$pdo->rollback();
				throw $e; // but the error must be handled anyway
			}

		}
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
		   			<h3>Realizar Transferencia</h3>
		   		</div>

				<form class="form-horizontal" action="create.php" method="post">

					<div class="control-group <?php echo !empty($montoError)?'error':'';?>">
						<label class="control-label">Monto</label>
					    <div class="controls">
					      	<input name="Monto" type="text"  placeholder="0000" value="<?php echo !empty($Monto)?$Monto:'';?>">
					      	<?php if (($montoError != null)) ?>
					      		<span class="help-inline"><?php echo $montoError;?></span>
					    </div>
					</div>

					<div class="control-group <?php echo !empty($cuentaOrigenError)?'error':'';?>">
				    	<label class="control-label">Cuenta Origen</label>
				    	<div class="controls">
	                       	<select name ="CuentaOrigen">
		                        <option value="">Selecciona una Cuenta</option>
		                        <?php
								
							   		$pdo = Database::connect();
									   
							   		$query = 'select * FROM Usuario Join Cuenta ON Usuario.idCuenta=Cuenta.idCUenta';
			 				   		foreach ($pdo->query($query) as $row) {
		                        		if ($row['idCuenta']==$CuentaOrigen)
		                        			echo "<option selected value='" . $row['idCuenta'] . "'>" . $row['nombreTitular'] . "</option>";
		                        		else
		                        			echo "<option value='" . $row['idCuenta'] . "'>" . $row['nombreTitular'] . "</option>";
			   						}
			   						Database::disconnect();
			  					
									   ?>
                            </select>
					      	<?php if (($cuentaOrigenError) != null) ?>
					      		<span class="help-inline"><?php echo $cuentaOrigenError;?></span>
						</div>
					</div>
								
					<div class="control-group <?php echo !empty($BeneficiarioError)?'error':'';?>">
				    	<label class="control-label">Beneficiario</label>
				    	<div class="controls">
	                       	<select name ="Beneficiario">
		                        <option value="">Selecciona una Cuenta</option>
								
		                        <?php
								
							   		$pdo = Database::connect();
							   		$query = 'select * FROM Usuario Join Cuenta ON Usuario.idCuenta=Cuenta.idCUenta';
			 				   		foreach ($pdo->query($query) as $row) {
		                        		if ($row['idCuenta']==$Beneficiario)
		                        			echo "<option selected value='" . $row['idCuenta'] . "'>" . $row['nombreTitular'] . "</option>";
		                        		else
		                        			echo "<option value='" . $row['idCuenta'] . "'>" . $row['nombreTitular'] . "</option>";
			   						}
			   						Database::disconnect();
									   
			  					?>
								  
                            </select>
					      	<?php if (($BeneficiarioError) != null) ?>
					      		<span class="help-inline"><?php echo $BeneficiarioError;?></span>
						</div>
					</div>

		
					<div class="form-actions">
						<button type="submit" class="btn btn-success">Transferir</button>
						<a class="btn" href="index.php">Regresar</a>
					</div>

				</form>
			</div>
	    </div> <!-- /container -->
	</body>
</html>
