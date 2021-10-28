<?PHP 
  require('app-lib.php');
  isset($_POST['a'])? $action = $_POST['a'] : $action = "";
  if($action == "doLogin") {
    $chkLogin = false;
    isset($_POST['fldUsername'])?
      $uName = $_POST['fldUsername'] : $uName = "";
    isset($_POST['fldPassword'])?
      $uPassword = $_POST['fldPassword'] : $uPassword = "";

 openDB();
	$query =
		"
		SELECT
			lpa_user_ID,
			lpa_user_username,
			lpa_user_password,
			lpa_user_group
		FROM
			lpa_users
		WHERE
			lpa_user_username = '$uName'
		AND
			lpa_user_password = '$uPassword'
		AND	
			lpa_user_status <> 'D'
		LIMIT 1
		";

	$result = $db->query($query);
	$row = $result->fetch_assoc();
	
	$password_entered = $uPassword;
    $password_hash =$row['lpa_user_password'];
	
	if($row['lpa_user_username'] == $uName) {
		 if(password_verify($password_entered, $password_hash)) {
        $_SESSION['authUser'] = $row['lpa_user_ID'];
		$_SESSION['isAdmin'] = (($row['lpa_user_group']=="administrator")?true:false);
        header("Location: index.php");
          lpa_log($row['lpa_user_password'], $uName);
        exit;
	} 
	if($row['lpa_user_password'] == $uPassword) {
		$_SESSION['authUser'] = $row['lpa_user_ID'];
		$_SESSION['isAdmin'] = (($row['lpa_user_group']=="administrator")?true:false);
		if(!empty($_SESSION['authUser'])){
			lpa_log("User '{$uName}' successfully logged in.");
		header("Location: index.php");
		exit;
		}
	}
}
	
    if($chkLogin == false) {
      $msg = "Login failed! Please try again.";
	  lpa_log("User '{$uName}' failed to log in.");
    }
	else
	{
		header ("Location: home.php");
	
 }
 }
  
 build_header();
?>
<div id="container">
  <div id="contentLogin">
    <form name="frmLogin" id="frmLogin" method="post" action="login.php">
      <div class="titleBar">User Login</div>
      <div id="loginFrame">
        <div class="msgTitle">Please supply your login details:</div>
        <div>Username:</div>
        <input type="text" name="fldUsername" id="fldUsername">
        <div>Password:</div>
        <input type="password" name="fldPassword" id="fldPassword">
        <div class="buttonBar">
          <button type="button" onclick="do_login()">Login</button>
        </div>
		<div class="buttonBar">
		<button type="button" onclick="navMan('newuser.php')">Click here to register</button>
		</div>
		<div class="buttonBar">
		<button type="button" onclick="navMan('customerLogin.php')">Customer Login</button>
		</div>
      </div>
      <input type="hidden" name="a" value="doLogin">
    </form>
 </div>
 </div>

<?PHP
build_footer();
?>