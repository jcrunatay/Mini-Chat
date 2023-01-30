<?php 
include "core.php";	
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Module4-Lab2</title>
  <link rel="stylesheet" href="style.css">
  <!-- Latest compiled and minified CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</head>
<style>
	.div{
		float: left;
		position: relative;
	}

</style>
<body class="bg-dark">



	<div class="container bg-secondary div-container p-2">
		<h1 class="display-1 text-center "><b> Mini-Chat</b></h1>

		<div class="row">

			<?php if(!isset($_SESSION['user'])):?>
			<div class="col-md-4 border rounded border-dark border-2 m-auto">
			<form action="" method="post" role ="form" class="p-2">
				  <div class="mb-3">
				    <label for="username" class="form-label">Username</label>
				    <input type="text" class="form-control" id="username" name="username" required>
				  </div>
				  <div class="mb-3">
				    <label for="password" class="form-label">Password</label>
				    <input type="password" class="form-control" id="password" name="password" required>
				  </div>
				  <p style="color:rgba(200, 0, 0, 1);" class="lead"><b><?= $err ?? "" ?></b></p>
				  <input type="submit" class="btn btn-primary"  name="login" value="Login">
				  <!--input type="submit" class="btn btn-primary"  name="register" value="Register"-->
				  <button id="register" type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="resetform()">Register</button>
			</form>
			</div>


			<!-- SHOW THE PROFILE OF THE USER IF LOG IN IS SUCCESS-->
	<?php else: ?>
			<!--div class="row"-->
				<div class="col-md-4 border rounded border-dark border-2 m-auto text-center">
							<h5 class="display-6" style="font-size:25px;" >Welcome <?php if(isset($_SESSION['user'])){ echo $_SESSION['user']['username'];}?></h5>

							<img class="profile-avatar" src="<?php if(isset($_SESSION['user'])){ echo 'upload/'.$_SESSION['user']['avatar'];}?>">

							<form action="" method="post" role ="form" class="p-2">				 
					  			<input type="submit" class="btn btn-primary float-end m-2 form-control"  name="logout" value="Logout">
		 					</form>

				</div>
			<?php endif; ?>
		  </div>
		<!--/div-->


		<!-- PAGE WHEN USER IS LOGGED -->
		<div class="row justify-content-center">

				<div class="col-md-5 sendMessage-Div" >
					<form action="" method="post" role ="form" class="p-3">
							<h4 style="font-size:30px;" class="display-6">Send a Message</h4>
						  <div class="mb-3">
						    <textarea class="textarea" id="message" name="message" <?php if(!isset($_SESSION['user'])){echo "disabled";}?>  ></textarea>
						  </div>
						  <input type="submit" class="btn btn-primary float-end" id="btn-send"  name="send" value="Send" <?php if(!isset($_SESSION['user'])){echo "disabled";}?> >
					</form>
				</div>

				<div class="col-md-5 allMessages-Div p-3" >
					<h4 style="font-size:30px;" class="display-6">Public Group Chat <?php if(!isset($_SESSION['user'])){
					 echo "<span style='font-size:15px;font-weight:normal;'> (Log in to join the public group chat)</span>";
					}
					?></h4>

					<!-- DISPLAY ALL THE MASSAGES FROM OLD TO NEW MESSAGES -->
					<div class="display-message-Div" style="display: block;">

						<hr>
						<?php
						$query    = $db->query( "SELECT * FROM posts ORDER BY id ASC" );
       			$users = $query->fetchAll( PDO::FETCH_ASSOC );
       			//var_dump($users);
       			foreach($users as $user){    				


       				$imgsrc = 'upload/' . $user['avatar'];

       				$str = $user['comment'];
       				$newword = wordwrap($str,50,"<br>\n&emsp;&emsp;&emsp;&emsp;",true);

       				
       				//create p tag
       				echo "<p class='lead' style='font-size:15px;'>";

       				echo "<span>&nbsp; <img src ='$imgsrc' class='post-avatar'></span> " . $user['username']. ": <br> &emsp;&emsp;&emsp;&emsp;" . $newword ;
       		
       				//close p tag
       				echo "</p>";
       				
       				echo"<hr>";

			
}
       			
						?>


					</div>
				</div>

		</div>


	</div> <!-- END OF DIV CONTAINER-->



	<!-- Modal -- REGISTRATION POP UP-->
	<div class="modal fade" id="staticBackdrop" data-bs-keyboard="true" tabindex="-1">
	  <div class="modal-dialog">
	    <div class="modal-content bg-secondary">	
		    <div class="modal-header ps-5">    
		    	<h3 class="modal-title display-6" id="staticBackdropLabel">Registration Form</h3>
		        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="resetform()"></button>	
		    </div>
		    <form action="" method="post" role ="form" class="p-5" enctype="multipart/form-data" onsubmit="return validate();" id="myForm">
				  <div class="mb-3">
				    <label for="PopUpusername" class="form-label">Username</label><p style='color: rgba(210, 0, 0, 1.0);' class="err-username"><p>
				    <input type="text" class="form-control" id="PopUpusername" name="username" >
				  </div>
				  <div class="mb-3">
				    <label for="PopUppassword" class="form-label">Password</label><p style='color: rgba(210, 0, 0, 1.0);' class="err-password"><p>
				    <input type="password" class="form-control" id="PopUppassword" name="password">
				  </div>
				  <div class="mb-3">
				    <label for="PopUpcpassword" class="form-label">Password(confirmation)</label><p style='color: rgba(210, 0, 0, 1.0);' class="err-cpassword"><p>
				    <input type="password" class="form-control" id="PopUpcpassword" name="cpassword">
				  </div>
				  <div class="mb-3">
				    <label for="PopUpavatar" class="form-label">Avatar</label><p style='color: rgba(240, 0, 0, 1.0);' class="err-avatar"><p>
				    <input type="file" class="form-control" id="PopUpavatar" name="avatar">
				  </div>
				  <br>
				  <input type="submit" class="btn btn-primary"  name="addUser" id="addUser">
				  <input type="reset"  class="btn btn-primary"  name="register" value="Reset" onclick="resetErrorText()">
			</form>	    	
	    </div>
	  </div>
	</div>

	


	<script type="text/javascript">


		function resetform(){
			resetErrorText();
		  document.getElementById("myForm").reset();
		}

		function resetErrorText(){
			  document.querySelector(".err-username").innerHTML ="";
		    document.querySelector(".err-password").innerHTML ="";
		  	document.querySelector(".err-cpassword").innerHTML ="";
				document.querySelector(".err-avatar").innerHTML ="";
		}

		
		function validate(){

			   var error="";
			   var errCounter = 0;
				 var username = document.getElementById( "PopUpusername" );

				 //To check if username is empty

				 if( username.value.trim() == "" )
				 {
				  errCounter ++;
				  error = " Please fill out username field ";
				  document.querySelector(".err-username").innerHTML = error;
				 }else{

				 	 //To check if username has more than 8 characters

					 		if( username.value.trim().length < 8 )
					 {
					 	errCounter ++;
					  error = " Username must be atleast 8 Characters. ";
					  document.querySelector( ".err-username" ).innerHTML = error;
					 }else{
					 		  document.querySelector( ".err-username" ).innerHTML = "";
					 }
				 }


				 var password = document.getElementById( "PopUppassword" );

				 //To check if password is empty

				 if( password.value.trim()  == "" )
				 {
				  errCounter ++;
				  error = " Please fill out password field ";
				  document.querySelector(".err-password").innerHTML = error;
				 }else{

				 	//To check if password has atleast 8 character

					 		if( password.value.trim().length < 8 )
					 {
					 	errCounter ++;
					  error = " Username must be atleast 8 Characters ";
					  document.querySelector( ".err-password" ).innerHTML = error;
					 }else{
					 	document.querySelector( ".err-password" ).innerHTML = "";
					 }
				 }


				 var cpassword = document.getElementById( "PopUpcpassword" );

				 //To check if confirmation password is empty

				 if( cpassword.value == ""  )
				 {
				 	errCounter ++;
				  error = " Please fill out password confirmation field ";
				  document.querySelector( ".err-cpassword" ).innerHTML = error;
				 }else{

				  	//To check if passwords match

				 		if ( password.value !== cpassword.value) {
				 					errCounter ++;
							 		error = " Passwords doesn't match ";
				 					document.querySelector( ".err-cpassword" ).innerHTML = error;
				 		}else{
				 					document.querySelector( ".err-password" ).innerHTML = "";
				 		}

				 }
		 
					 var avatar = document.getElementById('PopUpavatar');
					 var FileUploadPath = avatar.value;

					//To check if user upload any file
					        if (FileUploadPath == '') {
					        	  errCounter ++;
					            document.querySelector( ".err-avatar" ).innerHTML = "Please upload an image";

					        } else {
					            var Extension = FileUploadPath.substring(
					                    FileUploadPath.lastIndexOf('.') + 1).toLowerCase();

					//The file uploaded is an image
					if (Extension == "gif" || Extension == "png"  || Extension == "jpeg" || Extension == "jpg") {

					                	document.querySelector( ".err-avatar" ).innerHTML = "";
					            } 

					//The file upload is NOT an image
					else {			      errCounter ++;        
					                 document.querySelector( ".err-avatar" ).innerHTML = "Photo only allows file types of GIF, PNG, JPG, JPEG ";

					            }
					        }
 
				 if (errCounter == 0) 
				 {
				 	alert("You have successful registered \nYou may now log in to your account to join public group chat");
				 	return true;
				 }
				 else
				 {
				 	return false;
				 }

		}

	</script>
</body>
</html>