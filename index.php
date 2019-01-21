<?php
    require('functions.php');
    if(loginCheck($conn)){
        
        header('Location: gameslist.php');
        
    }
    
    else {
    
        require('header.php');
        
        ?>    
        <form name="login" action="" method="POST">
            <label>Name</label><input type="text" name="namebox" length="30">
            <br/>
            <label>Password</label><input type="password" name="passwordbox" length="30">
            <br/>
            <input type="submit" name="submit">
            </form>
    
        <?php    
        require('footer.php');
    }
?>