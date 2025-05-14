<?php 

require_once 'core.php';

if ($_POST) {

	$startDate = $_POST['startDate'];
	$endDate = $_POST['endDate'];

	$date = DateTime::createFromFormat('m/d/Y', $startDate);
	$format = DateTime::createFromFormat('m/d/Y', $endDate);

	if (!$date || !$format) {
		echo "Erreur de format de date. Veuillez entrer les dates au format MM/JJ/AAAA.";
		exit;
	}

	$start_date = $date->format("Y-m-d");
	$end_date = $format->format("Y-m-d");

	$sql = "SELECT * FROM orders WHERE order_date >= '$start_date' AND order_date <= '$end_date' AND order_status = 1";
	$query = $connect->query($sql);

	$table = '
	<table border="1" cellspacing="0" cellpadding="0" style="width:100%;">
		<tr>
			<th>Date de Commande</th>
			<th>Nom du Client</th>
			<th>Contact</th>
			<th>Total</th>
		</tr>';

	$totalAmount = 0;
	while ($result = $query->fetch_assoc()) {
		$table .= '<tr>
			<td><center>' . $result['order_date'] . '</center></td>
			<td><center>' . $result['client_name'] . '</center></td>
			<td><center>' . $result['client_contact'] . '</center></td>
			<td><center>' . $result['grand_total'] . '</center></td>
		</tr>';	
		$totalAmount += $result['grand_total'];
	}

	$table .= '
		<tr>
			<td colspan="3"><center>Total</center></td>
			<td><center>' . $totalAmount . '</center></td>
		</tr>
	</table>';

	echo $table;
}
?>
