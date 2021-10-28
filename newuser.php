<?PHP
require('app-lib.php');


isset($_REQUEST['a'])? $action = $_REQUEST['a'] : $action = "";
if(!$action) {
    isset($_POST['a'])? $action = $_POST['a'] : $action = "";
}

$msg = null;


    isset($_POST['txtuserID']) ? $uID = $_POST['txtuserID'] : $uID = gen_ID();
    isset($_POST['fldfirstName']) ? $uName = $_POST['fldfirstName'] : $uName = "";
    isset($_POST['fldlastName']) ? $uLast = $_POST['fldlastName'] : $uLast = "";
    isset($_POST['fldusergroup']) ? $group = $_POST['fldusergroup'] : $group = "";
    isset($_POST['txtStatus']) ? $status = $_POST['txtStatus'] : $status = "";
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
        lpa_user_username
      FROM
        lpa_users
      WHERE
        lpa_user_username = '$username'
      ";
    $result = $db->query($query);
    $row = $result->fetch_assoc();
    if ($uName == '') { $msg = "Need to introduce User First Name";
    } else if ($uLast == '') { $msg = "Need to introduce User Last Name";
    } else if ($group == '') { $msg = "Need to introduce User group (standard - administrator)";
    } else if ($status == '') { $msg = "Need to introduce User status";
    } else if ($username == '') { $msg = "Need to introduce an UserName";
    } else if ($username == $row['lpa_user_username']) { $msg = "UserName already Exist!. Choose a different one.";
    } else if ($password == '') { $msg = "Need to introduce a Password";
    } else if ($password <> $confirmPassword) { $msg = "Passwords don't match";
       }  else { 
        

        $msg = "Registration Succesful.";
    $query =
        "INSERT INTO lpa_users (
         lpa_user_ID ,
         lpa_user_firstname,
         lpa_user_lastname,
         lpa_user_group,
         lpa_user_status,
         lpa_user_username,
         lpa_user_password 
       ) VALUES (
         '$uID',
         '$uName',
         '$uLast',
         '$group',
         '$status',
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
        header("Location: users.php?a=recInsert&txtSearch=".$uID);
        exit;
    } 
} }


?>
<?php
   build_header($displayName);
  build_navBlock();
  $fieldSpacer = "5px";
?>



  <div id="content">
    <div class="PageTitle">New User Registration</div>

      <table border="0px">
          <form name="frmclientReg" id="frmclientReg" method="post" action="<?PHP echo $_SERVER['PHP_SELF']; ?>">
             <tr> <div name="txtclientID" id="txtclientID" style="width: 100px;" >User ID : <?PHP echo $uID; ?></div>
          </tr>


              <tr>
              <td>
                  <div>First Name: 
                      <td><input name="fldfirstName" id="fldfirstName"  value="<?PHP echo $uName; ?>"style="width: 200px">
                      </td>
                  </div>
              </td>
          </tr>

          <tr>
              <td>
                  <div>Last Name:
                      <td><input name="fldlastName" id="fldlastName"  value="<?PHP echo $uLast; ?>"style="width: 200px">
                      </td>
                  </div>
              </td>
          </tr>

          <tr>
              <td>
                  <div>User Group:
                      <td>	<input name="fldusergroup" id="fldusergroupactive" type="radio" value="administrator">
								<label for="StatusActive">Administrator</label>
							<input name="fldusergroup" id="fldusergroupinactive" type="radio" value="standard">
								<label for="StatusinActive">Standard</label>
					  </td>
                  </div>
              </td>
          </tr>
		  <tr>
			  <td>
				  <div>Status:
					  <td>  <input name="txtStatus" id="txtStockStatusActive" type="radio" value="active">
								<label for="txtStockStatusActive">Active</label>
							<input name="txtStatus" id="txtStockStatusInactive" type="radio" value="inactive">
								<label for="txtStockStatusInactive">Inactive</label>
					  </td>
                 </div>
              </td>
          </tr>

    <tr>
        <td>
            <div>UserName:
        <td><input name="fldusername" id="fldusername"  value="<?PHP echo $username; ?>"style="width: 200px">
        </td>
        </div>
        </td>
    </tr>

    <tr>
        <td>
            <div>Password:
        <td><input name="fldpassword" id="fldpassword"  type="password" value="<?PHP echo $password; ?>"style="width: 200px">
        </td>
        </div>
        </td>
    </tr>

    <tr>
        <td>
            <div>Confirm Password:
        <td><input name="fldconfirmpassword" id="fldconfirmpassword"  type="password" value="<?PHP echo $confirmPassword; ?>"style="width: 200px">
        </td>
        </div>
        </td>
    </tr>


    <input name="a" id="a" value="<?PHP echo $mode; ?>" type="hidden">
  
    </form>


        <tr>
            <div class="optBar"></div> </tr>
<tr>
            <div>
                <td>  <button type="button" name="btnReg" id="btnReg" >Register</button></td>
            <td> <button type="button" name="btnCancel" id="btnCancel" onclick="navMan('newusers.php')">Delete All</button> </td>
            <td> <button type="button" name="btnback" id="btnback" onclick="navMan('users.php')">Back</button> </td>
    </div>
    </tr>




  </table>
  </div>
    <script>
var msg = "<?PHP echo $msg; ?>";
        if(msg) {
            alert(msg);
        }

        $("#btnReg").click(function(){
            $("#frmclientReg").submit();
        });

        var userStatus = "<?PHP echo $status; ?>";
    if(userStatus == "a") {
      $('#txtStockStatusActive').prop('checked', true);
    } else {
      $('#txtStockStatusInactive').prop('checked', true);
    }

    var usergroup = "<?PHP echo $group; ?>";
    if(usergroup == "administrator") {
      $('#StatusActive').prop('checked', true);
    } else {
      $('#StatusinActive').prop('checked', true);
    }


        setTimeout(function(){
            $("#txtSearch").select().focus();
        },1);

    </script>



<?PHP
build_footer();
?>