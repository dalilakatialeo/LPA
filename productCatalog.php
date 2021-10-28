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
        <div class="PageTitle">Product Search</div>

        <!-- Search Section Start -->
        <form name="frmSearchStock" method="post"
              id="frmSearchStock"
              action="<?PHP echo $_SERVER['PHP_SELF']; ?>">
            <div class="displayPane">
                <div class="displayPaneCaption">Search:</div>
                <div>
                    <input name="txtSearch" id="txtSearch" placeholder="Search product"
                           style="width: calc(100% - 115px)" value="<?PHP echo $txtSearch; ?>">
                    <button type="button" id="btnSearch">Search</button>
                </div>
            </div>
            <input type="hidden" name="a" value="listStock">
        </form>
        <!-- Search Section End -->
        <!-- Search Section List Start -->
        <?PHP
        if($action == "listStock") {
            ?>
            <div>
                <table style="width: calc(100% - 15px);border: #cccccc solid 1px">
                    <tr style="background: #eeeeee">
                        <td style="width: 80px;border-left: #cccccc solid 1px"><b>Code</b></td>
                        <td style="border-left: #cccccc solid 1px"><b>Product Description</b></td>
                        <td style="border-left: #cccccc solid 1px"><b>Image</b></td>
                        <td style="width: 80px;text-align: right"><b>Price</b></td>
                        <td style="width: 80px;text-align: right"><b>Quantity avaiable</b></td>
                        <td style="width: 80px;text-align: right"><b>Add to Cart</b></td>

                    </tr>
                    <?PHP
                    openDB();
                    $query =
                        "SELECT
            *
         FROM
            lpa_stock 
         WHERE
            lpa_stock_ID LIKE '%$txtSearch%' AND lpa_stock_status <> 'D' 
         OR
            lpa_stock_name LIKE '%$txtSearch%' AND lpa_stock_status <> 'D'
          OR 
          lpa_stock_onhand LIKE  '%$txtSearch%' AND lpa_stock_status <> 'D'
          OR 
          lpa_image_test LIKE '%$txtSearch%' AND lpa_stock_status <> 'D'

         ";
                    $result = $db->query($query);
                    $row_cnt = $result->num_rows;
                    if($row_cnt >= 1) {
                        while ($row = $result->fetch_assoc()) {
                            $sid = $row['lpa_stock_ID'];
                            ?>
                            <tr class="hl">
                                <td onclick="loadStockItem(<?PHP echo $sid; ?>,'Edit')"
                                    style="cursor: pointer;border-left: #cccccc solid 1px">
                                    <?PHP echo $sid; ?>
                                </td>
                                <td onclick="loadStockItem(<?PHP echo $sid; ?>,'Edit')"
                                    style="cursor: pointer;border-left: #cccccc solid 1px">
                                    <?PHP echo $row['lpa_stock_name']; ?>
                                </td>
                                <td style="text-align: center">
                                    <?PHP echo '<img src="data:image/png;base64,'. base64_encode($row['lpa_image_test']) .'" alt="image Unavailable" width="75" height="90"/>'; ?>

                                <td style="text-align: right">
                                    <?PHP echo $row['lpa_stock_price']; ?>
                                </td>
                                <td style="text-align: center">
                                    <?PHP echo $row['lpa_stock_onhand']; ?>
                                </td>
                                <td style="width: 80px;text-align: right"><button type="button" id="btnSearch" ><img src="images/cart.png" alt="Add to cart" width="25" height="30"> </button></td>
                            </tr>
                        <?PHP }
                    } else { ?>
                        <tr>
                            <td colspan="3" style="text-align: center">
                                No Records Found for: <b><?PHP echo $txtSearch; ?></b>
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

        $("#btnSearch").click(function() {
            $("#frmSearchStock").submit();
        });

        setTimeout(function(){
            $("#txtSearch").select().focus();
        },1);
    </script>
<?PHP
build_footer();
?>