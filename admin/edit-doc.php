
    <?php
    
    

    //import database
    include("../connection.php");



    if($_POST){
        //print_r($_POST);
        $result= $database->query("select * from webuser");
        $name=$_POST['name'];
        $nic=$_POST['nic'];
        $oldemail=$_POST["oldemail"];
        $spec=$_POST['spec'];
        $email=$_POST['email'];
        $tele=$_POST['Tele'];
        $password=$_POST['password'];
        $cpassword=$_POST['cpassword'];
        $id=htmlspecialchars($_POST['id00'], ENT_QUOTES);
        
        if ($password==$cpassword){
            $error='3';
            $stmt= $database->query("select doctor.docid from doctor inner join webuser on doctor.docemail=webuser.email where webuser.email=?;");
            mysqli_stmt_bind_param($stmt, "ss", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            //$resultqq= $database->query("select * from doctor where docid='$id';");
            if($result->num_rows==1){
                $id2=$result->fetch_assoc()["docid"];
            }else{
                $id2=$id;
            }
            
            echo $id2."jdfjdfdh";
            if($id2!=$id){
                $error='1';
                //$resultqq1= $database->query("select * from doctor where docemail='$email';");
                //$did= $resultqq1->fetch_assoc()["docid"];
                //if($resultqq1->num_rows==1){
                    
            }else{

                //$sql1="insert into doctor(docemail,docname,docpassword,docnic,doctel,specialties) values('$email','$name','$password','$nic','$tele',$spec);";
                $sql1="update doctor set docemail=?,docname=?,docpassword=?,docnic=? ,doctel=?,specialties=? where docid=? ;";
                $stmt = $database->mysqli_prepare($sql1);
                mysqli_stmt_bind_param($stmt, "ss", $email, $name, $password, $nic, $tele, $spec, $id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                
                $sql1="update webuser set email='$email' where email='$oldemail' ;";
                $database->query($sql1);
                //echo $sql1;
                //echo $sql2;
                $error= '4';
                
            }
            
        }else{
            $error='2';
        }
    
    
        
        
    }else{
        //header('location: signup.php');
        $error='3';
    }
    

    header("location: doctors.php?action=edit&error=".$error."&id=".$id);
    ?>
    
   

</body>
</html>
