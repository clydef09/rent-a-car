<?php

// require_once('connection.php');
// if(isset($_POST['regs']))
// {
//     $fname=mysqli_real_escape_string($conn,$_POST['fname']);
//     $lname=mysqli_real_escape_string($conn,$_POST['lname']);
//     $email=mysqli_real_escape_string($conn,$_POST['email']);
//     $lic=mysqli_real_escape_string($conn,$_POST['lic']);
//     $ph=mysqli_real_escape_string($conn,$_POST['ph']);
//     $id=mysqli_real_escape_string($conn,$_POST['id']);
//     $pass=mysqli_real_escape_string($conn,$_POST['pass']);

//     if(empty($fname)|| empty($lname)|| empty($email)|| empty($lic)|| empty($ph)|| empty($id)|| empty($pass))
//     {
//         echo 'Please Fill in the place';
//     }
  
       
//         $sql="insert into users (FNAME,LNAME,EMAIL,LIC_NUM,PHONE_NUMBER,USER_ID,PASSWORD) values('$fname','$lname','$email','$lic',$ph,'$id','$pass')";
//         $result = mysqli_query($conn,$sql);

//         if($result){
//             echo 'YourRecordidsaves';
//         }
//         else{
//             echo 'pleasecheckconnecion';
//         }
// }
session_start();
$value = $_SESSION['rdate'];
echo $value;



?>