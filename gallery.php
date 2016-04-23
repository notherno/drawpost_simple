<?php
    require_once('db/pictureDao.php');
    $dao = new PictureDao('db/db.sqlite');
    $pictures = $dao->get_pictures(0, 50);

    $UPLOAD_DIR = 'upload/';

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
        <ul id="gallery_list">
<?php
    foreach ($pictures as $pic) {
?>
            <li>
                <h2><?php echo $pic['title']; ?></h2>
                <time><?php echo $pic['created']; ?></time>
                <div>
                    <img src="<?php echo $UPLOAD_DIR . $pic['src']; ?>">
                </div>
            </li>
<?php
    }
?>
    </ul>
    </div>
</body>
</html>

