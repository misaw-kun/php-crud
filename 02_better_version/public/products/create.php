<?php 
  
  //making connection to mySQL db
  require_once '../../database.php';
  require_once '../../functions.php';

  $errors = [];

  $title = '';
  $description = '';
  $price = '';
  $product = [
    'image' => ''
  ];

  //check current method (post or get)
  if($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../../validate_product.php';
    if(empty($errors)) {

      $statement = $pdo->prepare("INSERT INTO products (title, description, image, price, create_date)
        VALUES (:title, :description, :image, :price, :date)");

      $statement->bindValue(':title', $title);
      $statement->bindValue(':description', $description);
      $statement->bindValue(':image', $imagePath);
      $statement->bindValue(':price', $price);
      $statement->bindValue(':date', date('Y-m-d H:i:s'));

      $statement->execute();

      header('Location: index.php');
    }
  }

 ?>

<?php include_once '../../views/partials/header.php' ?>
    <p>
      <a href="index.php" class="btn btn-secondary">Go back to products</a>
    </p>

    <h1>Create New Product</h1>

    <?php include_once '../../views/products/form.php' ?>
    
  </body>
</html>
