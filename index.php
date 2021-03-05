<?php
session_start()
?>
<?php 
    session_start();
    // logout logic
    if(isset($_GET['action']) and $_GET['action'] == 'logout'){
        session_start();
        unset($_SESSION['username']);
        unset($_SESSION['password']);
        unset($_SESSION['logged_in']);
        header('Location: login.php');
        exit;
    }
    // file upload logic
    if(isset($_FILES['any'])){
        $errors = array();

        $file_name = $_FILES['any']['name'];
        $file_size = $_FILES['any']['size'];
        $file_tmp = $_FILES['any']['tmp_name'];
        $file_type = $_FILES['any']['type'];

        if($file_size > 2097152) {
            $errors[] = 'File size must be excately 2 MB';
        }
        if(empty($errors) == true) {
            move_uploaded_file($file_tmp, "./" . $path . $file_name);
            echo "Success";
        } else {
            print_r($errors);
        }
    }
    else {
        print('Please choose the file to upload');
    }
    
// file delete logic
// if (isset($_POST['delete'])) {
//     unlink($_GET['path'] . $_POST['delete']);
//     header('Location: ' . $_SERVER['REQUEST_URI']);
// } 
     
    
    // file download logic

    // create new directory logic
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
    
    <!-- SCAN DIRECTORY CONTENT -->
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
<!-- SORT DATA INTO TABLE -->
<table>
    <tr>
        <th>Type</th>
        <th>Name</th>
        <th>Action</th>
    </tr>
    <?php 
     $fileButtons = '<form action="" method="POST">
     <button type="submit" name="delete" value="' . $dirArray . '">Delete</button>
 </form>
 <form action="" method="POST">
     <button type="submit" name="download" value="' . $dirArray . '">Download</button>
 </form>';   
    foreach ($dirArray as $name) { //5. irasom duomenis i lentele
          // print($name);
          if (is_file($path . $name)) {
            print('<tr>
                    <td>File</td>
                    <td>' . $name . '</td>
                    <td> <form action="" method="POST">
                            <button type="submit" name="delete" value="' . $dirArray . '" style="float: left;">Delete</button>
                        </form>
                        <form action="" method="POST">
                             <button type="submit" name="download" value="' . $dirArray . '" style="float: left;">Download</button>
                        </form> </td>
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
  $fileButtons = '<form action="" method="POST">
                <button type="submit" name="delete" value="' . $dirArray . '">Delete</button>
            </form>
            <form action="" method="POST">
                <button type="submit" name="download" value="' . $dirArray . '">Download</button>
            </form>';      
        ?>  
 </table><br>

 <!--UPLOAD FILE -->
  <div><form action="" method="POST" enctype="multipart/form-data"> 
         <input type="file" name="any"/>
         <input type="submit"/>
      </form>
    </div>
<!-- DOWNLOAD FILE -->

<!-- CREATE DIRECTORIES -->
<div><form action="" method="POST" enctype="multipart/form-data"> 
    <input type="text" name="new_dir" placeholder="Type new directory name" required autofocus>
    <input type="submit">
</form>
</div>
<!-- DELETE -->

<!-- BACK -->
    <div><button class="back"> BACK </button></div>


<!-- LOGOUT BTN -->

<h4>Click here to <a href = "index.php?action=logout"> logout.</h4>
</div>
</body>
</html> 



