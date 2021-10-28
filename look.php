<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html lang="en">
<head>
  <title>jQuery Lookup Box</title>
  <script src="js/jquery-1.10.2.min.js"></script>
  <script src="js/jquery-ui.min.js"></script>
  <script src="js/jquery.lookupbox.js"></script>
  <link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css" />
  <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
  <fieldset>
    <legend><b>Basic Usage</b></legend>
    <p>A basic usage of lookup box. For the loading indicator we just use the "<b>Loading...</b>" text.</p>
    <form action="" method="post">
      <table>
        <tr>
          <td>Client ID</td>
          <td>:</td>
          <td>
            <input type="text" name="clientID" value="" />
            <input type="button" value="..." id="lookup1" />
          </td>
        </tr>
        <tr>
          <td>Client name</td>
          <td>:</td>
          <td><input type="text" name="clientName" value="" /></td>
        </tr>
        <tr>
          <td>Client address</td>
          <td>:</td>
          <td><input type="text" name="clientaddress" value="" /></td>
        </tr>
      </table>
      <br/>
      <input type="submit" value="SAVE" />
    </form>
    <script>
    $(document).ready(function () {
      $("#lookup1").lookupbox({
        title: 'Search Client',
        url: 'searchClient.php?chars=',
        imgLoader: 'Loading...',
        width: 600,
        onItemSelected: function(data){
          $('input[name=clientID]').val(data.lpa_client_ID);
          $('input[name=clientName]').val(data.lpa_client_name);
          $('input[name=clientaddress]').val(data.lpa_client_address);
        },
        tableHeader: ['Client ID', 'Client name', 'Client address']
      });
    });
    </script>
</body>
</html>
