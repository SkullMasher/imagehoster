<?php
    if (!empty($_FILES['files']['name'][0])) {

        $files = $_FILES['files'];

        $uploaded = array();
        $failed = array();
        $allowed = array('jpg', 'png', 'gif');

        for ($i=0; $i < count($files['name']); $i++) { 
            $file_name = $files['name'][$i];
            $file_tmp = $files['tmp_name'][$i];
            $file_size = $files['size'][$i];
            $file_error = $files['error'][$i];
            
            $file_ext = explode('.', $files_name);
            $file_ext = explode(strtolower(end($file_ext)));

                echo $file_name;
                
            if (in_array($file_ext, $allowed)) {
            } else {
                $failed[$i] = "[{$files_name}]";
            }
        }

        // Get the file Properties
    }