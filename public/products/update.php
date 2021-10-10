<?php 
  
  //making connection to mySQL db
  require_once '../../database.php';
  require_once '../../functions.php';
  
  $id = $_GET['id'] ?? null;

    //if no id
    if(!$id) {
        header('Location: index.php');
        exit;
    }

  $statement = $pdo->prepare('SELECT * FROM products WHERE id = :id');
  $statement->bindValue(':id', $id);
  $statement->execute();
  $product = $statement->fetch(PDO::FETCH_ASSOC);

  $errors = [];

  $title = $product['title'];
  $description = $product['description'];
  $price = $product['price'];

  //check current method
  if($_SERVER['REQUEST_METHOD'] === 'POST') {

    require_once '../../validate_product.php';

    if(empty($errors)) {

      $statement = $pdo->prepare("UPDATE products SET title = :title, description = :description, image = :image, price = :price WHERE id = :id");

      $statement->bindValue(':title', $title);
      $statement->bindValue(':description', $description);
      $statement->bindValue(':image', $imagePath);
      $statement->bindValue(':price', $price);
      $statement->bindValue(':id', $id);

      $statement->execute();

      header('Location: index.php');
    }
  }
 
 ?>
  <?php include_once '../../views/partials/header.php' ?>
    <p>
      <a href="index.php" class="btn btn-secondary">Go back to products</a>
    </p>

    <h1>Update Product: <strong><?php echo $product['title'] ?></strong></h1>

    <?php include_once '../../views/products/form.php' ?>
    
  </body>
</html>
