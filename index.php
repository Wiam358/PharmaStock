<?php 
require_once 'php_action/db_connect.php';

session_start();

if(isset($_SESSION['userId'])) {
	header('location:dashboard.php');	
}

$errors = array();

if($_POST) {		

	$username = $_POST['username'];
	$password = $_POST['password'];

	if(empty($username) || empty($password)) {
		if($username == "") {
			$errors[] = "Username is required";
		} 

		if($password == "") {
			$errors[] = "Password is required";
		}
	} else {
$sql="select * from users where username='$username' and password='$password'; ";
$result=mysqli_query($connect,$sql);
$count=mysqli_num_rows($result);
$row=mysqli_fetch_array($result);

if ($row>1) { 
	   $_SESSION['userId']=$row['username'];
		header("location:dashboard.php");
}
 else {
	?><script type="text/javascript">
		alert("Nom d'utilisateur ou mot de passe est incorrect");
		window.location= "index.php";
	</script>
<?php
}

	} 
	
} 
?>

<!DOCTYPE html>
<html>
<head>
	<title>Système De Gestion Des Stocks</title>

	<link rel="icon" type="image/jpg" href="logo.jpg" />
	<link rel="stylesheet" href="assests/bootstrap/css/bootstrap.min.css">
	
	<link rel="stylesheet" href="assests/bootstrap/css/bootstrap-theme.min.css">
	
	<link rel="stylesheet" href="assests/font-awesome/css/font-awesome.min.css">

 
  <link rel="stylesheet" href="custom/css/custom.css">	

  
	<script src="assests/jquery/jquery.min.js"></script>
    
  <link rel="stylesheet" href="assests/jquery-ui/jquery-ui.min.css">
  <script src="assests/jquery-ui/jquery-ui.min.js"></script>

  
	<script src="assests/bootstrap/js/bootstrap.min.js"></script>
	<style>
  body {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    height: 100vh;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  
  .container {
    width: 100%;
    padding: 20px;
	
  }
  
  .panel {
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    border: none;
    overflow: hidden;
    width: 100%;
	
  }
  
  .panel-heading {
    background: linear-gradient(to right, #3498db, #2c3e50);
    color: white !important;
    text-align: center;
    padding: 25px; 
    border-bottom: none;
  }
  
  .panel-title {
    font-size: 24px; 
    font-weight: 600;
    letter-spacing: 1px;
  }
  
  .panel-body {
    padding: 40px; 
    background-color: #fff;
  }
  
  .form-group {
    margin-bottom: 25px; 
  }
  
  .form-control {
    height: 50px; 
    border-radius: 6px;
    border: 1px solid #ddd;
    padding-left: 20px;
    font-size: 16px; 
    transition: all 0.3s;
  }
  
  .form-control:focus {
    border-color: #3498db;
    box-shadow: 0 0 10px rgba(52, 152, 219, 0.4);
  }
  
  .btn {
    background: linear-gradient(to right, #3498db, #2c3e50);
    color: white;
    border: none;
    padding: 12px 30px; /* Larger button */
    border-radius: 6px;
    font-size: 16px; 
    font-weight: 600;
    letter-spacing: 1px;
    transition: all 0.3s;
    width: 100%; /* Full width button */
    margin-top: 10px;
  }
  
  .btn:hover {
    background: linear-gradient(to right, #2980b9, #1a252f);
    transform: translateY(-2px);
    box-shadow: 0 7px 20px rgba(0, 0, 0, 0.15);
	color: #c3cfe2;
  }
  
  .alert {
    border-radius: 6px;
    padding: 15px;
    font-size: 15px;
  }
  
  label {
    font-weight: 500;
    color: #555;
    font-size: 16px; /* Larger labels */
  }
  
  /* Responsive adjustments */
  @media (max-width: 768px) {
    .container {
      padding: 15px;
      max-width: 100%;
    }
    
    .panel-body {
      padding: 30px;
    }
  }
</style>
</head>
<body>
	<div class="container">
		<div class="row vertical">
			<div class="col-md-5 col-md-offset-4">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">Veuillez vous connecter</h3>
					</div>
					<div class="panel-body">

						<div class="messages">
							<?php if($errors) {
								foreach ($errors as $key => $value) {
									echo '<div class="alert alert-warning" role="alert">
									<i class="glyphicon glyphicon-exclamation-sign"></i>
									'.$value.'</div>';										
									}
								} ?>
						</div>

						<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" id="loginForm">
							<fieldset>
							  <div class="form-group">
									<label for="username" class="col-sm-2 control-label">Nom d'utilisateur</label>
									<div class="col-sm-10">
									  <input type="text" class="form-control" id="username" name="username" placeholder="Nom Utilisateur" autocomplete="off" />
									</div>
								</div>
								<div class="form-group">
									<label for="password" class="col-sm-2 control-label">Mot de Passe</label>
									<div class="col-sm-10">
									  <input type="password" class="form-control" id="password" name="password" placeholder="Mot De Passe" autocomplete="off" />
									</div>
								</div>								
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
									  <button type="submit" class="btn btn-default"> <i class="glyphicon glyphicon-log-in"></i> Se connecter</button>
									</div>
								</div>
							</fieldset>
						</form>
					</div>
					
				</div>
				
			</div>
			
		</div>
		
	</div>
	
</body>
</html>







	