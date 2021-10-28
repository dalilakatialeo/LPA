<?PHP
  $authChk = true;
  require('app-lib.php');
  isset($_REQUEST['clientid'])? $clientid = $_REQUEST['clientid'] : $clientid = "";
  if(!$clientid) {
    isset($_POST['clientid'])? $clientid = $_POST['clientid'] : $clientid = "";
  }
  isset($_REQUEST['a'])? $action = $_REQUEST['a'] : $action = "";
  if(!$action) {
    isset($_POST['a'])? $action = $_POST['a'] : $action = "";
  }
  isset($_POST['txtSearch'])? $txtSearch = $_POST['txtSearch'] : $txtSearch = "";
  if(!$txtSearch) {
    isset($_REQUEST['txtSearch'])? $txtSearch = $_REQUEST['txtSearch'] : $txtSearch = "";
  }
  if($action == "delRec") {
    $query =
      "UPDATE lpa_clients SET
         lpa_client_status = 'D'
       WHERE
         lpa_client_ID = '$clientid' LIMIT 1
      ";
    openDB();
    $result = $db->query($query);
    if($db->error) {
      printf("Error message: %s\n", $db->error);
      exit;
    } else {
      header("Location: client.php?a=recDel&txtSearch=$txtSearch");
      exit;
    }
  }

  isset($_POST['txtClientID'])? $cliID = $_POST['txtClientID'] : $cliID = null;
  isset($_POST['txtClientFirstName'])? $clientFirstName = $_POST['txtClientFirstName'] : $clientFirstName = "";
  isset($_POST['txtClientLastName'])? $clientLastName = $_POST['txtClientLastName'] : $clientLastName = "";
  isset($_POST['txtClientAddress'])? $clientAddress = $_POST['txtClientAddress'] : $clientAddress = "";
  isset($_POST['txtClientPhone'])? $clientPhone = $_POST['txtClientPhone'] : $clientPhone = "";
  isset($_POST['txtStatus'])? $clientStatus = $_POST['txtStatus'] : $clientStatus = "";
  $mode = "insertRec";
  if($action == "updateRec") {
    $query =
      "UPDATE lpa_clients SET
         lpa_client_firstname = '$clientFirstName',
         lpa_client_lastname = '$clientLastName',
         lpa_client_address = '$clientAddress',
         lpa_client_phone = '$clientPhone',
         lpa_client_status = '$clientStatus'
       WHERE
         lpa_client_ID = '$clientid' LIMIT 1
      ";
     openDB();
     $result = $db->query($query);
     if($db->error) {
       printf("Error message: %s\n", $db->error);
       exit;
     } else {
         header("Location: client.php?a=recUpdate&txtSearch=$txtSearch");
       exit;
     }
  }
  if($action == "insertRec") {
    $query =
      "INSERT INTO lpa_clients (
         lpa_client_firstname,
         lpa_client_lastname,
         lpa_client_address,
         lpa_client_phone,
         lpa_client_status
       ) VALUES (
         '$clientFirstName',
         '$clientLastName',
         '$clientAddress',
         '$clientPhone',
         '$clientStatus'
       )
      ";
    openDB();
    $result = $db->query($query);
    if($db->error) {
      printf("Error message: %s\n", $db->error);
      exit;
    } else {
      header("Location: client.php?a=recInsert&txtSearch=".$clientFirstName);
      exit;
    }
  }

  if($action == "Edit") {
    $query = "SELECT * FROM lpa_clients WHERE lpa_client_ID = '$clientid' LIMIT 1";
    $result = $db->query($query);
    $row_cnt = $result->num_rows;
    $row = $result->fetch_assoc();
    $cliID     = $row['lpa_client_ID'];
    $clientFirstName   = $row['lpa_client_firstname'];
    $clientLastName   = $row['lpa_client_lastname'];
    $clientAddress = $row['lpa_client_address'];
    $clientPhone  = $row['lpa_client_phone'];
    $clientStatus = $row['lpa_client_status'];
    $mode = "updateRec";
  }
  build_header($displayName);
  build_navBlock();
  $fieldSpacer = "5px";
