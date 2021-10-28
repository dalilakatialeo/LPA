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
<div class="PageTitle">Stock Management Search</div>

<!-- Search Section Start -->
<form name="frmSearchStock" method="post"
id="frmSearchStock"
action="<?PHP echo $_SERVER['PHP_SELF']; ?>">
<div class="displayPane">
<div>
<input name="txtSearch" id="txtSearch" placeholder="Search stock" style ="width:calc(100% - 115px)" value="<?PHP echo $txtSearch; ?>">
<button type="button" id="btnSearch">Search</button>
<?PHP
if($isAdmin) {
	?>
	<button type="button" id="btnAddRec">Add</button>
<?PHP }?>

</div>
</div>
<input type="hidden" name="a" value="listStock">
</form>
<!-- Search Section End -->
<!-- Search Section List Start-->
<?PHP
if($action == "listStock") {
	?>
	<div>
	<table class="tableS">
	<tr class="trhtableS">
	<td class="tdtableS" style="width: 80px"> <b>Stock Code</b></td>
	<td class="tdtableS" style="width: 400px"> <b>Stock Name</b></td>
	<td class="tdtableS"><b>Stock Description</b></td>
	<td class="tdtableS" style="text-align: center; width: 125px"> <b>On-hand</b></td>
	<td class="tdtableS" style="text-align: center; width: 80px"> <b>Status</b></td>
	<td class="tdtableS" style="text-align: right; width: 80px"> <b>Price</b></td>
	</tr>
<?PHP
openDB();
$query = 
"SELECT
*
FROM
lpa_stock
WHERE
(lpa_stock_ID LIKE '%$txtSearch%' AND lpa_stock_status <> 'D')
OR
(lpa_stock_name LIKE '%$txtSearch%' AND lpa_stock_status <> 'D')

";
$result = $db->query($query);
$row_cnt = $result->num_rows;
if($row_cnt >= 1) {
	while ($row = $result->fetch_assoc()) {
		$sid = $row['lpa_stock_ID'];
		?>
		<tr class="hl"
		<?PHP if($isAdmin) { ?>
		onclick="loadStockItem(<?PHP echo $sid; ?>, 'Edit')"
		style="cursor: pointer"
		<?PHP } ?>
	>
		<td class="tdtableS">
			<?PHP echo $sid; ?>
			</td>
		<td class="tdtableS">
			<?PHP echo $row['lpa_stock_name']; ?>
			</td>
		<td class="tdtableS">
			<?PHP echo $row['lpa_stock_desc']; ?>
			</td>
		<td class="tdtableS" style="text-align: center">
			<?PHP echo $row['lpa_stock_onhand']; ?>
			</td>
		<td class="tdtableS" style="text-align: center">
			<?PHP 
			if($row['lpa_stock_status'] == 'a')
				echo "Active";
			else
			echo "Inactive";
			?>
		</td>
		<td class="tdtableS" style="text-align: right">
			$<?PHP echo $row['lpa_stock_price']; ?>
		</td>
		</tr>
	<?PHP }
} else { ?>
<tr>
<td colspan="6" class="noRecordsFound">
No records found for: <b><?PHP echo $txtSearch; ?> </b>
</td>
</tr>
<?PHP }?>
</table>
</div>
<?PHP } ?>
<!-- Search Section List End -->
</div>
<script>
var action = "<?PHP echo $action; ?>";
var search = "<?PHP echo $txtSearch; ?>";
switch (action){
	case "recUpdate":
		alert("Record Updated!");
		navMan("stock.php?a=listStock&txtSearch=" + search);
		break;
	case "recInsert":
		alert("Record Added!");
		navMan("stock.php?a=listStock&txtSearch=" + search);
		break;
	case "recDel":
		alert("Record Deleted!");
		navMan("stock.php?a=listStock&txtSearch=" + search);
		break;
}
function loadStockItem (ID,MODE) {
	window.location = "stockAddEdit.php?sid=" +
	ID + "&a=" + MODE + "&txtSearch=" + search;
}
$("#btnSearch").click(function() {
	$("#frmSearchStock").submit();
});
$("#btnAddRec").click(function () {
	loadStockItem("","Add");
});
setTimeout(function () {
	$("#txtSearch").select().focus();
},1);
</script>
<?PHP
build_footer();
?>