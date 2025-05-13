<?php 
require_once 'php_action/db_connect.php'; 
require_once 'includes/header.php'; 

if($_GET['o'] == 'add') { 
	echo "<div class='div-request div-hide'>add</div>";
} else if($_GET['o'] == 'manord') { 
	echo "<div class='div-request div-hide'>manord</div>";
} else if($_GET['o'] == 'editOrd') { 
	echo "<div class='div-request div-hide'>editOrd</div>";
}
?>

<ol class="breadcrumb">
  <li><a href="dashboard.php">Accueil</a></li>
  <li>Commande</li>
  <li class="active">
  	<?php if($_GET['o'] == 'add') { ?>
		Ajouter une Commande
		<?php } else if($_GET['o'] == 'manord') { ?>
		Gérer la Commande
		<?php }  ?>
  </li>
</ol>

<h4>
	<i class='glyphicon glyphicon-circle-arrow-right'></i>
	<?php if($_GET['o'] == 'add') {
		echo "Ajouter une commande";
	} else if($_GET['o'] == 'manord') { 
		echo "Gérer une commande";
	} else if($_GET['o'] == 'editOrd') { 
		echo "Modifier une commande";
	}
	?>	
</h4>



<div class="panel panel-default">
	<div class="panel-heading">

		<?php if($_GET['o'] == 'add') { ?>
  		<i class="glyphicon glyphicon-plus-sign"></i> Ajouter une Commande
		<?php } else if($_GET['o'] == 'manord') { ?>
			<i class="glyphicon glyphicon-edit"></i> Gérer la Commande
		<?php } else if($_GET['o'] == 'editOrd') { ?>
			<i class="glyphicon glyphicon-edit"></i> Modifier la commande
		<?php } ?>

	</div> 	
	<div class="panel-body">
			
		<?php if($_GET['o'] == 'add') { 
			
			?>			

			<div class="success-messages"></div> 

  		<form class="form-horizontal" method="POST" action="php_action/createOrder.php" id="createOrderForm">

	
			  <div class="form-group">
			    <label for="orderDate" class="col-sm-2 control-label">Date de Commande</label>
			    <div class="col-sm-10">
			      <input type="date" class="form-control" id="orderDate" name="orderDate" autocomplete="off" />
			    </div>
			  </div> 
			  <div class="form-group">
			    <label for="clientName" class="col-sm-2 control-label">Nom du Client</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" id="clientName" name="clientName" placeholder="Nom du client" autocomplete="off" />
			    </div>
			  </div> 
			  <div class="form-group">
			    <label for="clientContact" class="col-sm-2 control-label">Contact</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" id="clientContact" name="clientContact" placeholder="Numéro de contact" autocomplete="off" />
			    </div>
			  </div> 		  

			  <table class="table" id="productTable">
			  	<thead>
			  		<tr>			  			
			  			<th style="width:40%;">Produit</th>
			  			<th style="width:20%;">Taux</th>
			  			<th style="width:15%;">Quantité</th>			  			
			  			<th style="width:15%;">Total des Dépenses</th>			  			
			  			<th style="width:10%;"></th>
			  		</tr>
			  	</thead>
			  	<tbody>
			  		<?php
			  		$arrayNumber = 0;
			  		for($x = 1; $x < 4; $x++) { ?>
			  			<tr id="row<?php echo $x; ?>" class="<?php echo $arrayNumber; ?>">			  				
			  				<td style="margin-left:20px;">
			  					<div class="form-group">

			  					<select class="form-control" name="productName[]" id="productName<?php echo $x; ?>" onchange="getProductData(<?php echo $x; ?>)" >
			  						<option value=""> </option>
			  						<?php
			  							$productSql = "SELECT * FROM product WHERE active = 1 AND status = 1 AND quantity != 0";
			  							$productData = $connect->query($productSql);

			  							while($row = $productData->fetch_array()) {									 		
			  								echo "<option value='".$row['product_id']."' id='changeProduct".$row['product_id']."'>".$row['product_name']."</option>";
										 	} 

			  						?>
		  						</select>
			  					</div>
			  				</td>
			  				<td style="padding-left:20px;">			  					
			  					<input type="text" name="rate[]" id="rate<?php echo $x; ?>" autocomplete="off" disabled="true" class="form-control" />			  					
			  					<input type="hidden" name="rateValue[]" id="rateValue<?php echo $x; ?>" autocomplete="off" class="form-control" />			  					
			  				</td>
			  				<td style="padding-left:20px;">
			  					<div class="form-group">
			  					<input type="number" name="quantity[]" id="quantity<?php echo $x; ?>" onkeyup="getTotal(<?php echo $x ?>)" autocomplete="off" class="form-control" min="1" />
			  					</div>
			  				</td>
			  				<td style="padding-left:20px;">			  					
			  					<input type="text" name="total[]" id="total<?php echo $x; ?>" autocomplete="off" class="form-control" disabled="true" />			  					
			  					<input type="hidden" name="totalValue[]" id="totalValue<?php echo $x; ?>" autocomplete="off" class="form-control" />			  					
			  				</td>
			  				<td>

			  					<button class="btn btn-default removeProductRowBtn" type="button" id="removeProductRowBtn" onclick="removeProductRow(<?php echo $x; ?>)"><i class="glyphicon glyphicon-trash"></i></button>
			  				</td>
			  			</tr>
		  			<?php
		  			$arrayNumber++;
			  		} 
			  		?>
			  	</tbody>			  	
			  </table>

			  <div class="col-md-6">
			  	<div class="form-group">
				    <label for="subTotal" class="col-sm-3 control-label">Sous-Montant</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="subTotal" name="subTotal" disabled="true" />
				      <input type="hidden" class="form-control" id="subTotalValue" name="subTotalValue" />
				    </div>
				  </div> 		  
				  <div class="form-group">
				    <label for="vat" class="col-sm-3 control-label">TVA 13%</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="vat" name="vat" disabled="true" />
				      <input type="hidden" class="form-control" id="vatValue" name="vatValue" />
				    </div>
				  </div> 		  
				  <div class="form-group">
				    <label for="totalAmount" class="col-sm-3 control-label">Montant Total</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="totalAmount" name="totalAmount" disabled="true"/>
				      <input type="hidden" class="form-control" id="totalAmountValue" name="totalAmountValue" />
				    </div>
				  </div> 		  
				  <div class="form-group">
				    <label for="discount" class="col-sm-3 control-label">Remise</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="discount" name="discount" onkeyup="discountFunc()" autocomplete="off" />
				    </div>
				  </div> 
				  <div class="form-group">
				    <label for="grandTotal" class="col-sm-3 control-label">Total Général</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="grandTotal" name="grandTotal" disabled="true" />
				      <input type="hidden" class="form-control" id="grandTotalValue" name="grandTotalValue" />
				    </div>
				  </div> 		  		  
			  </div> 

			  <div class="col-md-6">
			  	<div class="form-group">
				    <label for="paid" class="col-sm-3 control-label">Montant Payé</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="paid" name="paid" autocomplete="off" onkeyup="paidAmount()" />
				    </div>
				  </div> 		  
				  <div class="form-group">
				    <label for="due" class="col-sm-3 control-label">Montant Dû</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="due" name="due" disabled="true" />
				      <input type="hidden" class="form-control" id="dueValue" name="dueValue" />
				    </div>
				  </div> 	
				  <div class="form-group">
				    <label for="clientContact" class="col-sm-3 control-label">Type de Paiement</label>
				    <div class="col-sm-9">
				      <select class="form-control" name="paymentType" id="paymentType">
				      	<option value=""></option>
				      	<option value="1">Chèque</option>
				      	<option value="2">Espèces</option>
				      	<option value="3">Carte de Crédit</option>
				      </select>
				    </div>
				  </div> 						  
				  <div class="form-group">
				    <label for="clientContact" class="col-sm-3 control-label">Statut du Paiement</label>
				    <div class="col-sm-9">
				      <select class="form-control" name="paymentStatus" id="paymentStatus">
				      	<option value=""></option>
				      	<option value="1">Paiement Intégral</option>
				      	<option value="2">Paiement Anticipé</option>
				      	<option value="3">Pas De Paiement</option>
				      </select>
				    </div>
				  </div> 							  
			  </div> 


			  <div class="form-group submitButtonFooter">
			    <div class="col-sm-offset-2 col-sm-10">
			    <button type="button" class="btn btn-default" onclick="addRow()" id="addRowBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-plus-sign"></i> Ajouter une Ligne </button>

			      <button type="submit" id="createOrderBtn" data-loading-text="Loading..." class="btn btn-success"><i class="glyphicon glyphicon-ok-sign"></i> Enregistrer </button>

			      <button type="reset" class="btn btn-default" onclick="resetOrderForm()"><i class="glyphicon glyphicon-erase"></i> Réinitialiser</button>
			    </div>
			  </div>
			</form>
		<?php } else if($_GET['o'] == 'manord') { 
			
			?>

			<div id="success-messages"></div>
			
			<table class="table" id="manageOrderTable">
				<thead>
					<tr>
						<th>#</th>
						<th>Date de Commande</th>
						<th>Nom du Client</th>
						<th>Coordonnées</th>
						<th>Quantité</th>
						<th>Statut du Paiement</th>
						<th>Options</th>
					</tr>
				</thead>
			</table>

		<?php 
		
		} else if($_GET['o'] == 'editOrd') {
			
			?>
			
			<div class="success-messages"></div> 

  		<form class="form-horizontal" method="POST" action="php_action/editOrder.php" id="editOrderForm">

  			<?php $orderId = $_GET['i'];

  			$sql = "SELECT orders.order_id, orders.order_date, orders.client_name, orders.client_contact, orders.sub_total, orders.vat, orders.total_amount, orders.discount, orders.grand_total, orders.paid, orders.due, orders.payment_type, orders.payment_status FROM orders 	
					WHERE orders.order_id = '$orderId'";

				$result = $connect->query($sql);
				$data = $result->fetch_row();				
  			?>

			  <div class="form-group">
			    <label for="orderDate" class="col-sm-2 control-label">Date de Commande</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" id="orderDate" name="orderDate" autocomplete="off" value="<?php echo $data[1] ?>" />
			    </div>
			  </div> 
			  <div class="form-group">
			    <label for="clientName" class="col-sm-2 control-label">Nom du Client</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" id="clientName" name="clientName" placeholder="Nom du client" autocomplete="off" value="<?php echo $data[2] ?>" />
			    </div>
			  </div> <
			  <div class="form-group">
			    <label for="clientContact" class="col-sm-2 control-label">Contact </label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" id="clientContact" name="clientContact" placeholder="Numéro de contact" autocomplete="off" value="<?php echo $data[3] ?>" />
			    </div>
			  </div> 		  

			  <table class="table" id="productTable">
			  	<thead>
				  <tr>			  			
			  			<th style="width:40%;">Produit</th>
			  			<th style="width:20%;">Taux</th>
			  			<th style="width:15%;">Quantité</th>			  			
			  			<th style="width:15%;">Total des Dépenses</th>			  			
			  			<th style="width:10%;"></th>
			  		</tr>
			  	</thead>
			  	<tbody>
			  		<?php

			  		$orderItemSql = "SELECT order_id,order_id,product_id, quantity, rate, total FROM order_item WHERE order_item.order_id = '$orderId'";
						$orderItemResult = $connect->query($orderItemSql);
						
			  		$arrayNumber = 0;
			  		
			  		$x = 1;
			  		while($orderItemData = $orderItemResult->fetch_array()) { 
			  			 print_r($orderItemData); ?>
			  			
			  			<tr id="row<?php echo $x; ?>" class="<?php echo $arrayNumber; ?>">			  				
			  				<td style="margin-left:20px;">
			  					<div class="form-group">

			  					<select class="form-control" name="productName[]" id="productName<?php echo $x; ?>" onchange="getProductData(<?php echo $x; ?>)" >
			  						<option value=""></option>
			  						<?php
			  							$productSql = "SELECT * FROM product WHERE active = 1 AND status = 1 AND quantity != 0";
			  							$productData = $connect->query($productSql);

			  							while($row = $productData->fetch_array()) {									 		
			  								$selected = "";
			  								if($row['product_id'] == $orderItemData['product_id']) {
			  									$selected = "selected";
			  								} else {
			  									$selected = "";
			  								}

			  								echo "<option value='".$row['product_id']."' id='changeProduct".$row['product_id']."' ".$selected." >".$row['product_name']."</option>";
										 	} 

			  						?>
		  						</select>
			  					</div>
			  				</td>
			  				<td style="padding-left:20px;">			  					
			  					<input type="text" name="rate[]" id="rate<?php echo $x; ?>" autocomplete="off" disabled="true" class="form-control" value="<?php echo $orderItemData['rate']; ?>" />			  					
			  					<input type="hidden" name="rateValue[]" id="rateValue<?php echo $x; ?>" autocomplete="off" class="form-control" value="<?php echo $orderItemData['rate']; ?>" />			  					
			  				</td>
			  				<td style="padding-left:20px;">
			  					<div class="form-group">
			  					<input type="number" name="quantity[]" id="quantity<?php echo $x; ?>" onkeyup="getTotal(<?php echo $x ?>)" autocomplete="off" class="form-control" min="1" value="<?php echo $orderItemData['quantity']; ?>" />
			  					</div>
			  				</td>
			  				<td style="padding-left:20px;">			  					
			  					<input type="text" name="total[]" id="total<?php echo $x; ?>" autocomplete="off" class="form-control" disabled="true" value="<?php echo $orderItemData['total']; ?>"/>			  					
			  					<input type="hidden" name="totalValue[]" id="totalValue<?php echo $x; ?>" autocomplete="off" class="form-control" value="<?php echo $orderItemData['total']; ?>"/>			  					
			  				</td>
			  				<td>

			  					<button class="btn btn-default removeProductRowBtn" type="button" id="removeProductRowBtn" onclick="removeProductRow(<?php echo $x; ?>)"><i class="glyphicon glyphicon-trash"></i></button>
			  				</td>
			  			</tr>
		  			<?php
		  			$arrayNumber++;
		  			$x++;
			  		} 
			  		?>
			  	</tbody>			  	
			  </table>

			  <div class="col-md-6">
			  	<div class="form-group">
				    <label for="subTotal" class="col-sm-3 control-label">Sous-Montant</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="subTotal" name="subTotal" disabled="true" value="<?php echo $data[4] ?>" />
				      <input type="hidden" class="form-control" id="subTotalValue" name="subTotalValue" value="<?php echo $data[4] ?>" />
				    </div>
				  </div> 		  
				  <div class="form-group">
				    <label for="vat" class="col-sm-3 control-label">TVA 13%</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="vat" name="vat" disabled="true" value="<?php echo $data[5] ?>"  />
				      <input type="hidden" class="form-control" id="vatValue" name="vatValue" value="<?php echo $data[5] ?>"  />
				    </div>
				  </div> 		  
				  <div class="form-group">
				    <label for="totalAmount" class="col-sm-3 control-label">Montant Total</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="totalAmount" name="totalAmount" disabled="true" value="<?php echo $data[6] ?>" />
				      <input type="hidden" class="form-control" id="totalAmountValue" name="totalAmountValue" value="<?php echo $data[6] ?>"  />
				    </div>
				  </div> 		  
				  <div class="form-group">
				    <label for="discount" class="col-sm-3 control-label">Remise</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="discount" name="discount" onkeyup="discountFunc()" autocomplete="off" value="<?php echo $data[7] ?>" />
				    </div>
				  </div> 
				  <div class="form-group">
				    <label for="grandTotal" class="col-sm-3 control-label">Total Général</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="grandTotal" name="grandTotal" disabled="true" value="<?php echo $data[8] ?>"  />
				      <input type="hidden" class="form-control" id="grandTotalValue" name="grandTotalValue" value="<?php echo $data[8] ?>"  />
				    </div>
				  </div> 		  		  
			  </div> 

			  <div class="col-md-6">
			  	<div class="form-group">
				    <label for="paid" class="col-sm-3 control-label">Montant Payé</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="paid" name="paid" autocomplete="off" onkeyup="paidAmount()" value="<?php echo $data[9] ?>"  />
				    </div>
				  </div> 		  
				  <div class="form-group">
				    <label for="due" class="col-sm-3 control-label">Montant Dû</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="due" name="due" disabled="true" value="<?php echo $data[10] ?>"  />
				      <input type="hidden" class="form-control" id="dueValue" name="dueValue" value="<?php echo $data[10] ?>"  />
				    </div>
				  </div> 	
				  <div class="form-group">
				    <label for="clientContact" class="col-sm-3 control-label">Type de Paiement</label>
				    <div class="col-sm-9">
				      <select class="form-control" name="paymentType" id="paymentType" >
				      	<option value=""></option>
				      	<option value="1" <?php if($data[11] == 1) {
				      		echo "sélectionné";
				      	} ?> >Chèque</option>
				      	<option value="2" <?php if($data[11] == 2) {
				      		echo "sélectionné";
				      	} ?>  >Espèces</option>
				      	<option value="3" <?php if($data[11] == 3) {
				      		echo "sélectionné";
				      	} ?> >Carte de Crédit</option>
				      </select>
				    </div>
				  </div> 							  
				  <div class="form-group">
				    <label for="clientContact" class="col-sm-3 control-label">Statut du Paiement</label>
				    <div class="col-sm-9">
				      <select class="form-control" name="paymentStatus" id="paymentStatus">
				      	<option value=""></option>
				      	<option value="1" <?php if($data[12] == 1) {
				      		echo "sélectionné";
				      	} ?>  >Paiement Intégral</option>
				      	<option value="2" <?php if($data[12] == 2) {
				      		echo "sélectionné";
				      	} ?> >Paiement Anticipé</option>
				      	<option value="3" <?php if($data[10] == 3) {
				      		echo "sélectionné";
				      	} ?> >Pas De Paiement</option>
				      </select>
				    </div>
				  </div> 						  
			  </div> 


			  <div class="form-group editButtonFooter">
			    <div class="col-sm-offset-2 col-sm-10">
			    <button type="button" class="btn btn-default" onclick="addRow()" id="addRowBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-plus-sign"></i> Ajouter une Ligne </button>

			    <input type="hidden" name="orderId" id="orderId" value="<?php echo $_GET['i']; ?>" />

			    <button type="submit" id="editOrderBtn" data-loading-text="Loading..." class="btn btn-success"><i class="glyphicon glyphicon-ok-sign"></i> Enregistrer </button>
			      
			    </div>
			  </div>
			</form>

			<?php
		}   ?>

	</div>
	</div> 	