?>

  <div id="container">
  <div id="content">
    <div class="PageTitle">Client Record Management (<?PHP echo $action; ?>)</div>
    <form name="frmClientRec" id="frmClientRec" method="post" action="<?PHP echo $_SERVER['PHP_SELF']; ?>">
		<div class="divTable">
		<div clas="divTableRow">
		 <div> <?PHP echo $fieldSpacer; ?> </div>
			<tr>
				<td>Client ID:</td>
				<td>	<?PHP if($action == "Add") {?>
						<input name="txtClientID" id="txtClientID" value="<?PHP echo $cliID; ?>" style="width: 80px;" title="Client ID"><?PHP} else {?>
						<input name="txtClientID" id="txtClientID" value="<?PHP echo $cliID; ?>" style="width: 80px;" title="Client ID" disabled><?PHP }?>
				</td>
			</tr>
			<div style="margin-top: <?PHP echo $fieldSpacer; ?>"></div>
			<tr>
				<td>First name:</td>
				<td> 	<input maxlength="50" name="txtClientFirstName" id="txtClientFirstName"  value="<?PHP echo $clientFirstName; ?>" style="width: 150px"  title="Client First Name">
				</td>
			</tr>
			 <div style="margin-top: <?PHP echo $fieldSpacer; ?>"></div>
			<tr>
				<td>Last name:</td>
				<td>	<input maxlength="50" name="txtClientLastName" id="txtClientLastName"  value="<?PHP echo $clientLastName;?>" style="width: 150px"  title="Client last name">
				</td>
			</tr>
			 <div style="margin-top: <?PHP echo $fieldSpacer; ?>"></div>
			<tr>		
				<td>Address:</td>
				<td>	<input maxlength="250" name="txtClientAddress" id="txtClientAddress"  value="<?PHP echo $clientAddress; ?>" style="width: 400px" title="Client address">
				</td>
			</tr>
			 <div style="margin-top: <?PHP echo $fieldSpacer; ?>"></div>
			<tr>
				<td>Phone:</td>
				<td>	<input maxlength="30" name="txtClientPhone" id="txtClientPhone"  value="<?PHP echo $clientPhone; ?>" style="width: 120px"  title="Client phone">
				</td>
			</tr>
			 <div style="margin-top: <?PHP echo $fieldSpacer; ?>"></div>
			<tr>
				<td>Status:</td>
				<td>	<input name="txtStatus" id="txtClientStatusActive" type="radio" value="A">
					<label for="txtClientStatusActive">Active</label>
					<input name="txtStatus" id="txtClientStatusInactive" type="radio" value="I">
					<label for="txtClientStatusInactive">Inactive</label>
				</td>
			</tr>					
      </div>
      <input name="a" id="a" value="<?PHP echo $mode; ?>" type="hidden">
      <input name="clientid" id="clientid" value="<?PHP echo $clientid; ?>" type="hidden">
      <input name="txtSearch" id="txtSearch" value="<?PHP echo $txtSearch; ?>" type="hidden">
    </form>
    <div class="optBar">
      <button type="button" id="btnClientSave">Save</button>
      <button type="button" onclick="navMan('client.php')">Close</button>
      <?PHP if($action == "Edit") { ?>
      <button type="button" onclick="delRec('<?PHP echo $clientid; ?>')" style="color: darkred; margin-left: 20px">DELETE</button>
      <?PHP } ?>
    </div>
	</div>
	</div>
  <script>
    var clientRecStatus = "<?PHP echo $clientStatus; ?>";
    if(clientRecStatus == "A" || "<?PHP echo $action; ?>" == "Add" ) {
      $('#txtClientStatusActive').prop('checked', true);
    } else {
      $('#txtClientStatusInactive').prop('checked', true);
    }
    $("#btnClientSave").click(function(){
        $("#frmClientRec").submit();
    });
    function delRec(ID) {
      navMan("clientAddEdit.php?clientid=" + ID + "&a=delRec");
    }
    setTimeout(function(){
      $("#txtClientFirstName").focus();
    },1);
  </script>
<?PHP
build_footer();
?>