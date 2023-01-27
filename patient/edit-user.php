<?php
    
    //import database
    include("../connection.php");

    if($_POST){
        $name = mysqli_real_escape_string($database, $_POST['name']);
        $nic = mysqli_real_escape_string($database, $_POST['nic']);
        $oldemail = mysqli_real_escape_string($database, $_POST["oldemail"]);
        $address = mysqli_real_escape_string($database, $_POST['address']);
        $email = mysqli_real_escape_string($database, $_POST['email']);
        $tele = mysqli_real_escape_string($database, $_POST['Tele']);
        $password = mysqli_real_escape_string($database, $_POST['password']);
        $cpassword = mysqli_real_escape_string($database, $_POST['cpassword']);
        $id = mysqli_real_escape_string($database, $_POST['id00']);

        if ($password==$cpassword){
            $error='3';
            $sqlmain= "select patient.pid from patient inner join webuser on patient.pemail=webuser.email where webuser.email=?;";
            $stmt = $database->prepare($sqlmain);
            $stmt->bind_param("s",$email);
            $stmt->execute();
            $result = $stmt->get_result();
       
            if($result->num_rows==1){
                $id2=$result->fetch_assoc()["pid"];
            }else{
                $id2=$id;
            }
            

            if($id2!=$id){
                $error='1';
               
            }else{


                $sql1 = $database->prepare("update patient set pemail=?, pname=?, ppassword=?, pnic=?, ptel=?, paddress=? where pid=?");
                $sql1->bind_param("ssssssi", $email, $name, $password, $nic, $tele, $address, $id);
                $sql1->execute();

                $sql1 = $database->prepare("update webuser set email=? where email=?");
                $sql1->bind_param("ss", $email, $oldemail);
                $sql1->execute();
                
                $error= '4';
                
            }
            
        }else{
            $error='2';
        }
    
    
        
        
    }else{
        //header('location: signup.php');

        $error='3';
    }
    

    header("location: settings.php?action=edit&error=".$error."&id=".$id);
    ?>
    
   

</body>
</html>