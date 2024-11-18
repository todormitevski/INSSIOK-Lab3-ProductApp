<?php

include "../database/db_connection.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = $_POST["name"] ?? "";
  $description = $_POST["description"] ?? "";
  $price = (float) $_POST["price"] ?? 0.0;

  if (empty($name) || empty($description) || $price <= 0.0) {
    echo "Provide correct input.";
    exit;
  }

  $db = connectDatabase();

  $stmt = $db->prepare("INSERT INTO products (name, description, price) VALUES (:name, :description, :price)");
  $stmt->bindValue(":name", $name, SQLITE3_TEXT);
  $stmt->bindValue(":description", $description, SQLITE3_TEXT);
  $stmt->bindValue(":price", $price, SQLITE3_FLOAT);

  if ($stmt->execute()) {
    header("Location: ../index.php");
  } else {
    echo "Error adding product: " . $db->lastErrorMsg();
  }

  $db->close();
} else {
  echo "Invalid request method.";
}
