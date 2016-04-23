# Canvas simple drawing

## Description
A simple sketching application work on your browser
(This app can't be used with touch display for now)

## Running server
If the system has php, then run following command

```
$ php -S localhost:8888
```
and open `http://localhost:8888/` in your browser.

## Database initialization
Before first execution, it requires SQLite3 database initialization.
Change directory to the app and make database file with following,

```
sqlite3 db/db.sqlite
```

then type `.exit` to close console and run initialize SQL as

```
sqlite3 db/db.sqlite < db/create.sql
```

