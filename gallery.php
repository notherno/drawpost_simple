<?php
    require_once('db/pictureDao.php');
    $dao = new PictureDao('db/db.sqlite');
    $pictures = $dao->get_pictures(0, 50);

    $UPLOAD_DIR = 'upload/';

?><!DOCTYPE html>
<html lang="en">
<head>
    <title>Upload gallery</title>
	<link rel="stylesheet" href="css/kickstart.css">
    <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="js/masonry.pkgd.min.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            background:#efefef url(css/img/gray_jean.png);
        }

        #header {
            margin: 0;
            text-align: center;
        }

        #header h1 {
            font-size: 2em;
        }

        #gallery_list {
            list-style-type: none;
        }

        .post {
            width: 300px;
            padding: 10px;
        }

        .post h2 {
            font-size: 1.2em;
            margin: 0;
        }

        .post time {
            display: block;
            font-size: 0.7em;
            text-align: right;
            color: #808080;
            padding-right: 1em;
        }

        .post img {
            width: 270px;
            display: block;
            margin: 0 auto;
        }
    </style>
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
    $('#gallery_list').masonry({
        itemSelector: '.post'
    });
</script>
</body>
</html>

