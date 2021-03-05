<?php
session_start()
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheet.css"> 
    <title>Folder explorer</title>
</head>
<body>
    <?php
    // require 'login.php';
    if($_SESSION['logged_in'] == false){
     header('location: login.php'); 
    }
    // if($_SESSION['logged_in'] == true){
    //     header('location: index.php'); 
    //    }
    ?>

    <!-- 1. nustatom dabartines direktorijos adresa
    2. Atsisiunciam direktorijos duomenis su GET ir patikrinam ar jie uzsetinti
    3. Nuskenuojam direktorija i stringa 
    4. patikrinam kiekviena stringo nari ar tai file ar directory
    5. irasom duomenis i lentele
    6. kuriam delete mygtuka lenteleje
    7. kuriam back mygtuka aplikacijoje -->
    
    <div>
<h2>Directory contents getcwd:
    <?php
    $cur_dir = getcwd(); 
    echo $cur_dir ;  
       
    ?>
</h2> 
<h3>SERVER request uri:
    <?php
    print($_SERVER['REQUEST_URI']); //1. nustatom dabartines direktorijos adresa
    print('GET path: '. '/'.$_GET['path']);     
    ?>
</h3> 

<h3>
 SCANDIR:
  <?php 
                                             //2. Atsisiunciam direktorijos duomenis su GET
  $myfiles = scandir('./' . $_GET['path']); //3. Nuskenuojam direktorija i stringa 
  print_r($myfiles); 
  $dirArray = array_values(array_diff($myfiles, array('..', '.'))); //3.1 isvalom taskiukus ir atstatom indeksus nuo nulio
  print_r($dirArray); 
  
  ?> 
</h3> 

<table>
    <tr>
        <th>Type</th>
        <th>Name</th>
        <th>Action</th>
    </tr>
    <?php 
    foreach ($dirArray as $name) { //5. irasom duomenis i lentele
          // print($name);
          if (is_file($path . $name)) {
            print('<tr>
                    <td>File</td>
                    <td>' . $name . '</td>
                    <td><button class = delete>Delete</button>
                    <button class = upload>Upload</button></td>
                  </tr>');
                  
                    
          } elseif (is_dir($path . $name)) { // SUGALVOTI: kol yra direktorija, tol skenuoti
            print("<tr>
                  <td>Directory</td>
                  <td><a href=('$dirArray . $name'))>$name</a></td>
                  <td></td>
            </tr>");
         print_r($myfiles);
          }
        }
        
        ?>  
 </table>

 <!--Upload file  -->
 <?php 
    print('<pre>');
    print_r($_FILES['image']);
    print_r($_FILES['image']['name']);
    print('</pre>');

    if(isset($_FILES['image'])){
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];
        move_uploaded_file($file_tmp, "./" . $file_name);
        echo "Success";
    }
?>
<!-- //nurodyti, kur uploadina failus, kokio tipo -->
 <form action="" method="POST" enctype="multipart/form-data"> 
         <input type="file" name="image" />
         <input type="submit"/>
      </form>
<!-- BACK -->
    <button class="back"> BACK </button>
    <!-- LOGOUT BTN -->

    Click here to <a href = "index.php?action=logout"> logout.
</div>
</body>
</html> 



