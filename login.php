<?php
    $msg = '';  //to store error messages
	
    if(isset($_POST['username'],$_POST['password'])){
 
        /*** You can change username & password ***/
        $user = array(
                        "user" => "Leandro",
                        "pass"=>"leandro"          
                );
        $username = $_POST['username'];
        $pass = $_POST['password'];
        if($username == $user['user'] && $pass == $user['pass']){
			$msg = '';
            session_start();
            $_SESSION['logged_user'] = $username;
            header("Location: home.php");
            exit();
        }else{
            $msg = 'Error: Invalid Login';   //assign an error message
			include('index.html');  //include the html code(ie. to display the login form and other html tags)
        }
    }
	else{
            $msg = 'Error: Invalid Login';   //assign an error message
			include('index.html');  //include the html code(ie. to display the login form and other html tags)
        }
?>