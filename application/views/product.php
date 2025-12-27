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
        <div class="row">
            <div class="col-md-8">
                <input type="text" id="search" class="form-control" placeholder="Search by name or category">
            </div>
            <div class="col-md-4">
                <button id="toggleDeleted" class="btn btn-warning btn-block">
                    View Deleted
                </button>
            </div>
        </div>

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
                        <input type="text" id="product_code" name="product_code" class="form-control" placeholder="Product Code" required><br>
                        <input type="text" id="product_name" name="product_name" class="form-control" placeholder="Product Name" required><br>
                        <input type="text" id="category" name="category" class="form-control" placeholder="Category"><br>
                        <input type="number" id="price" name="price" class="form-control" placeholder="Price" required><br>
                        <input type="number" id="stock_quantity" name="stock_quantity" class="form-control" placeholder="Stock"><br>
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
        let viewType = 'active';
        $(document).ready(function() {

            loadProducts();

            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                let page = $(this).text();
                loadProducts(page);
            });

            $("#search").keyup(function() {
                loadProducts(1);
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

        $(document).on('click', '.delete', function() {

            if (!confirm("Are you sure you want to delete this product?")) {
                return;
            }

            let id = $(this).data('id');

            $.ajax({
                url: "<?= base_url('Welcome/delete_product/') ?>" + id,
                type: "GET",
                dataType: "json",
                success: function(res) {

                    if (res.status) {
                        loadProducts();
                        showAlert('success', res.message);
                    } else {
                        showAlert('danger', res.message);
                    }
                },
                error: function() {
                    showAlert('danger', 'Server error. Please try again.');
                }
            });
        });

        $("#toggleDeleted").click(function() {

            if (viewType === 'active') {
                viewType = 'deleted';
                $(this).text('View Active')
                    .removeClass('btn-warning')
                    .addClass('btn-primary');
            } else {
                viewType = 'active';
                $(this).text('View Deleted')
                    .removeClass('btn-primary')
                    .addClass('btn-warning');
            }

            loadProducts();
        });

        $(document).on('click', '.restore', function() {

            if (!confirm('Restore this product?')) return;

            let id = $(this).data('id');

            $.ajax({
                url: "<?= base_url('Welcome/restore_product/') ?>" + id,
                type: "GET",
                dataType: "json",
                success: function(res) {
                    if (res.status) {
                        showAlert('success', res.message);
                        loadProducts();
                    } else {
                        showAlert('danger', res.message);
                    }
                }
            });
        });


        $(document).on('click', '.edit', function() {

            $("#id").val($(this).data('id'));
            $("#product_code").val($(this).data('code'));
            $("#product_name").val($(this).data('name'));
            $("#category").val($(this).data('category'));
            $("#price").val($(this).data('price'));
            $("#stock_quantity").val($(this).data('stock'));

            $("#productModal").modal('show');
        });

        function loadProducts(page = 1) {
            let search = $("#search").val();

            $.ajax({
                url: "<?= base_url('Welcome/get_products') ?>",
                data: {
                    page: page,
                    search: search,
                    type: viewType
                },
                dataType: "json",
                success: function(res) {
                    let rows = '';
                    if (res.length === 0) {
                        rows = `<tr><td colspan="6" class="text-center">No records found</td></tr>`;
                    }
                    $.each(res.products, function(i, p) {

                        let actionBtn = '';

                        if (viewType === 'deleted') {
                            actionBtn = `
                        <button class="btn btn-success btn-xs restore" data-id="${p.id}">
                            Restore
                        </button>`;
                        } else {
                            actionBtn = `
                       <button class="btn btn-info btn-xs edit"
                            data-id="${p.id}"
                            data-code="${p.product_code}"
                            data-name="${p.product_name}"
                            data-category="${p.category}"
                            data-price="${p.price}"
                            data-stock="${p.stock_quantity}">
                            Edit
                        </button>
                            <button class="btn btn-danger btn-xs delete" data-id="${p.id}">Delete</button>
                       `;
                        }

                        rows += `
                    <tr>
                        <td>${p.product_code}</td>
                        <td>${p.product_name}</td>
                        <td>${p.category}</td>
                        <td>${p.price}</td>
                        <td>${p.stock_quantity}</td>
                        <td>${actionBtn}</td>
                        
                    </tr>`;
                    });

                    $("#productTable").html(rows);
                    $("#pagination").html(res.pagination);
                }
            });
        }

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