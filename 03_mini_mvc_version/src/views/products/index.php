<h1>Products List</h1>
  <p>
    <a href="/products/create" class="btn btn-success">Create Product</a>
  </p>

    <form>
      <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Search for products" name="search" value="<?php echo $search ?>">
        <button class="btn btn-outline-secondary" type="submit">search</button>
      </div>
    </form>

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Image</th>
      <th scope="col">Title</th>
      <th scope="col">Price</th>
      <th scope="col">Create Date</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($products as $i => $product): ?>
      <tr>
      <th scope="row"><?php echo $i + 1 ?></th>
      <td>
        <?php if($product['image']): ?>
          <img src="/<?php echo $product['image'] ?>" alt="<?php echo $product['title'] ?>">
        <?php endif; ?>
      </td>
      <td><?php echo $product['title'] ?></td>
      <td><?php echo $product['price'] ?></td>
      <td><?php echo $product['create_date'] ?></td>
      <td>
        <a href="/products/update?id=<?php echo $product['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
        <form style="display: inline-block" action="/products/delete" method="POST">
          <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
          <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
        </form>
      </td>
    </tr>
    <?php endforeach ?>
  </tbody>
</table>
