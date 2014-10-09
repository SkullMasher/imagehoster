<?php require 'function.php';

    $password_page = 'pinkfloyd';

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>ImageHosting</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php

    if (isset($_GET['p'])) {
        if ($_GET['p'] == $password_page) { ?>
            <p class="desc">xTropik like - Version Alpha by Heartless Gaming. Changelog & Info sur <a href="https://github.com/SkullMasher/imagehoster/tree/master">Github</a></p>
            <form class="form-upload-image" action="upload.php" method="post" enctype="multipart/form-data">
                <input type="file" name="files[]" multiple>
                <input type="submit" value="Upload">
            </form> <?php
        }
    } else { ?>
            <p class="pfquote">There's no dark side of the moon really. Matter of fact it is all dark.</p>
            <form class="form-auth" action="index.php" method="get">
                <input type="password" name="p" placeholder="Password">
                <input type="submit">
            </form>
    <?php
    }
    ?>
    
</body>
</html>