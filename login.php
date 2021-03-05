
<html lang = "en">
   <head>
      <title>Login</title>
   </head>
   <body>
      <h2>Enter valid username and password</h2> 
      <div>
         <?php
            $msg = '';
            if (isset($_POST['login']) 
                && !empty($_POST['username']) 
                && !empty($_POST['password'])
            ) {	
               if ($_POST['username'] == 'SunshinePro' && 
                  $_POST['password'] == '5555'
                ) {
                  $_SESSION['logged_in'] = true;
                  $_SESSION['timeout'] = time();
                  $_SESSION['username'] = 'SunshinePro';
                  } else {
                  $msg = 'Wrong username or password';
               }
            }
         ?>
      </div>
      <div>
        <?php 
            if($_SESSION['logged_in'] == true){
               header('location: index.php');}
                         
        ?>
        <form action="" method="post">
            <h4><?php echo $msg; ?></h4>
            <input type="text" name="username" placeholder="username = SunshinePro" required autofocus></br>
            <input type="password" name="password" placeholder="password = 5555" required>
            <button class = "login" type="submit" name="login">Login</button>
        </form>
      </div> 
   </body>
</html>