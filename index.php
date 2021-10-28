<?PHP

  $authChk = true;
  require('app-lib.php');
  
  build_header($displayName);
?>

  <?PHP 
  build_navBlock(); 
  ?>
  
  <div id="content">
    Welcome to LPA's homepage!
  </div>
  
  <script>
  </script>
  
<?PHP
build_footer();
?>