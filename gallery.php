<?php
    require_once('db/pictureDao.php');
    $dao = new PictureDao('db/db.sqlite');
    $pictures = $dao->get_pictures(0, 50);
    $dao->close();

    $UPLOAD_DIR = 'upload/';

?><!DOCTYPE html>
<html lang="en">
<head>
    <title>Upload gallery</title>
	<link rel="stylesheet" href="css/kickstart.css">
	<link rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=yes">
    <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="js/masonry.pkgd.min.js"></script>
</head>
<body>
    <div id="header">
        <h1>Picture Gallery</h1>
        <a href="index.html"><i class="fa fa-paint-brush"></i> Drawing</a>
    </div>
    <div id="wrapper" class="grid">
        <ul id="gallery_list">
<?php
    foreach ($pictures as $pic) {
?>
            <li class="post">
                <h2><?php echo htmlspecialchars($pic['title']); ?></h2>
                <time><?php echo $pic['created']; ?></time>
                <div>
                    <img src="<?php echo $UPLOAD_DIR . $pic['src']; ?>" width="<?php echo $pic['width']; ?>" height="<?php echo $pic['height']; ?>">
                </div>
            </li>
<?php
    }
?>
    </ul>
    </div>
<script>
    $(window).load(function () {
        $('#gallery_list').masonry({
            itemSelector: '.post'
        });
    });
</script>
</body>
</html>

