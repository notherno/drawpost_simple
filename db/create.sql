DROP TABLE IF EXISTS pictures;

CREATE TABLE pictures (
    id       INTEGER PRIMARY KEY AUTOINCREMENT,
    title    TEXT,
    src      TEXT,
    created  TIMESTAMP
    width    INTEGER,
    height   INTEGER
);