<div class="modal fade" tabindex="-1" role="dialog" id="paymentOrderModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-edit"></i> Modifier le Paiement</h4>
      </div>      

      <div class="modal-body form-horizontal" style="max-height:500px; overflow:auto;" >

      	<div class="paymentOrderMessages"></div>

      	     				 				 
			  <div class="form-group">
			    <label for="due" class="col-sm-3 control-label">Montant Dû</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="due" name="due" disabled="true" />					
			    </div>
			  </div> 	
			  <div class="form-group">
			    <label for="payAmount" class="col-sm-3 control-label">Montant du Paiement</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="payAmount" name="payAmount"/>					      
			    </div>
			  </div> 
			  <div class="form-group">
			    <label for="clientContact" class="col-sm-3 control-label">Type de Paiement</label>
			    <div class="col-sm-9">
			      <select class="form-control" name="paymentType" id="paymentType" >
			      	<option value=""></option>
			      	<option value="1">Chèque</option>
			      	<option value="2">Espèces</option>
			      	<option value="3">Carte de Crédit</option>
			      </select>
			    </div>
			  </div> 						  
			  <div class="form-group">
			    <label for="clientContact" class="col-sm-3 control-label">Statut du Paiement</label>
			    <div class="col-sm-9">
			      <select class="form-control" name="paymentStatus" id="paymentStatus">
			      	<option value=""></option>
			      	<option value="1">Paiement Intégral</option>
			      	<option value="2">Paiement Anticipé</option>
			      	<option value="3">Pas De Paiement</option>
			      </select>
			    </div>
			  </div> 						  				  
      	        
      </div> 
      <div class="modal-footer">
      	<button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Fermer</button>
        <button type="button" class="btn btn-primary" id="updatePaymentOrderBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Enregistrer</button>	
      </div>           
    </div>
  </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" id="removeOrderModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Supprimer la Commande</h4>
      </div>
      <div class="modal-body">

      	<div class="removeOrderMessages"></div>

        <p>Voulez-vous vraiment supprimer ?</p>
      </div>
      <div class="modal-footer removeProductFooter">
        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Fermer</button>
        <button type="button" class="btn btn-primary" id="removeOrderBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Supprimer</button>
      </div>
    </div><
  </div><
</div>


<script src="custom/js/order.js"></script>

<?php require_once 'includes/footer.php'; ?>


	