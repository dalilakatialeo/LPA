<?PHP

  $authChk = true;
  require('app-lib.php');
  isset($_POST['a'])? $action = $_POST['a'] : $action = "";
  if(!$action) {
    isset($_REQUEST['a'])? $action = $_REQUEST['a'] : $action = "";
  }
  isset($_POST['txtSearch'])? $txtSearch = $_POST['txtSearch'] : $txtSearch = "";
  if(!$txtSearch) {
    isset($_REQUEST['txtSearch'])? $txtSearch = $_REQUEST['txtSearch'] : $txtSearch = "";
  }
  build_header($displayName);
?>
	<?PHP build_navBlock(); ?>
	<div id="content">
		<div class="PageTitle">Clients Management Search</div>
   
		<!-- Search Section Start -->
		<form name="frmSearchClient" method="post" id="frmSearchClient" action="<?PHP echo $_SERVER['PHP_SELF']; ?>">
			<div class="displayPane">
				<div class="displayPaneCaption">Search:</div>
				<div>
					<input name="txtSearch" id="txtSearch" placeholder="Search clients" style="width: calc(100% - 115px)" value="<?PHP echo $txtSearch; ?>">
					<button type="button" id="btnSearch">Search</button>
					<?PHP
						if($isAdmin) {
					?>
					<button type="button" id="btnAddRec">Add</button>
					<?PHP } ?>
				</div>
			</div>
			<input type="hidden" name="a" value="listClients">
		</form>
		<!-- Search Section End -->
		
		<!-- Search Section List Start -->
		<?PHP
			if($action == "listClients") {
		?>
		<div>
			<table class="tableS">
				<tr class="trhtableS">
					<td class="tdtableS" style="width: 80px"><b>Client ID</b></td>
					<td class="tdtableS" style="width: 250px"><b>Client name</b></td>
					<td class="tdtableS" style="width: 300px"><b>Client address</b></td>
					<td class="tdtableS" style="width: 120px"><b>Client phone</b></td>
					<td class="tdtableS" style="width: 120px; text-align: center"><b>Client status</b></td>
				</tr>
			<?PHP
				openDB();
				$query =
					"SELECT
						* 
					FROM
						lpa_clients
					WHERE
						lpa_client_status <> 'D' and
						(lpa_client_firstname like '%$txtSearch%' or
						lpa_client_lastname like '%$txtSearch%')";
				$result = $db->query($query);
				$row_cnt = $result->num_rows;
				if($row_cnt >= 1) {
					$totalAmount = 0;
					while ($row = $result->fetch_assoc()) {
						$clientid = $row['lpa_client_ID'];
			?>
				<tr class="hl" 
				<?PHP if($isAdmin) { ?>
					onclick="loadInvoice(<?PHP echo $clientid; ?>,'Edit')" style="cursor: pointer"
				<?PHP } ?> 
				>			
					<td class="tdtableS">           
						<?PHP echo $clientid; ?>
					</td>
					<td class="tdtableS">
						<?PHP echo $row['lpa_client_firstname']." ".$row['lpa_client_lastname']; ?>
					</td>
					<td class="tdtableS">
						<?PHP echo $row['lpa_client_address']; ?>
					</td>
					<td class="tdtableS">
						<?PHP echo $row['lpa_client_phone']; ?>
					</td>
					<td class="tdtableS" style="text-align: center">
						<?PHP 
							if($row['lpa_client_status'] == 'A')
								echo "Active";
							else
								echo "Inactive";
						?>
					</td>
				</tr>
			<?PHP
					}
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
		<?PHP } ?>
		<!-- Search Section List End -->
	</div>
	
	<script>
		var action = "<?PHP echo $action; ?>";
		var search = "<?PHP echo $txtSearch; ?>";
		switch (action){
			case "recUpdate":
				alert("Record Updated!");
				navMan("client.php?a=listClients&txtSearch=" + search);
				break;
			case "recInsert":
				alert("Record Added!");
				navMan("client.php?a=listClients&txtSearch=" + search);
				break;
			case "recDel":
				alert("Record Deleted!");
				navMan("client.php?a=listClients&txtSearch=" + search);
				break;
		}
		function loadInvoice(ID,MODE) {
			window.location = "clientAddEdit.php?clientid=" +
			ID + "&a=" + MODE + "&txtSearch=" + search;
		}
		$("#btnSearch").click(function() {
			$("#frmSearchClient").submit();
		});
		$("#btnAddRec").click(function() {
			loadInvoice("","Add");
		});
		setTimeout(function(){
			$("#txtSearch").select().focus();
		},1);
	</script>
	
<?PHP
	build_footer();
?>