<?PHP
  $authChk = true;
  require('app-lib.php');
  isset($_REQUEST['invid'])? $invid = $_REQUEST['invid'] : $invid = "";
  if(!$invid) {
    isset($_POST['invid'])? $invid = $_POST['invid'] : $invid = "";
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
      "UPDATE lpa_invoices SET
         lpa_inv_status = 'D'
       WHERE
         lpa_inv_no = '$invid' LIMIT 1
      ";
    openDB();
    $result = $db->query($query);
    if($db->error) {
      printf("Errormessage: %s\n", $db->error);
      exit;
    } else {
      header("Location: sales.php?a=recDel&txtSearch=$txtSearch");
      exit;
    }
  }

  isset($_POST['txtSalesInvNo'])? $salesInvNo = $_POST['txtSalesInvNo'] : $salesInvNo = null;
  isset($_POST['txtSalesInvDate'])? $salesInvDate = $_POST['txtSalesInvDate'] : $salesInvDate = "";
  isset($_POST['txtSalesClientID'])? $salesClientID = $_POST['txtSalesClientID'] : $salesClientID = "";
  isset($_POST['txtSalesClientName'])? $salesClientName = $_POST['txtSalesClientName'] : $salesClientName = "";
  isset($_POST['txtSalesClientAddress'])? $salesClientAddress = $_POST['txtSalesClientAddress'] : $salesClientAddress = "";
  isset($_POST['txtSalesInvAmount'])? $salesInvAmount = $_POST['txtSalesInvAmount'] : $salesInvAmount = "0.00";
  isset($_POST['txtSalesInvStatus'])? $salesInvStatus = $_POST['txtSalesInvStatus'] : $salesInvStatus = "";
  $mode = "insertRec";
  if($action == "updateRec") {
    $query =
      "UPDATE lpa_invoices SET
         lpa_inv_no = '$salesInvNo',
		 lpa_inv_date = '$salesInvDate',
         lpa_inv_client_ID = '$salesClientID',
         lpa_inv_client_name = '$salesClientName',
         lpa_inv_client_address = '$salesClientAddress',
         lpa_inv_amount = '$salesInvAmount',
         lpa_inv_status = '$salesInvStatus'
       WHERE
         lpa_inv_no = '$invid' LIMIT 1
      ";
     openDB();
     $result = $db->query($query);
     if($db->error) {
       printf("Errormessage: %s\n", $db->error);
       exit;
     } else {
         header("Location: sales.php?a=recUpdate&txtSearch=$txtSearch");
       exit;
     }
  }
  if($action == "insertRec") {
	  $dateTime = $salesInvDate." ".date("h:i:s");
    $query =
      "INSERT INTO lpa_invoices (
		 lpa_inv_date,
         lpa_inv_client_ID,
         lpa_inv_client_name,
         lpa_inv_client_address,
         lpa_inv_amount,
         lpa_inv_status
       ) VALUES (
		 '$dateTime',
         '$salesClientID',
         '$salesClientName',
         '$salesClientAddress',
         '$salesInvAmount',
         '$salesInvStatus'
		 )";
    openDB();
    $result = $db->query($query);
    if($db->error) {
      printf("Error message: %s\n", $db->error);
      exit;
    } else {
      header("Location: sales.php?a=recInsert&txtSearch=".$salesInvNo);
      exit;
    }
  }

  if($action == "Edit") {
    $query = "SELECT * FROM lpa_invoices WHERE lpa_inv_no = '$invid' LIMIT 1";
    $result = $db->query($query);
    $row_cnt = $result->num_rows;
    $row = $result->fetch_assoc();
    $salesInvNo     	= $row['lpa_inv_no'];
    $salesInvDate  		= $row['lpa_inv_date'];
    $salesClientID   	= $row['lpa_inv_client_ID'];
    $salesClientName 	= $row['lpa_inv_client_name'];
    $salesClientAddress = $row['lpa_inv_client_address'];
    $salesInvAmount 	= $row['lpa_inv_amount'];
    $salesInvStatus		= $row['lpa_inv_status'];
    $mode = "updateRec";
  }
  build_header($displayName);
  build_navBlock();
  $fieldSpacer = "5px";
