<?php

//import database
include("../connection.php");

if ($_POST) {
    //print_r($_POST);
    $result = $database->query("select * from webuser");
    $name = $_POST['name'];
    $oldemail = $_POST["oldemail"];
    $nic = $_POST['nic'];
    $spec = $_POST['spec'];
    $email = $_POST['email'];
    $tele = $_POST['Tele'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    // $id = $_POST['id00'];
    $id = htmlspecialchars($_POST['id00'], ENT_QUOTES, 'UTF-8');

    if ($password == $cpassword) {
        $error = '3';
        // $result = $database->query("select doctor.docid from doctor inner join webuser on doctor.docemail=webuser.email where webuser.email='$email';");

        $query = "SELECT doctor.docid FROM doctor INNER JOIN webuser ON doctor.docemail = webuser.email WHERE webuser.email = ?";
        $stmt = $database->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        //$resultqq= $database->query("select * from doctor where docid='$id';");
        // if ($result->num_rows == 1) {
        //     $id2 = $result->fetch_assoc()["docid"];
        // } else {
        //     $id2 = $id;
        // }

        // echo $id2 . "jdfjdfdh";

        if ($result->num_rows == 1) {
            $id2 = htmlspecialchars($result->fetch_assoc()["docid"], ENT_QUOTES, 'UTF-8');
        } else {
            $id2 = $id;
        }
        echo htmlspecialchars($id2 . "jdfjdfdh", ENT_QUOTES, 'UTF-8');

        if ($id2 != $id) {
            $error = '1';
            //$resultqq1= $database->query("select * from doctor where docemail='$email';");
            //$did= $resultqq1->fetch_assoc()["docid"];
            //if($resultqq1->num_rows==1){

        } else {

            //$sql1="insert into doctor(docemail,docname,docpassword,docnic,doctel,specialties) values('$email','$name','$password','$nic','$tele',$spec);";
            // $sql1 = "update doctor set docemail='$email',docname='$name',docpassword='$password',docnic='$nic',doctel='$tele',specialties=$spec where docid=$id ;";
            // $database->query($sql1);

            // $sql1 = "update webuser set email='$email' where email='$oldemail' ;";
            // $database->query($sql1);

            // echo $sql1;

            $email = mysqli_real_escape_string($database, $email);
            $name = mysqli_real_escape_string($database, $name);
            $password = mysqli_real_escape_string($database, $password);
            $nic = mysqli_real_escape_string($database, $nic);
            $tele = mysqli_real_escape_string($database, $tele);
            $spec = mysqli_real_escape_string($database, $spec);
            
            // $sql1 = "UPDATE doctor SET docemail='$email', docname='$name', docpassword='$password', docnic='$nic', doctel='$tele', specialties='$spec' WHERE docid=$id ;";
            // $database->query($sql1);

            $sql1 = "UPDATE doctor SET docemail = ?, docname = ?, docpassword = ?, docnic = ?, doctel = ?, specialties = ? WHERE docid = ?";
            $stmt = $database->prepare($sql1);
            $stmt->bind_param("ssssssi", $email, $name, $password, $nic, $tele, $spec, $id);
            $stmt->execute();
            
            $oldemail = mysqli_real_escape_string($database, $oldemail);
            $sql1 = "UPDATE webuser SET email='$email' WHERE email='$oldemail' ;";
            $database->query($sql1);
            
            echo $sql1;

            //echo $sql2;
            $error = '4';
        }
    } else {
        $error = '2';
    }
} else {
    //header('location: signup.php');
    $error = '3';
}


header("location: settings.php?action=edit&error=" . $error . "&id=" . $id);
?>



</body>

</html>