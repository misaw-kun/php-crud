<?php 
  
  //making connection to mySQL db
  $pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud','root','');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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

  // echo '<pre>';
  // var_dump($products);
  // echo '</pre>';
  // exit;

  $errors = [];

  $title = $product['title'];
  $description = $product['description'];
  $price = $product['price'];

  function randomString($n)
    {
      $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $str = '';

      for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($chars) - 1);
        $str .= $chars[$index];
      }

      return $str;      

    }

  //check current method
  if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    if (!$title) {
      $errors[] = 'Product title is required!';
    }

    if(!$price) {
      $errors[] = 'Product price is required!';
    }

    if(!is_dir('images')) {
      mkdir('images');
    }

    if(empty($errors)) {

      $image = $_FILES['image'] ?? null;
      $imagePath = $product['image'];

      if($image && $image['tmp_name']) {

        if($product['image']) {
          unlink($product['image']);
        }

        $imagePath = 'images/'.randomString(8).'/'.$image['name'];
        mkdir(dirname($imagePath));

        move_uploaded_file($image['tmp_name'], $imagePath);
      }

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

<!doctype html> 
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <link rel="stylesheet" href="styles.css">

    <title>Products CRUD</title>
  </head>
  <body>

    <p>
      <a href="index.php" class="btn btn-secondary">Go back to products</a>
    </p>

    <h1>Update Product: <strong><?php echo $product['title'] ?></strong></h1>

    <?php if(!empty($errors)): ?>
        <?php foreach ($errors as $error): ?>
          <div class="alert alert-danger">
            <?php echo $error ?>
          </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if($product['image']): ?>
      <img src="<?php echo $product['image'] ?>">
    <?php endif; ?>

    <!-- leaving action empty = submitting to same file -->
    <form action="" method="POST" enctype="multipart/form-data">
      <div class="mb-3">
        <label class="form-label">Product Image</label>
        <br>
        <input type="file" name="image">
      </div>
      <div class="mb-3">
        <label class="form-label">Product Title</label>
        <input type="text" class="form-control" name="title" value="<?php echo $title ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Product Description</label>
        <textarea class="form-control" name="description"><?php echo $description ?></textarea>
      </div>
      <div class="mb-3">
        <label class="form-label">Product Price</label>
        <input type="number" step="0.01" class="form-control" name="price" value="<?php echo $price ?>">
      </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    
  </body>
</html>
