<!DOCTYPE html>
<html>
<head>
    <title>Mini Inventory Manager</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h3 class="text-center">Mini Inventory Manager</h3>

    <input type="text" id="search" class="form-control" placeholder="Search by name or category">

    <br>
    <button class="btn btn-success" data-toggle="modal" data-target="#productModal">Add Product</button>

    <br><br>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="productTable"></tbody>
    </table>
</div>

<div id="productModal" class="modal fade">
  <div class="modal-dialog">
    <form id="productForm">
      <div class="modal-content">
        <div class="modal-header">
          <h4>Add / Edit Product</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="id">
          <input type="text" name="product_code" class="form-control" placeholder="Product Code" required><br>
          <input type="text" name="product_name" class="form-control" placeholder="Product Name" required><br>
          <input type="text" name="category" class="form-control" placeholder="Category"><br>
          <input type="number" name="price" class="form-control" placeholder="Price" required><br>
          <input type="number" name="stock_quantity" class="form-control" placeholder="Stock"><br>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save</button>
          <button class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

