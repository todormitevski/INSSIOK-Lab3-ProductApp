<?php

include "./database/db_connection.php";

$db = connectDatabase();

$createTableQuery = <<<SQL
CREATE TABLE IF NOT EXISTS products (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name TEXT REQUIRED,
  description TEXT REQUIRED,
  price FLOAT REQUIRED
);
SQL;

if ($db->exec($createTableQuery)) {
  echo "Table created.";
} else {
  echo "Error creating a table: " . $db->lastErrorMsg();
}

$db->close();
