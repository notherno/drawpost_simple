<?php

    $UPLOAD_DIR = 'upload/';
    $files = scandir($UPLOAD_DIR, SCANDIR_SORT_ASCENDING);

?><!DOCTYPE html>
<html lang="en">
<head>
    <title>Upload gallery</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="wrapper">
        <h1>Picture Gallery</h1>
        <a href="index.html">Drawing</a>
<?php
    echo '<ul id="gallery_list">';
    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) == 'png') {
            echo '<li><img src="' . $UPLOAD_DIR . $file . '"></li>';
        }
    }
    echo '</ul>';
?>
    </div>
</body>
</html>

