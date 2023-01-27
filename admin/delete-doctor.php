<?php

session_start();

if(isset($_SESSION["user"])){
    if(($_SESSION["user"])=="" or $_SESSION['usertype']!='a'){
        header("location: ../login.php");
    }

}else{
    header("location: ../login.php");
}

if($_GET){
    include("../connection.php");
    $id = $_GET["id"];
    $stmt = $database->prepare("SELECT * FROM doctor WHERE docid = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $email = $row["docemail"];
    $stmt = $database->prepare("DELETE FROM webuser WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt = $database->prepare("DELETE FROM doctor WHERE docemail = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    header("location: doctors.php");
}


?>