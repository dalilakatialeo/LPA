<?PHP
$clientChk = true;
require('app-lib.php');
isset($_POST['a'])? $action = $_POST['a'] : $action = "";
  if(!$action) {
    isset($_REQUEST['a'])? $action = $_REQUEST['a'] : $action = "";
  }
  
build_header($displayName);

?>
<?php  
build_ClientnavBlock();
$fieldSpacer = "5px";
 ?>
<div id="content">
    <div class="PageTitle">Your Shopping Cart</div>
	
	<div>
      <table id="table">
        <tr>
          <td class="tableCell">Code</td>
          <td class="tableCell">Name</td>
          <td class="tableCell">Quantity</td>
          <td class="tableCell">Image</td>
          <td class="tableCell">Product price</td>
		  <td class="tableCell">Subtotal</td>
          <td class="tableCell">Remove from Cart</td>
        </tr>
                    <?php $price = 0;
                    $totalItems = 0;
					$qty = $_COOKIE["qty"];

                    for ($i=0; $i<99; $i++) {
                            $name1 = 'cartItem';
                            $name2 = $name1.$i;
                            isset($_COOKIE[$name2])? $cookie = $_COOKIE[$name2] : $cookie = "";
                                if ($cookie == isset($_COOKIE[$name2])) {
                                    $item = $cookie;
                                    openDB();
                                    $query =
                                    "SELECT * FROM
                                    lpa_stock
                                    WHERE lpa_stock_ID LIKE '%$item%' AND lpa_stock_status <> 'D' 
                                     ";  
                                     $result = $db->query($query);                

									 
                                     $row_cnt = $result->num_rows;
                                     if($row_cnt >= 1) {

                                       while ($row = $result->fetch_assoc()) {
                                        if ($row['lpa_image']) {
                                            $prodImage = $row['lpa_image'];
                                          } else {
                                            $prodImage = "question.png";
                                          }
                                         $sid = $row['lpa_stock_ID'];

                                         if ($item == $sid){
                                           $totalItems = $totalItems + 1;
                                           ?>
           
                                                </tr> 
                                         <tr class="hl">
                                           <td class="cartRow" style="text-align: center">
                                             <?PHP echo $sid; ?>
                                           </td>
                                           <td class="cartRow" style="text-align: center">
                                               <?PHP echo $row['lpa_stock_name']; ?>
                                           </td>
                                           <td class="cartRow" style="text-align: center">
                                           <?php echo $qty; ?> 
                                           </td>
                                           <td class="cartRow" style="text-align: center" width="35" height="50">
                                           <div class="productListItemImageFrame"  style="align: center; background: url('images/<?PHP echo $prodImage; ?>') no-repeat center center;">
                                            </div>
                                           </td>
                                           <td class="cartRow" style="text-align: center">
                                             <?PHP echo "$" . $row['lpa_stock_price']; ?>
                                           </td>
										   <td class="cartRow" style="text-align: center">
										   <?php $subtotal = $qty *($row['lpa_stock_price']); ?>
                                             $<?PHP echo number_format((float) $subtotal,2); ?>
                                           </td>
                                           <td class="cartRow" style="text-align: center"> <button id="btndel" name="btndel" onclick="deleteCookie('<?PHP echo $name2; ?>'); navMan('cart.php')"> Remove </button> </td>
                                           
                                           
                                       </tr> <?php  
									$price = $price + $qty*($row['lpa_stock_price']);
                                    }} }}
                                  }?>
                                      
    <tr>
          <td class="totalCell">CART TOTAL</td>
          <td class="totalCell"></td>
          <td class="totalCell"></td>
          <td class="totalCell"></td>
          <td class="totalCell"></td>
          <td class="totalCell">$<?php echo number_format((float) $price,2); ?></td>
		  <td class="totalCell"></td>
    </tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
    <tr>
         <td id="buttonCell"> <button id="buttonBack" type="button" onclick="navMan('products.php')"> &lt &lt Back to Catalog</button></td>
		 <td></td> 
		 <td></td> 
		 <td></td> 
		 <td></td>
		 <td></td>
		 <?php if ($totalItems > 0) { ?>
          
         <td id="buttonCell"> <button id="buttonConfirm" type="button" onclick="setCookie('totalItems',<?php echo $totalItems; ?>,1); setCookie('price',<?php echo$price; ?>,1); navMan('Payment.php')">Confirm &gt &gt </button></td> <?php } else
         { ?> <td></td> <?php } ?>
                    </tr>
        </table>
 </div>
 </div>

<script>

</script>


<?php
build_footer();
?>