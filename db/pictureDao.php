<?php
class PictureDao {

    private $handle = null;

    public function __construct ($filename) {
        date_default_timezone_set('Asia/Tokyo');
        $this->handle = new SQLite3($filename);
    }

    public function close () {
        $this->handle->close();
    }

    public function get_pictures ($offset, $limit) {
        $statement = $this->handle->prepare(
                "SELECT * FROM pictures ORDER BY created DESC LIMIT :limit OFFSET :offset;"
            );
        $statement->bindValue(':limit', $limit);
        $statement->bindValue(':offset', $offset);

        $resx = $statement->execute();
        $results = [];
        while ($res = $resx->fetchArray(SQLITE3_ASSOC)) {
            $results[] = $res;
        }
        return $results;
    }

    public function count_pictures () {
        $statement = $this->handle->prepare("SELECT count(*) FROM pictures;");

        $resx = $statement->execute()->fetchArray();
        return $resx[0];
    }

    public function save_picture ($title, $filename, $width, $height) {
        $statement = $this->handle->prepare(
            "INSERT INTO pictures (title, src, width, height, created) VALUES (:title, :filename, :width, :height, :timestamp);"
        );
        $statement->bindValue(':title', $title);
        $statement->bindValue(':filename', $filename);
        $statement->bindValue(':width', $width);
        $statement->bindValue(':height', $height);
        $statement->bindValue(':timestamp', self::get_timestamp());
        return $statement->execute();
    }

    public static function get_timestamp () {
        return (new datetime())->format('Y-m-d H:i:s');
    }

}

