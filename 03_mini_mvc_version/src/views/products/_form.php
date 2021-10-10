<p>
  <a href="/products" class="btn btn-secondary">Go back to products</a>
</p>

<?php if(!empty($errors)): ?>
  <?php foreach ($errors as $error): ?>
    <div class="alert alert-danger">
      <?php echo $error ?>
    </div>
  <?php endforeach; ?>
<?php endif; ?>

<?php if($product['image']): ?>
<img src="/<?php echo $product['image'] ?>">
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
  <input type="text" class="form-control" name="title" value="<?php echo $product['title'] ?>">
</div>

<div class="mb-3">
  <label class="form-label">Product Description</label>
  <textarea class="form-control" name="description"><?php echo $product['description'] ?></textarea>
</div>

<div class="mb-3">
  <label class="form-label">Product Price</label>
  <input type="number" step="0.01" class="form-control" name="price" value="<?php echo $product['price'] ?>">
</div>

  <button type="submit" class="btn btn-primary">Submit</button>
</form>
