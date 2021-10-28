<?PHP 
   $clientChk = true;
   require('app-lib.php'); 
  isset($_POST['a'])? $action = $_POST['a'] : $action = "";
?>
  <?PHP 
  build_header($displayName);
  build_ClientnavBlock(); 
  $fieldSpacer = "5px";
  ?>
  
  <div id="content">
    <div class="PageTitle">Product Search</div>

  <form name="frmSearchProduct" method="post">
    <div class="displayPane">
<div class="displayPaneCaption">Search:</div>
      <div>
        <input id="txtSearch" name="txtSearch" placeholder="Search products" style="width:calc(100% - 75px)" value="">
        <button type="submit">Search</button>
      </div>
    </div>
    <input type="hidden" name="a" value="search">

  </form>

<?PHP
    if($action == "search") {
		 openDB();
    $query =
      "UPDATE lpa_stock SET
         lpa_stock_status = 'a'
       WHERE
         lpa_stock_onhand != 0 
      ";
    $result = $db->query($query);
		
      isset($_POST['txtSearch'])? $itmSearch = $_POST['txtSearch'] : $itmSearch = "";
      $itemNum = 1;
      openDB();
      $query = "SELECT * FROM lpa_stock " .
        "WHERE lpa_stock_name LIKE '%$itmSearch%' " .
        "AND lpa_stock_status = 'a' " .
        "ORDER BY lpa_stock_name ASC";
      $result = $db->query($query);

      while ($row = $result->fetch_assoc()) {
        if ($row['lpa_image']) {
          $prodImage = $row['lpa_image'];
        } else {
          $prodImage = "question.png";
        }
        $prodID = $row['lpa_stock_ID'];
        ?>
		
        <div class="productListItem">
          <div
            class="productListItemImageFrame"
            style="background: url('images/<?PHP echo $prodImage; ?>') no-repeat center center;">
          </div>
          <div class="prodTitle"><?PHP echo $row['lpa_stock_name']; ?></div>
          <div class="prodDesc"><?PHP echo $row['lpa_stock_desc']; ?></div>
          <div class="prodOptionsFrame">
            <div class="prodPriceQty">
              <div class="prodPrice">$<?PHP echo $row['lpa_stock_price']; ?></div>
              <div class="prodQty">QTY:</div>
              <div class="prodQtyFld">
                <input
                  name="fldQTY-<?PHP echo $prodID; ?>"
                  id="fldQTY-<?PHP echo $prodID; ?>"
                  type="number"
                  min="0"
				value="0" >
              </div>
            </div>
            <div class="prodAddToCart">
              <button
                type="button" value="Add to Cart" id="btnaddcart"
                onclick="addToCart('<?PHP echo $prodID; ?>')">
                Add To Cart
              </button>
            </div>
          </div>
          <div style="clear: left"></div>
        </div>
      <?PHP } ?>
      </div>
    <?PHP
    } ?>
	</div>
	
	
  <script>
  
    function loadURL(URL) {
      window.location = URL;
    }

  </script>
  
<?PHP
  build_footer();
?>