<?php

    session_start();
    session_destroy();
    require('header.php');    
?>

<p>You have logged out.</p>
<a href="index.php">Back to main page</a>

<?php require('footer.php'); ?>