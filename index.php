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
            $errors[] = 'File size must be not more than 2 MB';
        }
        if(empty($errors) == true) {
            move_uploaded_file($file_tmp, "./" . $path . $file_name);
            echo "Success";
        } else {
            print_r($errors);
            unset ($errors);
        }
    }
    else {
        print('Please choose the file to upload');
    }
    
// file delete logic


if (isset($_POST['delete'])) {
    unlink ($_GET['path'] . $_POST['delete']);
}

     
    
    // file download logic

    // create new directory logic

    if (isset($_POST['new_dir'])) {
        if (file_exists($_POST['new_dir']) && is_dir($_POST['new_dir'])) {
        $dirError[] = 'The directory with this name already exists';
        print($dirError);
        // unset ($new_dir);
        // unset ($dirError);
        } else {
        mkdir($_GET['path'] . $_POST['new_dir']);
    }
    };
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
//   $dirArray = array_values(array_diff($myfiles, array('..', '.'))); //3.1 isvalom taskiukus ir atstatom indeksus nuo nulio
//   print_r($dirArray); 
  
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
     for ($i = 0; $i < count($myfiles); $i++) {
        if ($myfiles[$i] === '.' || $myfiles[$i] === '..') continue;
        if (is_file($path . $myfiles[$i])) 
            {print('<tr>
                        <td>File</td>
                        <td>' . $myfiles[$i] . '</td>
                        <td>
                            <form action="" method="POST">
                                <button type="submit" name="delete" value="' . $myfiles[$i] . '" onclick="return confirm(\'Are you sure?\')">Delete</button>
                            </form>
                                <form action="" method="POST">
                            <button type="submit" name="download" value="' . $myfiles[$i] . '">Download</button>
                            </form>
                        </td>
                </tr>');}
        if (is_dir($path . $myfiles[$i])) {
            if (!isset($_GET['path'])) {
                print('<tr>
                        <td>Directory</td>
                        <td>
                        <a href="' . $_SERVER['REQUEST_URI'] . '?path=' . $myfiles[$i] . '/">' . $myfiles[$i] . '</a>
                        </td>
                        <td></td>
                    </tr>');
            } else {
                print('<tr>
                        <td>Directory</td>
                        <td>
                        <a href="' . $_SERVER['REQUEST_URI'] . $myfiles[$i] . '/">' . $myfiles[$i] . '</a>
                        </td>
                        <td></td>
                     </tr>');
                }
            }
        }


//         <?php
// function dirToArray($dir) {
  
//    $result = array();

//    $cdir = scandir($dir);
//    foreach ($cdir as $key => $value)
//    {
//       if (!in_array($value,array(".","..")))
//       {
//          if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
//          {
//             $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
//          }
//          else
//          {
//             $result[] = $value;
//          }
//       }
//    }
  
//    return $result;
// } ?>
//      $fileButtons = '<form action="" method="POST">
//      <button type="submit" name="delete" value="' . $dirArray . '">Delete</button>
//  </form>
//  <form action="" method="POST">
//      <button type="submit" name="download" value="' . $dirArray . '">Download</button>
//  </form>';   
//     foreach ($dirArray as $name) { //5. irasom duomenis i lentele
//           // print($name);
//           if (is_file($path . $name)) {
//             print('<tr>
//                     <td>File</td>
//                     <td>' . $name . '</td>
//                     <td> <form action="" method="POST">
//                             <button type="submit" name="delete" value="' . $dirArray . '" style="float: left;">Delete</button>
//                         </form>
//                         <form action="" method="POST">
//                              <button type="submit" name="download" value="' . $dirArray . '" style="float: left;">Download</button>
//                         </form> </td>
//                   </tr>');
                  
//           } elseif (is_dir($path . $name)) { // SUGALVOTI: kol yra direktorija, tol skenuoti
//             print("<tr>
//                   <td>Directory</td>
//                   <td><a href=('$dirArray . $name'))>$name</a></td>
//                   <td></td>
//             </tr>");
//          print_r($myfiles);
//           }
//         }

        // <form action="" method="POST">
        //                                                         <button type="submit" name="delete" value="' . $content[$i] . '" onclick="return confirm(\'Are you sure?\')">Delete</button>
        //                                                     </form>
//   $fileButtons = '<form action="" method="POST">
//                 <button type="submit" name="delete" value="' . $dirArray . '">Delete</button>
//             </form>
//             <form action="" method="POST">
//                 <button type="submit" name="download" value="' . $dirArray . '">Download</button>
//             </form>';      
//         ?>  
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
    <!-- <span><?php if(isset($_POST['new_dir']) && ($dirError) == true) 
                print_r ($dirError)?>
    </span> -->
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



