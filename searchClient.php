<?php
require('app-lib.php');

header("Content-type: application/json");

$char = isset($_GET['chars']) ? $_GET['chars'] : '';

openDB();

$query =	
	"SELECT
		lpa_client_ID, 
		CONCAT(lpa_client_firstname, ' ', lpa_client_lastname) lpa_client_name, 
		lpa_client_address 
	FROM
		lpa_clients
	WHERE
		lpa_client_status <> 'D' and
		(lpa_client_firstname like '%$char%' or
		lpa_client_lastname like '%$char%')";

$result = $db->query($query);
$rows = array();

while ($data = mysqli_fetch_assoc($result)) {
  $rows[] = $data;
}

echo json_encode($rows);