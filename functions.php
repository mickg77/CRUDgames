<?php 

    $servername= "localhost";
    $username="mickg77";
    $password="";
    
    try {
        $conn = new PDO("mysql:host=$servername;dbname=gamesdb",$username, $password);
        
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        //echo "Connected Successfully";
    
    }
    
    catch(PDOException $e) {
        echo "Connection Failed" .$e->getMessage();
    }
  
    function displayAll($conn){
    
        $stmt=$conn->prepare("SELECT * FROM games"); 
        $stmt->execute();
        
        if($stmt->rowCount()>0){
        
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
                //output the row
                
                echo'   <p>ID : '.$row["gameid"].'
                        Title :'.$row["title"].'
                        <a href="?gameid='.$row["gameid"].'&happening=delete">Delete</a>
                        <a href="?gameid='.$row["gameid"].'&happening=update">Update</a></p>';
   
            }
        }
        
        else {
            echo "<p> No records found</p>";
        }

    
    }//end of displayAll
    
    function loginCheck($conn){

            session_start();
            //check if login is achieved 
            //get variables from form 
            $username=$_POST['namebox'];
            $password=$_POST['passwordbox'];
            
            $stmt= $conn->prepare("SELECT * FROM users WHERE 
            username =:username AND password=:password");
            $stmt->bindParam(':username',$username);
            $stmt->bindParam(':password',$password);
            $stmt->execute();
            
            if(($stmt->rowCount()>0) ||($_SESSION['admin'])){
                echo "<p>Login successful</p>";
                $_SESSION['admin']=true;
                return true;
            }
            
            else {
                echo "<p>no record exists</p>";
                return false;
            }
        
        
        }//end of loginCheck
    
    function updateSelect($conn){
        
        $gameid=$_GET['gameid'];
        $stmt=$conn->prepare("SELECT * FROM games WHERE gameid =:gameid"); 
        $stmt->bindParam(":gameid", $gameid);
        $stmt->execute();
        
        if($stmt->rowCount()>0){
        
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
                //output the row
                
                echo '
                <form name="update" action="" method="GET">
                <input name="gameid" type="hidden" value="'.$row["gameid"].'">
                <input name="titlebox" value="'.$row["title"].'">
                <input name="ratingbox" value="'.$row["rating"].'">
                <input name="genrebox" value="'.$row["genre"].'">
                <input name="pricebox" value="'.$row["price"].'">
                <input type="submit" name="update">
            
                </form>';
            }
        }
        
        }//end of updateSelect
        
    function updateRecords($conn){
    
          
    
            $gameid     = $_GET['gameid'];
            $title      = $_GET['titlebox'];
            $rating     = $_GET['ratingbox'];
            $genre      = $_GET['genrebox'];
            $price      = $_GET['pricebox'];
            
            $stmt=$conn->prepare("UPDATE games
                                    SET title =:title, 
                                    rating    =:rating,
                                    genre     =:genre,
                                    price     =:price
                                    WHERE gameid =:gameid;");
            
            $stmt->bindParam(":gameid", $gameid);
            $stmt->bindParam(":title", $title);
            $stmt->bindParam(":rating", $rating);                        
            $stmt->bindParam(":genre", $genre);
            $stmt->bindParam(":price", $price);
            $stmt->execute();
            
             if($stmt->execute()){
                       ?>
                       <script>alert("Record Amended");location.href="index.php";</script>
                       <?php
             }
             else {
                 ?>
                 <script>alert("Fail")</script>
                 <?php
             }
    }
         
    function deleteRecord($conn,$id){
               
                 
                 $stmt = $conn->prepare("DELETE FROM games WHERE gameid =:myID");
                 $stmt->bindParam(":myID",$id);
                 
                 $stmt->execute();
                 
    }//end of deleteRecord
             
    function createRecord($conn){
                 
                  session_start();
    
                  
                        echo '<h1>Add a record</h1>';
                        ?>
                        <form name="addrecord" action="" method="POST">
                            <label>Title :</label><input type="text" name="titlebox"><br/>
                            <label>Rating :</label><input type="text" name="ratingbox"><br/>
                            <label>Genre :</label><input type="text" name="genrebox"><br/>
                            <label>Price :</label><input type="text" name="pricebox"><br/>
                            <input type="submit" name="submitadd">
                        </form>
                        
                        <?php
                          
                           if(isset($_POST['submitadd'])){
                               
                               $title=$_POST['titlebox'];
                               $rating=$_POST['ratingbox'];
                               $genre=$_POST['genrebox'];
                               $price=$_POST['pricebox'];
                               $stmt=$conn->prepare("
                               INSERT INTO games (title, rating, genre, price)
                               VALUES (:title, :rating, :genre, :price);");
                               
                               $stmt->bindParam(':title',$title);
                               $stmt->bindParam(':rating',$rating);
                               $stmt->bindParam(':genre',$genre);
                               $stmt->bindParam(':price',$price);
                               
                               if($stmt->execute()){
                                   ?>
                                   <script>alert("Record Added");location.href="index.php";</script>
                                   <?php
                               }
                           }
             }//end of createRecord
?>
                   
                






