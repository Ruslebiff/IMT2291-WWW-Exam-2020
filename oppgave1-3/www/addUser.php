<?php
require_once './vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('./templates');
$twig = new Twig_Environment($loader, array());

if (!isset($_POST['uname'])) {  // Show form to create user
  echo $twig->render('addUser.html', array());
} else {                        // Add user
  require_once 'classes/DB.php';
  $db = DB::getDBConnection();
  $err['code'] = 1;
  $err['msg'] = 'Manglende informasjon i minst ett av feltene';
  
  // Check if all required fields are filled
  if (isset($_POST['uname'])&&isset($_POST['pwd'])&&isset($_POST['firstName'])&&isset($_POST['lastName'])) {
    $err['code'] = 0;
    if (!preg_match("/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/",$_POST['uname'])) {  // Check pwd
      $err['code'] = 1;
      $err['msg'] = 'Ugyldig e-post addresse';
    } else if (strlen($_POST['pwd'])<8) {
      $err['code'] = 1;
      $err['msg'] = 'Passord må være minimum 8 tegn';
    } else if (strlen($_POST['firstName'])<1) {
      $err['code'] = 1;
      $err['msg'] = 'Fornavnet kan ikke være tomt';
    } else if (strlen($_POST['lastName'])<1) {
      $err['code'] = 1;
      $err['msg'] = 'Etternavnet kan ikke være tomt';
    }
  }
  if ($err['code']==1) {  // Invalid value in one or more fields
    echo $twig->render('addUser.html', $err);
  } else {                // All fields are OK
    $stmt = $db->prepare('INSERT INTO user (uname, pwd, firstName, lastName) VALUES(?, ?, ?, ?)');
    $stmt->execute(array($_POST['uname'], password_hash($_POST['pwd'], PASSWORD_DEFAULT), $_POST['firstName'], $_POST['lastName']));
    if ($stmt->rowCount()==1) { // User is successfully added to DB
      echo $twig->render('userAdded.html', $_POST);
    } else {                    // Adding user to DB failed
      $err['code'] = 1;
      $err['msg'] = 'En feil oppstod ved opprettelse av brukerkonto.';
      echo $twig->render('addUser.html', $err);
    }
  }
}
