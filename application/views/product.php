<!DOCTYPE html>
<html>

<head>
    <title>Mini Inventory Manager</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>

<body>

    <div class="container">
        <h3 class="text-center">Mini Inventory Manager</h3>
        <div id="alertBox" style="display:none;" class="alert"></div>
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
        <div id="pagination"></div>
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

    <script>
        $(document).ready(function() {

            function loadProducts(page = 1) {
                let search = $("#search").val();

                $.ajax({
                    url: "<?= base_url('Welcome/get_products') ?>",
                    data: {
                        page: page,
                        search: search
                    },
                    dataType: "json",
                    success: function(res) {
                        let rows = '';
                        $.each(res.products, function(i, p) {
                            rows += `
                    <tr>
                        <td>${p.product_code}</td>
                        <td>${p.product_name}</td>
                        <td>${p.category}</td>
                        <td>${p.price}</td>
                        <td>${p.stock_quantity}</td>
                        <td>
                            <button class="btn btn-danger btn-xs delete" data-id="${p.id}">Delete</button>
                        </td>
                    </tr>`;
                        });

                        $("#productTable").html(rows);
                        $("#pagination").html(res.pagination);
                    }
                });
            }

            loadProducts();

            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                let page = $(this).text();
                loadProducts(page);
            });

            $("#productForm").submit(function(e) {
                e.preventDefault();

                $.ajax({
                    url: "<?= base_url('Welcome/save_product') ?>",
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(res) {

                        if (res.status) {
                            $("#productModal").modal('hide');
                            loadProducts();

                            showAlert('success', res.message);
                            $("#productForm")[0].reset();
                        } else {
                            showAlert('danger', res.message);
                        }
                    },
                    error: function() {
                        showAlert('danger', 'Something went wrong. Please try again.');
                    }
                });
            });


        });

        function showAlert(type, message) {
            $("#alertBox")
                .removeClass('alert-success alert-danger alert-warning')
                .addClass('alert-' + type)
                .html(message)
                .fadeIn();

            setTimeout(function() {
                $("#alertBox").fadeOut();
            }, 3000);
        }
    </script>