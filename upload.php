<?php
    require 'function.php';

    // echo "<pre>" . print_r($_FILES['files']) . '</pre>';

    if (!empty($_FILES['files']['name'][0])) {
        
        $files = $_FILES['files'];

        $uploaded = array();
        $failed = array();
        // Allowed extension to be used
        $allowed = array('jpg', 'png', 'gif');


        for ($i=0; $i < count($files['name']); $i++) {
            
            $file_name  = $files['name'][$i];
            $file_tmp   = $files['tmp_name'][$i];
            $file_error = $files['error'][$i];
            $file_size  = $files['size'][$i];
            
            $file_ext = explode('.', $file_name);
            // Lowercase the end of the array in this case the file extension.
            $file_ext = strtolower(end($file_ext));
                
            if (in_array($file_ext, $allowed)) {
                if ($file_error === 0) {
                    if ($file_size <= 10485760) {
                        if (!check_file_uploaded_name($file_name)) {
                            if (!check_file_uploaded_length($file_name)) {
                                // Renaming file and adding file extension
                                $file_rename = mt_rand_str(6) . '.' . $file_ext;
                                // File will be stored in this place.
                                $file_destination = 'i/' . $file_rename;

                                if (move_uploaded_file($file_tmp, $file_destination)) {
                                    $uploaded[$i] = "<a href=\"" . $file_destination ."\">" . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF'])) . '/' . $file_destination . "</a>";
                                } else {
                                    $failed[$i] = "<b>{$file_name}</b> OGM file upload fail.";
                                }
                            } else {
                                $failed[$i] = "OMG fichier beaucoup trop long. 150 Char max.";
                            }
                        } else {
                            $failed[$i] = "Nom de fichier invalide <b>{$file_name}</b>";
                        }
                    } else {
                        $failed[$i] = "<b>{$file_name}</b> fait plus de 10mo. {$file_error}";
                    }
                } else {
                    $failed[$i] = "<b>{$file_name}</b> erreur : {$file_error}";
                }
            } else {
                $failed[$i] = "<b>{$file_name}</b> fichier '{$file_ext}' interdit.";
            }

        }
    } else {
        array_push($failed, "Pas de Fichier");
    }


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>ImageHosting</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <?php 
        // print_r($failed);
        // print_r($uploaded);

    // Image upload success
    if (!empty($uploaded)) { ?>
        <div class="file-success">
    <?php
        foreach ($uploaded as $success) {
            echo $success;
        }
        echo "</div>";
    }

    // Image upload fail
    if (!empty($failed)) { ?>
        <div class="file-error">
    <?php
        foreach ($failed as $error) {
            echo '<p>' . $error . '</p>';
        }
        echo "</div>";
    }
    ?>
</body>
</html>