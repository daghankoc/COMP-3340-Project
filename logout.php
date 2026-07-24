<?php 
    include 'header.php'; 
    //destroy session
    session_destroy();
?>
<script>
    //redirect to login page
  window.location.href = 'login.php';
</script>
