<?php
    require 'function.php';
    
    echo "<pre>" . print_r($_FILES['files']) . '</pre>';
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
                                $file_destination = 'uploads/' . $file_rename;

                                if (move_uploaded_file($file_tmp, $file_destination)) {
                                    $uploaded[$i] = "{$file_name} uploaded.";
                                } else {
                                    $failed[$i] = "{$file_name} OGM file upload fail.";
                                }
                            } else {
                                $failed[$i] = "OMG fichier beaucoup trop long. 150 Char max.";
                            }
                        } else {
                            $failed[$i] = "Nom de fichier invalide {$file_name}";
                        }
                    } else {
                        $failed[$i] = "{$file_name} fait plus de 10mo. {$file_error}";
                    }
                } else {
                    $failed[$i] = "{$file_name} erreur : {$file_error}";
                }
            } else {
                $failed[$i] = "{$file_name} extension de fichier '{$file_ext}' invalide";
            }

        }
    } else {
        echo "Pas de fichier";
    }

    if (!empty($failed)) {
        print_r($failed);
    }
    if (!empty($uploaded)) {
        print_r($uploaded);
    }
