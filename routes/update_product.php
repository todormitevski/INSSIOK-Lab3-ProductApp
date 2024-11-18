<?php

include "../database/db_connection.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
  $id = intval($_POST["id"]);
  $name = $_POST["name"];
  $description = $_POST["description"];
  $price = (float) $_POST["price"];
  $db = connectDatabase();

  $stmt = $db->prepare("UPDATE products SET name = :name, description = :description, price = :price WHERE id = :id");
  $stmt->bindValue(":id", $id, SQLITE3_INTEGER);
  $stmt->bindValue(":name", $name, SQLITE3_TEXT);
  $stmt->bindValue(":description", $description, SQLITE3_TEXT);
  $stmt->bindValue(":price", $price, SQLITE3_FLOAT);
  $stmt->execute();

  $db->close();

  header("Location: ../index.php");
  exit();
} else {
  echo "Invalid request.";
}
