<?php
    if (!empty($_FILES['files']['name'][0])) {
        
        $files = $_FILES['files'];

        $uploaded = array();
        $failed = array();
        // Allowed extension to be posted
        $allowed = array('jpg', 'png', 'gif');


        for ($i=0; $i < count($files['name']); $i++) { 
            $file_name = $files['name'][$i];
            $file_tmp = $files['tmp_name'][$i];
            $file_size = $files['size'][$i];
            $file_error = $files['error'][$i];
            
            $file_ext = explode('.', $file_name);
            $file_ext = strtolower(end($file_ext));
                
            if (in_array($file_ext, $allowed)) {
                $uploaded[$i] = "{$file_name} uploaded.";
            } else {
                $failed[$i] = "{$file_name} extension de fichier '{$file_ext}' invalide";
            }

        }

        if (!empty($uploaded)) {
            print_r($uploaded);
        }

        if (!empty($failed )) {
            print_r($failed);
        }
    } else {
        echo "Vous n'avez pas envoyer de fichier";
    }