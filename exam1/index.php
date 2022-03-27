<!DOCTYPE html>
<html lang="en">
	<head>
	    <meta 	charset="utf-8">
	    <link   href="css/bootstrap.min.css" rel="stylesheet">
	    <script src="js/bootstrap.min.js"></script>
	</head>

	<body>
	    <div class="container">

    		<div class="row">
    			<h3>Examen 1 - Emmanuel, Misael, Mario</h3>
    		</div>

			<div class="row">
				<p>
					<a href="create.php" class="btn btn-success">Transferir</a>
				</p>

				<table class="table table-striped table-bordered">
		            <thead>
		                <tr>
		                	<th>Nombre Titular	</th>
		                	<th>Cuenta	</th>
                        	<th>Saldo			</th>
		                </tr>
		            </thead>
		            <tbody>
		              	<?php
					   	include 'database.php';
					   	$pdo = Database::connect();
					   	#$sql = 'SELECT * FROM auto natural join marca ORDER BY idauto';
						$sql = 'select * FROM Usuario Join Cuenta ON Usuario.idCuenta=Cuenta.idCUenta';

	 				   	foreach ($pdo->query($sql) as $row) {
							echo '<tr>';
    					   	echo '<td>'. $row['nombreTitular'] . '</td>';
    					  	echo '<td>'. $row['idCuenta'] . '</td>';
							echo '<td>'. $row['saldo'] . '</td>';
						  	echo '</tr>';
					    }
					   	Database::disconnect();
					  	?>
				    </tbody>
	            </table>

	    	</div>

	    </div> <!-- /container -->
	</body>
</html>
