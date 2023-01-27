<?php

    //learn from w3schools.com

    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='p'){
            header("location: ../login.php");
        }else{
            $useremail=$_SESSION["user"];
        }

    }else{
        header("location: ../login.php");
    }
    

    //import database
    include("../connection.php");
    $sqlmain= "select * from patient where pemail=?";
    $stmt = $database->prepare($sqlmain);
    $stmt->bind_param("s",$useremail);
    $stmt->execute();
    $userrow = $stmt->get_result();
    $userfetch=$userrow->fetch_assoc();
    $userid= $userfetch["pid"];
    $username=$userfetch["pname"];

    
    if($_POST){
        if(isset($_POST["booknow"])){
            $apponum = mysqli_real_escape_string($database, $_POST["apponum"]);
            $scheduleid = mysqli_real_escape_string($database, $_POST["scheduleid"]);
            $date = mysqli_real_escape_string($database, $_POST["date"]);
            $scheduleid = mysqli_real_escape_string($database, $_POST["scheduleid"]);
            $userid = mysqli_real_escape_string($database, $userid);

            $sql2 = "insert into appointment(pid,apponum,scheduleid,appodate) values (?,?,?,?)";
            $stmt = $database->prepare($sql2);
            $stmt->bind_param("iiis", $userid, $apponum, $scheduleid, $date);
            $stmt->execute();
            header("location: appointment.php?action=booking-added&id=".$apponum."&titleget=none");
        }
    }

 ?>