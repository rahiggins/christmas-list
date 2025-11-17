# christmas-list
An RYO CMS

The list is stored in a MySQL database named rahiggins_xmas. It contains these tables:

```
+--------------------------+
| Tables_in_rahiggins_xmas |
+--------------------------+
| Categories               |
| GiftIdeas                |
| Images                   |
+--------------------------+
```

### Categories
```
+----------+---------------------+------+-----+---------+----------------+
| Field    | Type                | Null | Key | Default | Extra          |
+----------+---------------------+------+-----+---------+----------------+
| id       | tinyint(3) unsigned | NO   | PRI | NULL    | auto_increment |
| Category | text                | NO   |     | NULL    |                |
+----------+---------------------+------+-----+---------+----------------+
```

### GiftIdeas
```
+--------------+----------+------+-----+---------+-------+
| Field        | Type     | Null | Key | Default | Extra |
+--------------+----------+------+-----+---------+-------+
| Category     | text     | NO   | PRI | NULL    |       |
| CreationDate | char(10) | NO   |     | NULL    |       |
| Position     | int(11)  | NO   |     | NULL    |       |
| Name         | text     | NO   |     | NULL    |       |
| URL          | text     | NO   |     | NULL    |       |
| Comment      | text     | NO   |     | NULL    |       |
+--------------+----------+------+-----+---------+-------+
```

### Images
```
+--------+-------------+------+-----+---------+-------+
| Field  | Type        | Null | Key | Default | Extra |
+--------+-------------+------+-----+---------+-------+
| id     | tinyint(4)  | NO   | PRI | NULL    |       |
| src    | varchar(13) | NO   | UNI | NULL    |       |
| height | char(3)     | NO   |     | NULL    |       |
| width  | char(3)     | NO   |     | NULL    |       |
+--------+-------------+------+-----+---------+-------+
```

[index.php](https://github.com/rahiggins/christmas-list/blob/main/index.php) uses the database to produce the Christmas list page.
