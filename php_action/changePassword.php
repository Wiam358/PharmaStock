<?php
session_start();

require_once 'core.php';

if ($_POST) {
    echo "Bonjour " . $_SESSION['userId'];

    $valid['success'] = array('success' => false, 'messages' => array());

    $currentPassword = $_POST['password'];
    $newPassword = $_POST['npassword'];
    $conformPassword = $_POST['cpassword'];
    $userId = $_POST['user_id'];

    
    $connect = new mysqli($db_host, $db_username, $db_password, $db_name);

    if ($connect->connect_error) {
        die("Erreur de connexion à la base de données : " . $connect->connect_error);
    }

    
    $stmt = $connect->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $_SESSION['userId']);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($currentPassword == $result['password']) {

        if ($newPassword == $conformPassword) {

            
            $newPasswordHash = password_hash($newPassword, PASSWORD_BCRYPT);

            
            $stmt = $connect->prepare("UPDATE users SET password = ? WHERE username = ?");
            $stmt->bind_param("ss", $newPasswordHash, $_SESSION['userId']);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $valid['success'] = true;
                $valid['messages'] = "Modifié avec succès";
            } else {
                $valid['success'] = false;
                $valid['messages'] = "Erreur";
            }

        } else {
            $valid['success'] = false;
            $valid['messages'] = "Mot de passe de confirmation est incorrect";
        }

    } else {
        $valid['success'] = false;
        $valid['messages'] = "Mot de passe actuel est incorrect";
    }

    $connect->close();

    echo json_encode($valid);
}
?>