<?php
    require ("functions.php");
    
    if(loginCheck($conn)){
        displayAll($conn);
    }

?>