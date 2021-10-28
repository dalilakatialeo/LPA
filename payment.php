<?PHP
$clientChk = true;
require('app-lib.php');
isset($_POST['a'])? $action = $_POST['a'] : $action = "";
$msg = null;


build_header($displayName);

build_ClientnavBlock();

?>

<div id="content">
    <div class="PageTitle">Check Out</div>

      <table borde="0px">
          <form name="frmclientReg" id="frmclientReg" method="post" action="<?PHP echo $_SERVER['PHP_SELF']; ?>">
             <tr> <div name="txtclientID" id="txtclientID" style="width: 100px;" >Client ID : <?PHP echo $row['lpa_client_ID']; ?></div>
          </tr>


              <tr>
              <td>
                  <div>First Name:
                      <td  style="width: 300px"> <?PHP echo $row['lpa_client_firstname']; ?>
                      </td>
                  </div>
              </td>
          </tr>

          <tr>
              <td>
                  <div>Last Name:
                  <td  style="width: 300px"> <?PHP echo $row['lpa_client_lastname']; ?>
                      </td>
                  </div>
              </td>
          </tr>

          <tr>
              <td>
                  <div>Address:
                  <td  style="width: 300px"> <?PHP echo $row['lpa_client_address']; ?>
                  </div>
              </td>
          </tr>
    <tr>
        <td>
            <div>Phone Number:
            <td  style="width: 300px"> <?PHP echo $row['lpa_client_phone']; ?>
        </td>
        </div>
        </td>
    </tr>
 
    <tr>
        <td>
        </td>
        </div>
        </td>
    </tr>
 
    <tr>
        <td>
            <div>Total Amount:<?php isset($_COOKIE['price'])? $price = $_COOKIE['price'] : $price = ""; ?>
            <td  style="width: 300px"> $<?PHP echo number_format((float) $price,2); ?>   
        </td>
        </div>
        </td>
    </tr> 

<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr> <tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr> <tr><td></td></tr><tr><td></td></tr>
    <tr>
    <div><td style="width: 300px">Payment Method</td></div>
    <td style="width: 500px">
		<input name="txtStatus" id="txtStockStatusActive" type="radio" value="a">
          <label for="txtStockStatusActive"></label>
          <img src="images/master.png" alt="Mastercard" width="60" height="45"> 
          <input name="txtStatus" id="txtStockStatusInactive" type="radio" value="i">
          <label for="txtStockStatusInactive"></label>
          <img src="images/visa.png" alt="Visa" width="60" height="45">
          <input name="txtStatus" id="txtStockStatusActive" type="radio" value="a">
          <label for="txtStockStatusActive"></label>
          <img src="images/direct-debit-logo.jpg" alt="DirectDebit" width="70" height="45">
          <input name="txtStatus" id="txtStockStatusActive" type="radio" value="a">
          <label for="txtStockStatusActive"></label>
          <img src="images/paypal.png" alt="Paypal" width="80" height="45">
    <tr>
              <td>
                  <div>Card Number:
                      <td><input id="ccn" type="tel" input="numeric" pattern="[0-9\s]{13,19}" autocomplete="cc-number" maxlength="19" placeholder="xxxx-xxxx-xxxx-xxxx"style="width: 120px">
                      </td>
                  </div>
              </td>
          </tr>
          <tr>
              <td>
                  <div>Expire Date: 
                      <td> <input style="width: 50px" type="tel" input="numeric" placeholder="xx / xx" maxlength="5">
                      </td>
                  </div>
              </td>
          </tr>
          <tr>
 
    </form>

<tr></tr>
<tr></tr>
        <tr>
            <div class="optBar"></div> </tr>
<tr>
            <div>
                <td></td>
	<td><button type="button" onclick="navMan('checkOut.php')">Confirm Payment</button> <button type="button" name="btnCancel" onclick="navMan('Cart.php')">Cancel</button> </td>
    </div>
    </tr>




  </table>
</div>

<?PHP
build_footer();
?>