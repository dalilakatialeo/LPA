<?PHP 
  require('app-lib.php');
  
  
isset($_REQUEST['a'])? $action = $_REQUEST['a'] : $action = "";
if(!$action) {
    isset($_POST['a'])? $action = $_POST['a'] : $action = "";
}

$msg = null;


    isset($_POST['txtclientID']) ? $clientID = $_POST['txtclientID'] : $clientID = gen_ID();
    isset($_POST['fldfirstName']) ? $clientName = $_POST['fldfirstName'] : $clientName = "";
    isset($_POST['fldlastName']) ? $clientLast = $_POST['fldlastName'] : $clientLast = "";
    isset($_POST['fldaddress']) ? $address = $_POST['fldaddress'] : $address = "";
    isset($_POST['fldphone']) ? $phone = $_POST['fldphone'] : $phone = "";
    isset($_POST['fldusername']) ? $username = $_POST['fldusername'] : $username = "";
    isset($_POST['fldpassword']) ? $password = $_POST['fldpassword'] : $password = "";
    isset($_POST['fldconfirmpassword']) ? $confirmPassword = $_POST['fldconfirmpassword'] : $confirmPassword = "";
$mode = "insertRec";
$password_hash = better_crypt($password);



if($action == "insertRec") {
    openDB();
    $query =
        "
      SELECT
        lpa_client_username
      FROM
        lpa_clients
      WHERE
        lpa_client_username = '$username'
      ";
    $result = $db->query($query);
    $row = $result->fetch_assoc();
    if ($clientName == '') { $msg = "You need to enter your First Name";
    } else if ($clientLast == '') { $msg = "You need to enter your Last Name";
    } else if ($address == '') { $msg = "You need to enter your Address";
    } else if ($phone == '') { $msg = "You need to enter your Phone Number";
    } else if ($username == '') { $msg = "You need to enter your UserName";
    } else if ($username == $row['lpa_client_username']) { $msg = "UserName already Exist!. Choose a different one.";
    } else if ($password == '') { $msg = "You need to enter your Password";
    } else if ($password <> $confirmPassword) { $msg = "Passwords don't match";
       }  else { 
        

        $msg = "Registration Successful.";
    $query =
        "INSERT INTO lpa_clients (
        lpa_client_status,
         lpa_client_ID ,
         lpa_client_firstname,
         lpa_client_lastname,
         lpa_client_address,
         lpa_client_phone,
         lpa_client_username,
         lpa_client_password 
       ) VALUES (
       'E',
         '$clientID',
         '$clientName',
         '$clientLast',
         '$address',
         '$phone',
         '$username',
         '$password_hash'
       )
      ";
    openDB();
    $result = $db->query($query);
    if($db->error) {
        printf("Errormessage: %s\n", $db->error);
        exit;
    } else {
        header("Location: CustomerLogin.php?a=recInsert&txtSearch=".$clientID);
        exit;
    } 
} }


?>
  <?PHP  build_header();
?>
  <?PHP build_ClientnavBlock(); ?>
  
  <div id="content">
    <div class="PageTitle">New Customer Registration</div>

      <table border="0px">
          <form name="frmclientReg" 
		  id="frmclientReg" 
		  method="post" 
		  action="<?PHP echo $_SERVER['PHP_SELF']; ?>">
          <tr> 
			 <div name="txtclientID"
			 id="txtclientID" 
			 style="width: 100px;" >
			 Client ID : <?PHP echo $clientID; ?>
			 </div>
          </tr>
          <tr>
              <td>
                  <div>First Name: 
                      <td>
					  <input name="fldfirstName" 
					  id="fldfirstName"  
					  value="<?PHP echo $clientName; ?>"
					  style="width: 200px">
                      </td>
                  </div>
              </td>
          </tr>
          <tr>
              <td>
                  <div>Last Name:
                      <td>
					  <input name="fldlastName" 
					  id="fldlastName"  
					  value="<?PHP echo $clientLast; ?>"
					  style="width: 200px">
                      </td>
                  </div>
              </td>
          </tr>
		  <tr>
              <td>
                  <div>Address:
                      <td>
					  <input name="fldaddress" 
					  rows="3" 
					  id="fldaddress"  
					  value="<?PHP echo $address; ?>"
					  style="min-width:200px; max-width: 200px">
					  </textarea>
					  </td>
                  </div>
				</td>
          </tr>
		  <tr>
				<td>
					<div>Phone Number:
					<td>
					<input type="tel" 
					name="fldphone" 
					id="fldphone"  
					value="<?PHP echo $phone; ?>"
					style="width: 200px">
					</td>
					</div>
				</td>
		</tr>
		<tr>
				<td>
					<div>UserName:
					<td>
					<input name="fldusername" 
					id="fldusername"  
					value="<?PHP echo $username; ?>"
					style="width: 200px">
					</td>
					</div>
				</td>
		</tr>
		<tr>
				<td>
					<div>Password:
					<td>
					<input name="fldpassword" 
					id="fldpassword"  
					type="password" 
					value="<?PHP echo $password; ?>"
					style="width: 200px">
					</td>
					</div>
				</td>
		</tr>
		<tr>
				<td>
					<div>Confirm Password:
					<td>
					<input name="fldconfirmpassword" 
					id="fldconfirmpassword"  
					type="password" 
					value="<?PHP echo $confirmPassword; ?>"
					style="width: 200px">
					</td>
					</div>
				</td>
		</tr>
		<input name="a" id="a" value="<?PHP echo $mode; ?>" type="hidden">
		</form>
        <tr>
            <div class="optBar">
			</div>
		</tr>
		<tr>
            <div>
			<td>
			</td>
            <td>  
				<button type="button" 
			name="btnCancel" 
			id="buttonCancel" 
			onclick="navMan('reg.php')">
			Delete All
				</button>
				<button type="button" 
			name="btnReg" 
			id="buttonReg">
			Register
				</button>				
			</td>
			</div>
		</tr>
  </table>
  </div>
 <script>
var msg = "<?PHP echo $msg; ?>";
        if(msg) {
            alert(msg);
        }

        $("#buttonReg").click(function(){
            $("#frmclientReg").submit();
        });


        setTimeout(function(){
            $("#txtSearch").select().focus();
        },1);

</script>


<?PHP
build_footer();
?>