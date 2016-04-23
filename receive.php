<?php
    require_once('db/pictureDao.php');

    $fmt = 'Ymd_His'; // Datetime format for image filename
    $dist = '/upload';
    $DIR = dirname(__file__) . $dist;

    date_default_timezone_set('Asia/Tokyo');
    $datetime = new DateTime();
    $filename = 'image_' . $datetime->format($fmt) . '.png';

    $dataurl = isset($_POST['img']) ? $_POST['img'] : NULL;
    $title = isset($_POST['title']) && $_POST['title'] ? $_POST['title'] : 'Untitled';

    if (! $dataurl) {
        http_response_code(400);
        exit('No image data available');
    }

    // Cutout data from dataURI
    list($type, $data) = explode(';', $dataurl);
    list(, $data) = explode(',', $data);

    // Decode binary image data in PNG format
    $img = base64_decode($data);

    if (! file_put_contents($DIR . '/' . $filename, $img)) {
        http_response_code(500);
        exit('Permission Error: Please confirm file writing permission');
    }

    // Data inserion into SQLite3 database
    $dao = new PictureDao('db/db.sqlite');
    $dao->save_picture($title, $filename);

    http_response_code(200);
    exit($dist . '/' . $filename);

