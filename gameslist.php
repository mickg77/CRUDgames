<?php
    require('functions.php');
    
    if(loginCheck($conn)){
        
        require('header.php');
        displayAll($conn);
        createRecord($conn);
        require('footer.php');
        
        if(isset($_GET["happening"])){
            
            $myaction=  $_GET["happening"];
            $myid=      $_GET["gameid"];
            
            if($myaction=="delete"){
                
                deleteRecord($conn,$myid);
            }
            
            if($myaction=="update"){
                updateSelect($conn);
            }
        }
        
        if(isset($_GET["update"])){
            updateRecords($conn);
        }
        
   
    }

    else {
        header('Location: index.php');
    }
?>