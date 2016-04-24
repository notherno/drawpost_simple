# Canvas simple drawing
![image](https://cloud.githubusercontent.com/assets/12454556/14765454/779c9fc0-0a1c-11e6-8648-c83dce97024a.png)

## Description
A simple sketching application work on your browser
Works on PC and touch browsers

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

## Open source libraries
- jQuery
- [HTML Kickstart](https://github.com/joshuagatcke/HTML-KickStart)
- [Masonry](https://github.com/desandro/masonry)
- [jscolor](http://jscolor.com/)

