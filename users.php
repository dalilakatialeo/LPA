<?PHP
$authChk = true;
require('app-lib.php');

isset($_REQUEST['sid'])? $sid = $_REQUEST['sid'] : $sid = "";
  if(!$sid) {
    isset($_POST['sid'])? $sid = $_POST['sid'] : $sid = "";
  }
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
        <div class="PageTitle">LPA ecomms USERS</div>

        <!-- Search Section Start -->
        <form name="frmSearchStock" method="post"
              id="frmSearchStock"
              action="<?PHP echo $_SERVER['PHP_SELF']; ?>">
            <div class="displayPane">
                <div class="displayPaneCaption">Search:</div>
                <div>
                    <input name="txtSearch" id="txtSearch" placeholder="Search user"
                           style="width: calc(100% - 150px)" value="<?PHP echo $txtSearch; ?>">
                    <button type="button" id="btnSearch">Search</button>
                    <button type="button" id="btnAddRec" onclick="navMan('newuser.php')">New User</button>
                    

                </div>
            </div>
            <input type="hidden" name="a" value="listStock">
        </form>
        <!-- Search Section End -->
        <!-- Search Section List Start -->
        <?PHP
if($action == "delRec") {
    
  $query =
    "DELETE FROM lpa_users 
     WHERE
       lpa_user_ID = '$sid' LIMIT 1
    ";
  openDB();
  $result = $db->query($query);
  if($db->error) {
    printf("Errormessage: %s\n", $db->error);
    exit;
  } else {
    header("Location: users.php?a=recDel&txtSearch=$txtSearch");
    exit;
  }
}


        if($action == "listStock") {
            ?>
            <div>
                <table style="width: calc(100% - 15px);border: #cccccc solid 1px">
                    <tr style="background: #eeeeee">
                    <td style="border-left: #cccccc solid 1px"><b>User ID</b></td>
                        <td style="border-left: #cccccc solid 1px"><b>UserName</b></td>                        
                        <td style="border-left: #cccccc solid 1px"><b>First Name</b></td>
                        <td style="border-left: #cccccc solid 1px"><b>Last Name</b></td>
                    </tr>
                    <?PHP
                    openDB();
                    $query =
                        "SELECT
            *
         FROM
            lpa_users
         WHERE
            lpa_user_ID LIKE '%$txtSearch%' AND lpa_user_status = 'a' 
         OR
            lpa_user_username LIKE '%$txtSearch%' AND lpa_user_status = 'a'
         OR
            lpa_user_firstname LIKE '%$txtSearch%' AND lpa_user_status = 'a'
         OR
            lpa_user_lastname LIKE '%$txtSearch%' AND lpa_user_status = 'a'

         ";
                    $result = $db->query($query);
                    $row_cnt = $result->num_rows;
                    if($row_cnt >= 1) {
                        $total=0;
                        while ($row = $result->fetch_assoc()) {
                            $sid = $row['lpa_user_ID'];

                            
                            ?>
                            <tr class="hl">
                               <td style="border-left: #cccccc solid 1px">
                                    <?PHP echo $sid; ?>
                                </td>
                                    <td style="border-left: #cccccc solid 1px">
                                    <?PHP echo $row['lpa_user_username']; ?>
                                </td>
                                <td style="border-left: #cccccc solid 1px">
                                    <?PHP echo $row['lpa_user_firstname']; ?>
                                </td>
                                <td style="text-align: left">
                                    <?PHP echo $row['lpa_user_lastname']; ?>
                                </td>
                                <td style="text-align: left">
                                <button type="button" onclick="delRec('<?PHP echo $sid; ?>')" style="color: darkred; margin-left: 20px">DELETE</button>
                                </td>
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
        <?PHP }  ?>
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

        function delRec(ID) {
      navMan("users.php?sid=" + ID + "&a=delRec");
      alert("User Deleted");
    }
    </script>
<?PHP
build_footer();
?>