<?PHP
$authChk = true;
require('app-lib.php');
isset($_POST['a'])? $action = $_POST['a'] : $action = "";
if(!$action) {
	isset($_REQUEST['a'])? $action = $_REQUEST['a'] : $action = "";
}
isset($_POST['txtSearch'])? $txtSearch = $_POST['txtSearch'] : $txtSearch = "";
if (!$txtSearch) {
	isset($_REQUEST['txtSearch'])? $txtSearch = $_REQUEST['txtSearch'] : $txtSearch = "";
}
build_header($displayName);
?>
<?PHP build_navBlock(); ?>
  <div id="content">
<div class="PageTitle">Sales Management Search</div>

<!-- Search Section Start -->
<form name="frmSearchSales" method="post"
id="frmSearchSales"
action="<?PHP echo $_SERVER['PHP_SELF']; ?>">
<div class="displayPane">
<div>
<input name="txtSearch" id="txtSearch" placeholder="Search invoices" style ="width:calc(100% - 115px)" value="<?PHP echo $txtSearch; ?>">
<button type="button" id="btnSearch">Search</button>
<?PHP
if($isAdmin) {
	?>
	<button type="button" id="btnAddRec">Add</button>
<?PHP }?>

</div>
</div>
<input type="hidden" name="a" value="listSales">
</form>

<!-- Search Section End -->
<!-- Search Section List Start-->
<?PHP
if($action == "listSales") {
	?>
	<div>
	<table class="tableS">
	<tr class="trhtableS">
	<td class="tdtableS" style="width: 80px;"> <b>Invoice No.</b></td>
	<td class="tdtableS" style="width: 200px;"> <b>Invoice Date</b></td>
	<td class="tdtableS" style="width: 400px;"> <b>Client Name</b></td>
	<td class="tdtableS" style="width: 80px; text-align: right"> <b>Amount</b></td>
	</tr>
<?PHP
openDB();
$query = 
"SELECT
*
FROM
lpa_invoices
WHERE
(lpa_inv_no LIKE '%$txtSearch%' AND lpa_inv_status <> 'D')
OR
(lpa_inv_client_name LIKE '%$txtSearch%' AND lpa_inv_status <> 'D')
OR
(lpa_inv_client_ID LIKE '%$txtSearch%' AND lpa_inv_status <> 'D')

";
$result = $db->query($query);
$row_cnt = $result->num_rows;
if($row_cnt >= 1) {
	$totalAmount = 0;
	while ($row = $result->fetch_assoc()) {
		$invid = $row['lpa_inv_no'];
		?>
		<tr class="hl"
		<?PHP if($isAdmin) { ?>
		onclick="loadSalesItem(<?PHP echo $invid; ?>, 'Edit')"
		style="cursor: pointer"
		<?PHP } ?>
		>
		<td class="tdtableS">
		<?PHP echo $row['lpa_inv_no']; ?>
			</td>
		<td class="tdtableS">
			<?PHP 	$date = date_create($row['lpa_inv_date']);
							echo date_format($date,"d/m/Y")." at ".date_format($date,"H:i:s")."";
						?>
			</td>
		<td class="tdtableS">
			<?PHP echo $row['lpa_inv_client_name']; ?>
			</td>
		<td class="tdtableS" style="text-align: right">
			$ <?PHP echo $row['lpa_inv_amount']; ?>
			</td>
		</tr>
	<?PHP 
		$totalAmount = $totalAmount + $row["lpa_inv_amount"];
	}
	?>
	<tr>
	<td colspan='3' class="totalAmountInvoice">Total: </td>
	<td class="totalAmountInvoiceValue">$ <?PHP echo number_format($totalAmount, 2); ?></td>
	</tr>
	<?PHP
} else { 
?>
	<tr>
					<td colspan="4" class="noRecordsFound">
						No records found for: <b><?PHP echo $txtSearch; ?></b>
					</td>
				</tr>
			<?PHP } ?>
			</table>
		</div>
		<?PHP }?>
<!-- Search Section List End -->
</div>
<script>
$(function () {
    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy'
    });
});
var action = "<?PHP echo $action; ?>";
var search = "<?PHP echo $txtSearch; ?>";
switch (action){
	case "recUpdate":
		alert("Record Updated!");
		navMan("sales.php?a=listSales&txtSearch=" + search);
		break;
	case "recInsert":
		alert("Record Added!");
		navMan("sales.php?a=listSales&txtSearch=" + search);
		break;
	case "recDel":
		alert("Record Deleted!");
		navMan("sales.php?a=listSales&txtSearch=" + search);
		break;
}
function loadSalesItem (ID,MODE) {
	window.location = "salesaddedit.php?invid=" +
	ID + "&a=" + MODE + "&txtSearch=" + search;
}
$("#btnSearch").click(function() {
	$("#frmSearchSales").submit();
});
    $("#btnAddRec").click(function() {
      loadSalesItem("","Add");
    });
setTimeout(function () {
	$("#txtSearch").select().focus();
},1);
</script>
<?PHP
build_footer();
?>