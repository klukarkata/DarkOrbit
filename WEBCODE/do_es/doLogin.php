<?php require_once('Connections/DO.php'); ?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  @session_start();
}

$loginFormAction = $_SERVER['PHP_POST'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['loginForm_default_username'])) {
  $loginUsername=$_POST['loginForm_default_username'];
  $password=md5($_POST['loginForm_default_password']);
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "internalCompanyChoose.php";
  $MM_redirectLoginFailed = "index.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_DO, $DO);
  
  $LoginRS__query=sprintf("SELECT usuario, password FROM cuentas WHERE usuario='%s' AND password='%s'",
    get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password)); 
   
  $LoginRS = mysql_query($LoginRS__query, $DO) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
	echo "<p>Espere por favor...</p>";
  }
  else {
	header('Location: index.php?action=error_login');
	echo "<p>Espere por favor...</p>";
  }
}
?>