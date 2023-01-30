<?php
	session_start();

	//INCLUDE THE DATABASE CONNECTION
    include "dbConnection.php";

    //REGISTER A NEW USER
    if ( isset( $_POST['addUser'])) {

        $newUser =array("username" => $_POST['username'],"password" => md5($_POST['password']),"avatar" => basename($_FILES['avatar']['name']));
        //query to add into database
        $query = $db->prepare( "INSERT INTO `users` (`username`, `password`, `avatar`) VALUES (:username, :password, :avatar);" );
        $query->execute($newUser);

        //as we register we should also upload the photo to the file
        $target_dir = "upload/";
        $target_file = $target_dir . basename($_FILES["avatar"]["name"]);

        //MOVE THE FILE TO UPLOAD FOLDER
        move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file);  
        header("Location: lab2.php");    
    }


    //IF USER LOG IN
    $LoginSuccess = false;
    if(isset($_POST['login'])){
        //query for a single user
        //$query = $db->query( "SELECT * FROM users WHERE id = 5");
        //$singleUser = $query->fetch( PDO::FETCH_ASSOC );
        //var_dump($singleStudent);

        //query to get all the users
        $query    = $db->query( "SELECT * FROM users ORDER BY id DESC" );
        $users = $query->fetchAll( PDO::FETCH_ASSOC );

        //var_dump($users);

        foreach($users as $user){
            if($user['username'] == $_POST['username'] AND $user['password'] == md5($_POST['password'])){
                //echo "User exist !";
                $_SESSION['user'] = $user;
                $LoginSuccess = true;
                $err = "";
                break;
            }else{
                $err = "Sorry, Account entered doesn't exist";
            }
        }      
    }


   //ACTION FOR LOGOUT BUTTON 
     if(isset($_POST['logout'])){
        unset($_SESSION['user']);
     }


   //ACTION FOR SEND MESSAGE BUTTON
   if(isset($_POST['send'])){

        //unset($_POST['send']);
        $newPost = array("username" => $_SESSION['user']['username'],"avatar"=> $_SESSION['user']['avatar'],'comment' => $_POST['message']);

        //query to add into database
        $query = $db->prepare( "INSERT INTO `posts` (`username`,`avatar`,`comment`) VALUES (:username,:avatar,:comment);");
        $query->execute($newPost);   
        header("Location: lab2.php");      
   }  

    
?>