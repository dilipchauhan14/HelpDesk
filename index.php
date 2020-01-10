fvf
<?php
//Singup page of the HelpDesk
// define variables and set to empty values
$nameErr = $emailErr = $usernameErr = $passErr = $cpassErr=$collegeErr="";
$name = $email = $username = $pass= $cpass =$college="";$aaa="";$matchErr="";
$x=$y=0;$loginErr="";
if ($_SERVER["REQUEST_METHOD"] == "POST")
 {
     if (empty($_POST["name"]))
      {
         $nameErr = "Name is required";
         $y=$y+1;
      } 
     else 
      {
         $name = test_input($_POST["name"]);
         // check if name only contains letters and whitespace
         if (!preg_match("/^[a-zA-Z ]*$/",$name)) 
         {
           $nameErr = "Only letters and white space allowed";
           $y=$y+1;
         }
      }
  
     if (empty($_POST["email"])) 
      {
         $emailErr = "Email is required";
         $y=$y+1;
      } 
     else
     {
         $email = test_input($_POST["email"]);
         // check if e-mail address is well-formed
         if (!filter_var($email, FILTER_VALIDATE_EMAIL))
          {
            $emailErr = "Invalid email format";
            $y=$y+1;
          }
     }
    if (empty($_POST["user"]))
     {
        $usernameErr = "username is required";
        $y=$y+1;
     } else 
     {
        $username = test_input($_POST["user"]);
     } 
     if (empty($_POST["pass"])) 
      {
        $passErr = "passsword is required";
        $y=$y+1;
      } 
     else 
      {
        $pass = test_input($_POST["pass"]);
      }   
     if (empty($_POST["cpass"])) 
      {
        $cpassErr = "passsword is required";
        $y=$y+1;
      } 
     else 
      {
        $cpass = test_input($_POST["cpass"]);
      } 
     if (empty($_POST["college"])) 
      {
        $collegeErr = "college is required";
        $y=$y+1;
      } 
     else 
      {
        $college = test_input($_POST["college"]);
      } 
 
 }
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname="adp";
// Create connection
$db= new mysqli($servername, $username, $password,$dbname);
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
else
 $aaa="connnected";
    //echo "Connected successfully";
if(isset($_POST['sign_up']))
{
      $clg="other";
      $name=$_POST["name"];
      $email=$_POST["email"];
      $username=$_POST["user"];
      $pass=$_POST["pass"];
      $cpass=$_POST["cpass"];
      $college=$_POST["college"];
      $status=1;
       
     if($pass == $cpass && $y==0)
     {
       $sql="INSERT INTO users(fullName,userName,email,password,college,status) VALUES('$name','$username','$email','$pass','$college','$status')";
       $db->query($sql);
       $_SESSION['message']="you are now loggged in";
       $_SESSION['username']=$username;
       $_SESSION['pass']=$pass;
       if($college==$clg)
        { 
          header("location:home.php");
        }
       else
        {
          header("location:iithome.php");
        }
     }
    else if($pass != $cpass)
     {
       $match="two passoword doedn't match";
       $_SESSION['message']="the two passoword doedn't match";
       
     }
    else
     {
       $_SESSION['message']="either some fields are missing or invalid data in the field";
     }
}
if(isset($_POST['login']))
{
      $clg="other";
      $nameErr = $emailErr = $usernameErr = $passErr = $cpassErr=$collegeErr="";
      $username=$_POST["user"];
      $pass=$_POST["pass"];
      $sql="SELECT * FROM users WHERE userName='$username' AND password='$pass' AND college='$clg'";
      $sqll="SELECT * FROM users WHERE userName='$username' AND password='$pass'";      
      $result=mysqli_query($db,$sql);
      $resultt=mysqli_query($db,$sqll);
      if(mysqli_num_rows($result)==1)
       {
          $_SESSION['message']="you are noew loggged in";
          $_SESSION['username']=$username; 
          $_SESSION['pass']=$pass;
          $sq="UPDATE users set status=1 WHERE userName='$username' AND password='$pass'";
          mysqli_query($db,$sq);
          header("location:home.php");
       }
      else if(mysqli_num_rows($resultt)==1)
       {
          $_SESSION['message']="you are noew loggged in";
          $_SESSION['username']=$username;
          $_SESSION['pass']=$pass; 
          $sq="UPDATE users set status=1 WHERE userName='$username' AND password='$pass'";
          mysqli_query($db,$sq);
          header("location:iithome.php");
       }
      else
       { 
          $_SESSION['message']="username and password combination is incorrect"; 
          $loginErr="username or password is incorrect"; 
       }
     
}
?>




<html>
<title>
HELP DESK JEE
</title>

<head>
<link type="text/css" rel="stylesheet" href="style/style.css" />

</head>

<body>
<div class="headerx">
</div>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="headerx"> 
<div class="header">
<div id="form1" class="header">Username <br>
<input type="text" name="user" placeholder="Username" value=""> <br>
</div>
<div id="form2" class="header">Password <br>
<input placeholder="Password" type="password" name="pass" value="" > <br>
</div>
<span class="error" id="fu"><strong><?php echo $loginErr;?></strong></span>
<input type="submit" class="submit1" value="login" name="login">
</div>

</form>
<div class="bodyx">
<div id="intro1" class="bodyx"> <strong>Help desk helps you connect <br>with IITtians across country </strong></div>
<div id="tag"><strong>HELP DESK </strong></div>
<div id="intro2" class="bodyx"><strong>Create new account</strong></div>
</div>
<div id="form3" class="bodyx">
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<input placeholder="Name" type="text" id="namebox" name="name" value=""> <span class="error"> <?php echo $nameErr;?></span><br>
<input placeholder="Username" type="text" id="mailbox" name="user" value=""> <span class="error">* <?php echo $usernameErr;?></span><br>

<input placeholder="Password" type="password" id="mailbox" name="pass" value=""> <span class="error">* <?php echo $passErr;?></span><span class="error"><?php echo $matchErr;?></span> <br>

<input placeholder="confirm-Password" type="password" id="mailbox" name="cpass" value=""> <span class="error">* <?php echo $cpassErr;?></span><br>
<input placeholder="E-mail" type="text" id="mailbox" name="email" > <span class="error" value=" ">* <?php echo $emailErr;?></span><br>
 <select id="mailbox" name="college">

  <option value="IIT_Mandi">IIT Mandi</option>
  <option value="IIT_Guwahati">IIT Guwahati</option>
  <option value="IIT_Delhi">IIT Delhi</option>
    <option value="IIT_Bombay">IIT Bombay</option>
  <option value="IIT_Madras">IIT Madras</option>
  <option value="IIT_Patna">IIT Patna</option>
  <option value="IIT_Ropar">IIT Ropar</option>
  <option value="IIT_BHU">IIT BHU</option>
    <option value="other">Others</option>


</select> 

<input type="submit" class="button2" value="sign_up" name="sign_up">
</div>

	</div>
	</form>



<?php
 $log=$_GET['log'];
 $logg="logout";
  if($log==$logg)
    {
        $use=$_SESSION['username'];
        $paa=$_SESSION['pass'];
        $sq="UPDATE users set status=0 WHERE userName='$use' AND password='$paa'";
        mysqli_query($db,$sq);
        session_destroy();
    }
//Footer
?>

</body>

</html>
