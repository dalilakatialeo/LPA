<?PHP
  $authChk = true;
  require('app-lib.php');
  isset($_REQUEST['sid'])? $sid = $_REQUEST['sid'] : $sid = "";
  if(!$sid) {
    isset($_POST['sid'])? $sid = $_POST['sid'] : $sid = "";
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
      "UPDATE lpa_stock SET
         lpa_stock_status = 'D'
       WHERE
         lpa_stock_ID = '$sid' LIMIT 1
      ";
    openDB();
    $result = $db->query($query);
    if($db->error) {
      printf("Errormessage: %s\n", $db->error);
      exit;
    } else {
      header("Location: stock.php?a=recDel&txtSearch=$txtSearch");
      exit;
    }
  }

  isset($_POST['txtStockID'])? $stockID = $_POST['txtStockID'] : $stockID = null;
  isset($_POST['txtStockName'])? $stockName = $_POST['txtStockName'] : $stockName = "";
  isset($_POST['txtStockDesc'])? $stockDesc = $_POST['txtStockDesc'] : $stockDesc = "";
  isset($_POST['txtStockOnHand'])? $stockOnHand = $_POST['txtStockOnHand'] : $stockOnHand = "0";
  isset($_POST['txtStockImage'])? $stockImage = $_POST['txtStockImage'] : $stockImage = "";
  isset($_POST['txtStockPrice'])? $stockPrice = $_POST['txtStockPrice'] : $stockPrice = "0.00";
  isset($_POST['txtStatus'])? $stockStatus = $_POST['txtStatus'] : $stockStatus = "";
  $mode = "insertRec";
  if($action == "updateRec") {
    $query =
      "UPDATE lpa_stock SET
         lpa_stock_name = '$stockName',
         lpa_stock_desc = '$stockDesc',
         lpa_stock_onhand = '$stockOnHand',
         lpa_image = '$stockImage',
         lpa_stock_price = '$stockPrice',
         lpa_stock_status = '$stockStatus'
       WHERE
         lpa_stock_ID = '$sid' LIMIT 1
      ";
     openDB();
     $result = $db->query($query);
     if($db->error) {
       printf("Errormessage: %s\n", $db->error);
       exit;
     } else {
         header("Location: stock.php?a=recUpdate&txtSearch=$txtSearch");
       exit;
     }
  }
  if($action == "insertRec") {
    $query =
      "INSERT INTO lpa_stock (
         lpa_stock_name,
         lpa_stock_desc,
         lpa_stock_onhand,
         lpa_image,
         lpa_stock_price,
         lpa_stock_status
       ) VALUES (
         '$stockName',
         '$stockDesc',
         '$stockOnHand',
         '$stockImage',
         '$stockPrice',
         '$stockStatus'
       )
      ";
    openDB();
    $result = $db->query($query);
    if($db->error) {
      printf("Errormessage: %s\n", $db->error);
      exit;
    } else {
      header("Location: stock.php?a=recInsert&txtSearch=".$stockID);
      exit;
    }
  }

  if($action == "Edit") {
    $query = "SELECT * FROM lpa_stock WHERE lpa_stock_ID = '$sid' LIMIT 1";
    $result = $db->query($query);
    $row_cnt = $result->num_rows;
    $row = $result->fetch_assoc();
    $stockID     = $row['lpa_stock_ID'];
    $stockName   = $row['lpa_stock_name'];
    $stockDesc   = $row['lpa_stock_desc'];
    $stockOnHand = $row['lpa_stock_onhand'];
    $stockImage  = $row['lpa_image'];
    $stockPrice  = $row['lpa_stock_price'];
    $stockStatus = $row['lpa_stock_status'];
    $mode = "updateRec";
  }
  build_header($displayName);
  build_navBlock();
  $fieldSpacer = "5px";
?>

  <div id="content">
    <div class="PageTitle">Stock Record Management (<?PHP echo $action; ?>)</div>
    <form name="frmStockRec" id="frmStockRec" method="post" action="<?PHP echo $_SERVER['PHP_SELF']; ?>">
	
	 <div class="divTable">
	  <div class="divTableRow">
      
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>"></div>
	  <tr>
	  <td>
	  <div style="width: 115px; float: left">Stock code:</div>
	  <td><input name="txtStockID" id="txtStockID" value="<?PHP echo $stockID; ?>" style="width: 100px;" title="Stock Code" disabled></td>
	  </td>
	  </tr>
	  <div style="margin-top: <?PHP echo $fieldSpacer; ?>"></div>
	  
	  <tr>
	  <td>
	  <div style="width: 115px; float: left">Stock name:</div>
        <td><input name="txtStockName" id="txtStockName" value="<?PHP echo $stockName; ?>" style="width: 300px;"  title="Stock Name"></td>
		</td>
		</tr>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>"></div>
	  
	  <tr>
	  <td>
	  <div style="width: 115px; float: left">Stock description:</div>
        <td><textarea name="txtStockDesc" id="txtStockDesc" style="width: 400px;height: 80px"  title="Stock description"><?PHP echo $stockDesc; ?></textarea></td>
		</td>
		</tr>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>"></div>
	  <tr>
	  <td>
	  <div style="width: 115px; float: left">Stock on-hand:</div>
        <td><input name="txtStockOnHand" id="txtStockOnHand" placeholder="Stock on-hand" value="<?PHP echo $stockOnHand; ?>" style="width: 90px;text-align: right"  title="Stock On-Hand"></td>
		</td>
		</tr>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>"></div>
	  
	  <tr>
	  <td>
	  <div style="width: 115px; float: left">Stock price:</div>
        <td><input name="txtStockPrice" id="txtStockPrice" placeholder="Stock Price" value="$<?PHP echo $stockPrice; ?>" style="width: 90px;text-align: right"  title="Stock Price"></td>
		</td>
		</tr>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>"></div>
	  
	  <tr>
        <td>
		<div style="width: 115px; float: left">Stock status:</div>
        </td><input name="txtStatus" id="txtStockStatusActive" type="radio" value="a">
          <label for="txtStockStatusActive">Active</label>
        <input name="txtStatus" id="txtStockStatusInactive" type="radio" value="i">
          <label for="txtStockStatusInactive">Inactive</label> </td>
		  </td>
	 </tr>
      </div>
      <input name="a" id="a" value="<?PHP echo $mode; ?>" type="hidden">
      <input name="sid" id="sid" value="<?PHP echo $sid; ?>" type="hidden">
      <input name="txtSearch" id="txtSearch" value="<?PHP echo $txtSearch; ?>" type="hidden">
    </form>
    <div class="optBar">
      <button type="button" id="btnStockSave">Save</button>
      <button type="button" onclick="navMan('stock.php')">Close</button>
      <?PHP if($action == "Edit") { ?>
      <button type="button" onclick="delRec('<?PHP echo $sid; ?>')" style="color: darkred; margin-left: 20px">DELETE</button>
      <?PHP } ?>
    </div>
  </div>
  </div>
  <script>
    var stockRecStatus = "<?PHP echo $stockStatus; ?>";
    if(stockRecStatus == "a") {
      $('#txtStockStatusActive').prop('checked', true);
    } else {
      $('#txtStockStatusInactive').prop('checked', true);
    }
    $("#btnStockSave").click(function(){
        $("#frmStockRec").submit();
    });
    function delRec(ID) {
      navMan("stockaddedit.php?sid=" + ID + "&a=delRec");
    }
    setTimeout(function(){
      $("#txtStockName").focus();
    },1);
  </script>
<?PHP
build_footer();
?>