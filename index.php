<?php
include "./database/db_connection.php";

$db = connectDatabase();

$query = "SELECT * FROM products";
$result = $db->query($query);

if (!$result) {
  die("Error fetching data from db: " . $db->lastErrorMsg());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products Table</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-900 text-gray-100 min-h-screen p-4 sm:p-6 lg:p-8">

  <div class="max-w-7xl mx-auto">
    <div class="mb-6">
      <a href="routes/product_form.php" class="inline-block px-4 py-2 bg-gray-900 text-green-400 border-2 border-green-400 rounded-md transition-colors duration-300 hover:bg-green-400 hover:text-gray-900">
        Add product
      </a>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full bg-gray-800 rounded-lg overflow-hidden">
        <thead class="bg-green-400 text-gray-900">
          <tr>
            <th class="px-4 py-3 text-left">ID</th>
            <th class="px-4 py-3 text-left">Name</th>
            <th class="px-4 py-3 text-left">Description</th>
            <th class="px-4 py-3 text-left">Price</th>
            <th class="px-4 py-3 text-left">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result->numColumns() > 0): ?>
            <?php while ($product = $result->fetchArray(SQLITE3_ASSOC)): ?>
              <tr class="border-b border-gray-700 hover:bg-gray-700 transition-colors duration-200">
                <td class="px-4 py-3"><?php echo htmlspecialchars($product["id"]) ?></td>
                <td class="px-4 py-3"><?php echo htmlspecialchars($product["name"]) ?></td>
                <td class="px-4 py-3"><?php echo htmlspecialchars($product["description"]) ?></td>
                <td class="px-4 py-3"><?php echo htmlspecialchars($product["price"]) ?></td>
                <td class="px-4 py-3">
                  <div class="flex space-x-2">
                    <form action="./routes/product_form.php" method="get">
                      <input type="hidden" name="id" value="<?php echo $product["id"] ?>">
                      <button type="submit" class="px-3 py-1 bg-transparent text-green-400 border border-green-400 rounded hover:bg-green-400 hover:text-gray-900 transition-colors duration-300">
                        Edit
                      </button>
                    </form>
                    <form action="./routes/delete_product.php" method="post">
                      <input type="hidden" name="id" value="<?php echo $product["id"] ?>">
                      <button type="submit" class="px-3 py-1 bg-transparent text-green-400 border border-green-400 rounded hover:bg-green-400 hover:text-gray-900 transition-colors duration-300">
                        Delete
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="5" class="px-4 py-3 text-center">No products listed.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>

</html>