?>

  <div id="content">
    <div class="PageTitle">Sales Record Management (<?PHP echo $action; ?>)</div>
    <form name="frmSalesRec" id="frmSalesRec" method="post" action="<?PHP echo $_SERVER['PHP_SELF']; ?>">
      
	  <div class="divTable">
	  <div class="divTableRow">
	  
	  <div style="margin-top: <?PHP echo $fieldSpacer; ?>"></div>
        <tr>
		<td>
		<div style="width: 500px">Invoice number:</div>
		<td>
		<?PHP
		if($action == "Add") {
		?>
			<input name="txtSalesInvNo" id="txtSalesInvNo" value="<?PHP echo $salesInvNo; ?>" style="width: 100px;"  title="Invoice Number" hidden>
		<?PHP
		} else {
		?>
		<input name="txtSalesInvNo" id="txtSalesInvNo" value="<?PHP echo $salesInvNo; ?>" style="width: 100px;"  title="Invoice Number" disabled>
		<?PHP 
		}
		?>
		</td>
		</td>
		</tr>
        	  <div style="margin-top: <?PHP echo $fieldSpacer; ?>"></div>
		
		<tr>
		<td>
		<div style="width: 115px; float: left">Invoice Date:</div>
		<td>
		<?PHP
		if($action == "Add") {
			?>
		<input type="date" name="txtSalesInvDate" id="txtSalesInvDate" value="<?PHP echo $salesInvDate; ?>" style="width: 200px;" title="Invoice Date">
		<?PHP
		} else {
			?>
			<input type="datetime" name="txtSalesInvDate" id="txtSalesInvDate" value="<?PHP $date = date_create($salesInvDate, timezone_open("Australia/Brisbane"));	echo date_format($date,"d-m-Y")." ".date_format($date,"H:i:s")."";
						?>" style="width: 200px;" title="Invoice Date">
		<?PHP 
		}
		?>
		</td>
		</td>
			</tr>
	   <div style="margin-top: <?PHP echo $fieldSpacer; ?>"></div>
	  <tr>
	  <td>
	  <div style="width: 115px; float: left">Client ID:</div>
        <td><input name="txtSalesClientID" id="txtSalesClientID" style="width: 130px;"  title="Client ID" value="<?PHP echo $salesClientID; ?>" ></td>
		<td><input type="button" value="Search..." id="lookup1" /> </td>
		</td>
		</tr>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>"></div>
	  <tr>
	  <td>
	  <div style="width: 115px; float: left">Client name:</div>
        <td><input name="txtSalesClientName" id="txtSalesClientName" value="<?PHP echo $salesClientName; ?>" style="width: 250px;" title="Client Name"></td>
		</td>
		</tr>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>"> </div>
	  <tr>
	  <td>
	  <div style="width: 115px; float: left">Client address:</div>
	  <td><input name="txtSalesClientAddress" id="txtSalesClientAddress" value="<?PHP echo $salesClientAddress; ?>" style="width: 300px;" title="Client address"> </td>
	  </td>
	  </tr>
	  <div style="margin-top: <?PHP echo $fieldSpacer; ?>"> </div>
	  <tr>
	  <td>
	  <div style="width: 115px; float: left">Invoice amount:</div>
	  <td><input name="txtSalesInvAmount" id="txtSalesInvAmount" value="$<?PHP echo $salesInvAmount; ?>" style="width: 90px;text-align: right"  title="Sales Invoice Amount"></td>
	  </td>
	  </tr>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>"> </div>
	  <tr>
        <td>
		<div style="width: 115px; float: left">Sales Status:</div>
        <td><input name="txtSalesInvStatus" id="txtSalesStatusPaid" type="radio" value="P">
          <label for="txtSalesStatusPaid">Paid</label>
        <input name="txtSalesInvStatus" id="txtSalesStatusUnpaid" type="radio" value="U">
          <label for="txtSalesStatusUnpaid">Unpaid</label>
		  </td>
		  </td>
	  </tr>
	  </div>
      <input name="a" id="a" value="<?PHP echo $mode; ?>" type="hidden">
      <input name="sid" id="sid" value="<?PHP echo $invid; ?>" type="hidden">
      <input name="txtSearch" id="txtSearch" value="<?PHP echo $txtSearch; ?>" type="hidden">
    </form>
    <div class="optBar">
      <button type="button" id="btnSalesSave">Save</button>
      <button type="button" onclick="navMan('sales.php')">Close</button>
      <?PHP if($action == "Edit") { ?>
      <button type="button" onclick="delRec('<?PHP echo $invid; ?>')" style="color: darkred; margin-left: 20px">DELETE</button>
      <?PHP } ?>
    </div>
  </div>
  </div>
  <script>
/*  $(document).ready(function () {
        $('input[id$=txtSalesInvDate]').datepicker({});
    }); */
    var salesRecStatus = "<?PHP echo $salesInvStatus; ?>";
    if(salesRecStatus == "a") {
      $('#txtSalesStatusPaid').prop('checked', true);
    } else {
      $('#txtSalesStatusUnpaid').prop('checked', true);
    }
    $("#btnSalesSave").click(function(){
        $("#frmSalesRec").submit();
    });
    function delRec(ID) {
      navMan("salesaddedit.php?invid=" + ID + "&a=delRec");
    }
    setTimeout(function(){
      $("#txtSalesInvDate").focus();
    },1);
	
	$(document).ready(function () {
		$("#lookup1").lookupbox({
			title: 'Search Client',
			url: 'searchClient.php?chars=',
			imgLoader: 'Loading...',
			width: 600,
			onItemSelected: function(data){
				$('input[name=txtSalesClientID]').val(data.lpa_client_ID);
				$('input[name=txtSalesClientName]').val(data.lpa_client_name);
				$('input[name=txtSalesClientAddress]').val(data.lpa_client_address);
			},
			tableHeader: ['Client ID', 'Client name', 'Client address']
		});
	});
 </script>
  
<?PHP
build_footer();
?>