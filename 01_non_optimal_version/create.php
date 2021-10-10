<?php 
  
  //making connection to mySQL db
  $pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud','root','');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $errors = [];

  $title = '';
  $description = '';
  $price = '';

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
    $date = date('Y-m-d H:i:s');

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
      $imagePath = '';

      if($image && $image['tmp_name']) {

        $imagePath = 'images/'.randomString(8).'/'.$image['name'];
        mkdir(dirname($imagePath));

        move_uploaded_file($image['tmp_name'], $imagePath);
      }

      $statement = $pdo->prepare("INSERT INTO products (title, description, image, price, create_date)
        VALUES (:title, :description, :image, :price, :date)");

      $statement->bindValue(':title', $title);
      $statement->bindValue(':description', $description);
      $statement->bindValue(':image', $imagePath);
      $statement->bindValue(':price', $price);
      $statement->bindValue(':date', $date);

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
    <h1>Create New Product</h1>

    <?php if(!empty($errors)): ?>
        <?php foreach ($errors as $error): ?>
          <div class="alert alert-danger">
            <?php echo $error ?>
          </div>
        <?php endforeach; ?>
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
