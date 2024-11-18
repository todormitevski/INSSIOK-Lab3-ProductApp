<?php
include "../database/db_connection.php";

$db = connectDatabase();

$isEdit = isset($_GET['id']);
$product = ['name' => '', 'description' => '', 'price' => ''];

if ($isEdit) {
  $id = $_GET['id'];
  $query = "SELECT * FROM products WHERE id = :id";
  $stmt = $db->prepare($query);
  $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
  $result = $stmt->execute();
  $product = $result->fetchArray(SQLITE3_ASSOC);

  if (!$product) {
    die("Product not found.");
  }
}
?>

<!DOCTYPE html>
<html lang="en" class="bg-gray-950">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $isEdit ? "Edit Product" : "Add Product"; ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          animation: {
            'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
          }
        }
      }
    }
  </script>
</head>

<body class="min-h-screen bg-gray-950 text-gray-100 p-4 sm:p-6 lg:p-8 flex items-center justify-center relative overflow-hidden">
  <div class="absolute inset-0 overflow-hidden">
    <div class="absolute -inset-[10%] bg-green-900/20 rounded-full blur-3xl animate-pulse-slow"></div>
    <div class="absolute -inset-[20%] left-[40%] bg-green-900/20 rounded-full blur-3xl animate-pulse-slow" style="animation-delay: -2s;"></div>
  </div>

  <div class="w-full max-w-md relative z-10">
    <h1 class="text-2xl font-bold mb-6 text-center text-green-400"><?php echo $isEdit ? "Edit Product" : "Add Product"; ?></h1>
    <form action="<?php echo $isEdit ? 'update_product.php' : 'create_product.php'; ?>" method="post" class="bg-gray-900/80 backdrop-blur-sm p-6 rounded-lg shadow-lg border border-green-400">
      <?php if ($isEdit): ?>
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['id']); ?>">
      <?php endif; ?>

      <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-300 mb-1">Name:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($product['name']); ?>" required class="w-full px-3 py-2 bg-gray-800 text-gray-100 rounded border border-gray-700 focus:border-green-400 focus:ring focus:ring-green-400 focus:ring-opacity-50">
      </div>
      <div class="mb-4">
        <label for="description" class="block text-sm font-medium text-gray-300 mb-1">Description:</label>
        <textarea name="description" id="description" required class="w-full px-3 py-2 bg-gray-800 text-gray-100 rounded border border-gray-700 focus:border-green-400 focus:ring focus:ring-green-400 focus:ring-opacity-50 h-24"><?php echo htmlspecialchars($product['description']); ?></textarea>
      </div>
      <div class="mb-6">
        <label for="price" class="block text-sm font-medium text-gray-300 mb-1">Price:</label>
        <input type="text" name="price" id="price" value="<?php echo htmlspecialchars($product['price']); ?>" required class="w-full px-3 py-2 bg-gray-800 text-gray-100 rounded border border-gray-700 focus:border-green-400 focus:ring focus:ring-green-400 focus:ring-opacity-50">
      </div>
      <div class="flex items-center justify-between">
        <button type="submit" class="px-4 py-2 bg-gray-950 text-green-400 border-2 border-green-400 rounded-md transition-colors duration-300 hover:bg-green-400 hover:text-gray-950">
          <?php echo $isEdit ? "Update Product" : "Add Product"; ?>
        </button>
        <a href="../index.php" class="text-sm text-gray-400 hover:text-green-400 transition-colors duration-300">
          Back to Products
        </a>
      </div>
    </form>
  </div>
</body>

</html>