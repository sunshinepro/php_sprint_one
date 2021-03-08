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
        } else {
            print_r($errors);
            unset ($errors);
        }
    }
       
// file delete logic

    if (isset($_POST['delete'])) {
    unlink ($_GET['path'] . $_POST['delete']);
    }

    
// file download logic
    if(isset($_POST['download'])){
        $file='./' . $_POST['download'];
        $fileToDownloadEscaped = str_replace("&nbsp;", " ", htmlentities($file, null, 'utf-8'));

        ob_clean();
        ob_start();
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf'); 
        header('Content-Disposition: attachment; filename=' . basename($fileToDownloadEscaped));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($fileToDownloadEscaped)); 
        ob_end_flush();

        readfile($fileToDownloadEscaped);
        exit;
    }

// create new directory logic
    if ((isset($_POST['new_dir'])) && (!file_exists($_POST['new_dir'])) && (!is_dir($_POST['new_dir']))){
        mkdir($_GET['path'] . $_POST['new_dir']);
    };
//back button logic
    $previous = "javascript:history.go(-1)";
    if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}
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
    
<h2>Directory contents:
    <?php
    $cur_dir = getcwd(); 
    echo $cur_dir ;  
     ?>
</h2> 

<?php 
   $myfiles = scandir('./' . $_GET['path']);
?> 

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
                                <button type="submit" name="delete" value="' . $myfiles[$i] . '" onclick="return confirm(\'Delete?\')" style="float: left;">Delete</button>
                            </form>
                                <form action="" method="POST">
                            <button type="submit" name="download" value="' . $myfiles[$i] . '" style="float: left;">Download</button>
                            </form>
                        </td>
                </tr>');}
        if (is_dir($path . $myfiles[$i])) {
            $myfiles = scandir('./' . $_GET['path']);
                print('<tr>
                        <td>Directory</td>
                        <td>
                        <a href="' . $_SERVER['REQUEST_URI'] . $myfiles[$i] . '/">' . $myfiles[$i] . '</a>
                        </td>
                        <td></td>
                     </tr>');
            }                  
                
        }
      ?>  


 </table><br>

 <!--UPLOAD FILE -->
  <div><form action="" method="POST" enctype="multipart/form-data"> 
        <label for="myfile">To upload:</label>
         <input type="file" id="myfile" name="any"/>
         <input type="submit"/><br>
      </form>
    </div>
    <br>

<!-- CREATE DIRECTORIES -->
<div><form action="" method="POST" enctype="multipart/form-data"> 
    <input type="text" name="new_dir" placeholder="Type new directory name" required autofocus>
    <!-- <span><?php if(isset($_POST['new_dir']) && ($dirError) == true) 
                print_r ($dirError)?>
    </span> -->
    <input type="submit">

   
</form>
</div>
<br>

<!-- BACK -->
    <div><button class="back"> <a href="<?= $previous ?>">Back</a> </button></div>

    
<!-- LOGOUT BTN -->

<h4>Click here to <a href = "index.php?action=logout"> logout.</h4>

</body>
</html> 



