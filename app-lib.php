<?PHP
/**
 * Set the global time zone
 *   - for Brisbane Australia (GMT +10)
 */
date_default_timezone_set('Australia/Queensland');


/**
 * Global variables
 */

// Database instance variable
$db = null;
$displayName = "";


// Start the session
session_name("lpaecomms");
session_start();

isset($_SESSION["authUser"])?
  $authUser = $_SESSION["authUser"] :
  $authUser = "";
isset($_SESSION["isAdmin"])?
  $isAdmin = $_SESSION["isAdmin"] :
  $isAdmin = "";
isset($_SESSION["authClient"])?
    $authClient = $_SESSION["authClient"] :
    $authClient = "";

if(isset($authChk) == true) {
  if($authUser) {
    openDB();
    $query = "SELECT * FROM lpa_users WHERE lpa_user_ID = '$authUser' LIMIT 1";
    $result = $db->query($query);
    $row = $result->fetch_assoc();
    $displayName = "Welcome, ".$row['lpa_user_firstname']." ".$row['lpa_user_lastname'];
  } else {
    header("location: login.php");
  }
}

if(isset($adminChk) == true) {
	if(!$isAdmin)
	{
		header("location: index.php");
	}
}

if(isset($clientChk) == true) {
    if($authClient) {
        openDB();
        $query = "SELECT * FROM lpa_clients WHERE lpa_client_ID = '$authClient' LIMIT 1";
        $result = $db->query($query);
        $row = $result->fetch_assoc();
        $displayName = "Welcome, ".$row['lpa_client_firstname']." ".$row['lpa_client_lastname'];
    } else {
        header("location: CustomerLogin.php");
    }
}

/**
 * Connect to database Function
 * - Connect to the local MySQL database and create an instance
 */
function openDB() {
  global $db;
  if(!is_resource($db)) {
    /* Conection String eg.: mysqli("localhost", "lpaecomms", "letmein", "lpaecomms")
     *   - Replace the connection string tags below with your MySQL parameters
     */
    $db = new mysqli(
      "localhost",
      "lpa_ecomms",
      "5XmvHX4djjzQRMRS",
      "lpa_ecomms"
    );
    if ($db->connect_errno) {
      echo "Failed to connect to MySQL: (" .
        $db->connect_errno . ") " .
        $db->connect_error;
    }
  }
}

/**
 * Close connection to database Function
 * - Close a connection to the local MySQL database instance
 * @throws Exception
 */
function closeDB() {
  global $db;
  try {
    if(is_resource($db)) {
      $db->close();
    }
  } catch (Exception $e)
  {
    throw new Exception( 'Error closing database', 0, $e);
  }
}


/**
 * System Logout check
 *
 *  - Check if the logout button has been clicked, if so kill session.
 */
if(isset($_REQUEST['killses']) == "true") {
  $_SESSION = array();
  if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
      $params["path"], $params["domain"],
      $params["secure"], $params["httponly"]
    );
  }
  session_destroy();
  header("location: login.php");
}




/**
 *  Build the page header function
 */
function build_header() {
  global $displayName;

  include 'header.php';
}


/**
 * Build the Navigation block
 */
function build_navBlock() { 
	isset($_SESSION["isAdmin"])?
		$isAdmin = $_SESSION["isAdmin"] :
		$isAdmin = "";
	?>
    <div id="navBlock">
		<div id="navHeader">MAIN MENU</div>
		<div class="navItem" onclick="navMan('index.php')">HOME</div>
		<div class="navItem" onclick="navMan('stock.php')">STOCK MANAGEMENT</div>
		<div class="navItem" onclick="navMan('sales.php')">SALES MANAGEMENT</div>
		<div class="navItem" onclick="navMan('client.php')">CLIENTS MANAGEMENT</div>
		<div class="navItem" onclick="navMan('customerLogin.php')">CUSTOMER LOGIN</div>
		
		 <?PHP
      if($isAdmin) {
		?>
		<div class="menuSep"></div>      

		<div class="adminView" onclick="navMan('users.php')">USERS MANAGEMENT</div>

		<?PHP } ?>
	  <div class="navItem" onclick="navMan('login.php?killses=true')">LOGOUT</div>
    </div>
<?PHP
}

function build_ClientnavBlock() {
    ?>

    <div id="navBlock">
        <div id="navHeader">MAIN MENU</div>
        <div class="navItem" onclick="navMan('indexClient.php')">HOME</div>
        <div class="navItem" onclick="navMan('mashup.php')">MASHUP</div>
        <div class="navItem" onclick="navMan('products.php')">PRODUCT CATALOG</div>
        <div class="navItem" onclick="navMan('cart.php')">CART</div>
        <div class="navItem" onclick="navMan('login.php?killses=true')">USER PAGE</div>
        <div class="navItem" onclick="navMan('CustomerLogin.php?killses=true')">LOGOUT</div>

    </div>
    <?PHP
}
function build_footer() {
  include 'footer.php';
}
?>

<?PHP

/**
 * Create an ID
 * - Create a unique id.
 *
 * @param string $prefix
 * @param int $length
 * @param int $strength
 * @return string
 */
function gen_ID($prefix='',$length=3, $strength=0) {
  $final_id='';
  for($i=0;$i< $length;$i++)
  {
    $final_id .= mt_rand(0,9);
  }
  if($strength == 1) {
    $final_id = mt_rand(100,999).$final_id;
  }
  if($strength == 2) {
    $final_id = mt_rand(10000,99999).$final_id;
  }
  if($strength == 4) {
    $final_id = mt_rand(1000000,9999999).$final_id;
  }
  return $prefix.$final_id;
}

/**
 *  Build the page footer function
 */

function lpa_log($log) {
	$log_filename = 'lpalog';
	if (!file_exists($log_filename)) {
		mkdir($log_filename, 0777, true);
		
		file_put_contents($log_filename.'\log.txt');
	}
	$userIP = 'LOG - IP Address: ';
	$ip = $_SERVER['REMOTE_ADDR'];
	$time = date ('d/m/Y H:i:s');
	$spacer = '-----------------------';
	
	$contents = file_get_contents($log_filename.'\log.txt');
	$contents .= "$userIP\t$ip\r$time\t$log\r$spacer\r";
	
	file_put_contents($log_filename.'\log.txt', $contents, FILE_APPEND);
}

function better_crypt($input, $rounds = 10)
  {
    $salt = "";
    $salt_chars = array_merge(range('A','Z'), range('a','z'), range(0,9));
    for($i=0; $i < 22; $i++) {
      $salt .= $salt_chars[array_rand($salt_chars)];
    }
    return crypt($input, sprintf('$2y$%02d$', $rounds) . $salt);
  }

?>