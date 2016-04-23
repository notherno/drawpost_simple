<?php
class PictureDao {

    private $handle = null;

    public function __construct ($filename) {
        date_default_timezone_set('Asia/Tokyo');
        $this->handle = new SQLite3($filename);
    }

    public function get_pictures ($offset, $limit) {
        $statement = $this->handle->prepare("SELECT * FROM pictures ORDER BY created DESC LIMIT :limit OFFSET :offset;");
        $statement->bindValue(':limit', $limit);
        $statement->bindValue(':offset', $offset);

        $resx = $statement->execute();
        $results = [];
        while ($res = $resx->fetchArray(SQLITE3_ASSOC)) {
            $results[] = $res;
        }
        return $results;
    }

    public function save_picture ($title, $filename) {
        $statement = $this->handle->prepare(
            "INSERT INTO pictures (title, src, created) VALUES (:title, :filename, :timestamp);"
        );
        $statement->bindValue(':title', $title);
        $statement->bindValue(':filename', $filename);
        $statement->bindValue(':timestamp', self::get_timestamp());
        return $statement->execute();
    }

    public static function get_timestamp () {
        return (new datetime())->format('Y-m-d H:i:s');
    }

}

