<?php 	

require_once 'core.php';


$valid['success'] = array('success' => false, 'messages' => array());

$brandId = $_POST['brandId'];

if($brandId) { 

 $sql = "UPDATE brands SET brand_status = 2 WHERE brand_id = {$brandId}";

 if($connect->query($sql) === TRUE) {
 	$valid['success'] = true;
	$valid['messages'] = "Supprimé Avec Succès";		
 } else {
 	$valid['success'] = false;
 	$valid['messages'] = "Erreur lors de la suppression de la marque";
 }
 
 $connect->close();

 echo json_encode($valid);
 
} // /if $_POST