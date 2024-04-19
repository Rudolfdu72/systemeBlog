<?php
function getPdo()
{
  try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=Blog", 'rudolf_dev', 'Sally72100');
    $pdo->setAttribute(PDO::ATTR_PERSISTENT, true);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
  } catch (\Throwable $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
  }
}


function isAdmin($user){
  if(!empty($user)) {
    $middlware = false;
    
    if($user['role'] == "adminnistrateur"){
      $middlware = true;
    }
    return $middlware;
  }else{
    echo "Vous devez passer un utilisateur valide";
  }
}

function logout()
{
  if (session_status() !== PHP_SESSION_ACTIVE) 
    session_start();

    unset($_SESSION['user']);
    header('location:' . BASE_URL . '/auth/log.php');
}

function isLogin(){
  if(!isset($_SESSION['user'])){
    header("Location:". BASE_URL."/index.php");
    exit();
  }
}

function isRedactor(){
 return isset($_SESSION['user']) && $_SESSION['user']['role'] == 'rédacteur' ?  true :  false; 
}
