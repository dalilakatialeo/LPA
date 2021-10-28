<?PHP
require('app-lib.php');
isset($_POST['a'])? $action = $_POST['a'] : $action = "";
$msg = null;
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
        lpa_client_ID,
        lpa_client_username,
        lpa_client_password,
		lpa_client_status
      FROM
        lpa_clients
      WHERE
        lpa_client_username = '$uName'
      LIMIT 1
      ";
    $result = $db->query($query);
    $row = $result->fetch_assoc();
    $password_entered = $uPassword;
    $password_hash =$row['lpa_client_password'];

    if($row['lpa_client_username'] == $uName) {
        if(password_verify($password_entered, $password_hash)) {
            $_SESSION['authClient'] = $row['lpa_client_ID'];
            $_SESSION['isActive'] = (($row['lpa_client_status']=="E")?true:false);
            header("Location: indexClient.php");
            exit;
        } else if ($row['lpa_client_password'] == $uPassword) {
            $_SESSION['authClient'] = $row['lpa_client_ID'];
            $_SESSION['isActive'] = (($row['lpa_client_status']=="E")?true:false);
            header("Location: indexClient.php");
            exit;
        }
    }

    if($chkLogin == false) {
        $msg = "Login failed! Please try again.";
    }

}
build_header();
?>
<div id="container">   
   <div id="contentLogin">
        <form name="frmLogin" id="frmLogin" method="post" action="CustomerLogin.php">
            <div class="titleBar">Customer Login</div>
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
		<button type="button" onclick="navMan('reg.php')">Click here to register</button>
		</div>
		<div class="buttonBar">
		<button type="button" onclick="navMan('Login.php')">User Login</button>
		</div>
            </div>
			<input type="hidden" name="a" value="doLogin">
        </form>
    </div>
	</div>
<?PHP
build_footer();
?>