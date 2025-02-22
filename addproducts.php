<!doctype html>
<html lang="en">

    
<!-- Mirrored from themesbrand.com/minia/layouts/form-elements.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 20 Jun 2024 05:56:17 GMT -->
<head>
        
        <meta charset="utf-8" />
        <title>Add Products | JK Fitness</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- preloader css -->
        <link rel="stylesheet" href="assets/css/preloader.min.css" type="text/css" />

        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

        <!-- Add SweetAlert2 CSS and JS -->
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <style>
        .product-thumb {
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }

        .product-thumb:hover {
            transform: scale(1.1);
        }

        .badge {
            padding: 5px 10px;
        }

        .table td {
            vertical-align: middle;
        }

        .btn-jk {
            background-color: #E31E24 !important; /* JK Fitness red */
            border-color: #E31E24 !important;
            color: #ffffff !important;
        }

        .btn-jk:hover {
            background-color: #c41920 !important; /* Slightly darker shade for hover */
            border-color: #c41920 !important;
        }

        .btn-jk:focus {
            box-shadow: 0 0 0 0.25rem rgba(227, 30, 36, 0.25) !important;
        }
        </style>

    </head>

    <body>

    <!-- <body data-layout="horizontal"> -->

        <!-- Begin page -->
        <div id="layout-wrapper">

        <?php include 'include/adminside.php'; ?>

            

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Add Products</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Products</a></li>
                                            <li class="breadcrumb-item active">Add Products</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                               
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                        <!-- Start row -->
                      
                        <!-- End row -->

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Add Product</h4>
                                        <p class="card-title-desc">Fill all information below</p>
                                    </div>
                                    <div class="card-body">
                                        <form id="productForm" enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <label class="form-label">Product Name</label>
                                                <input type="text" class="form-control" name="product_name" required placeholder="Enter Product Name">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Price</label>
                                                <input type="number" class="form-control" name="price" required placeholder="Enter Price">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Stock</label>
                                                <input type="number" class="form-control" name="stock" required placeholder="Enter Stock Quantity">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Description</label>
                                                <textarea class="form-control" name="description" rows="3" required placeholder="Enter Description"></textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Category</label>
                                                <select class="form-select" name="category" required>
                                                    <option value="">Select Category</option>
                                                    <?php
                                                    include 'include/db.php';
                                                    try {
                                                        $stmt = $pdo->query("SELECT * FROM categories ORDER BY category_name");
                                                        while ($row = $stmt->fetch()) {
                                                            echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['category_name']) . '</option>';
                                                        }
                                                    } catch(PDOException $e) {
                                                        echo '<option value="">Error loading categories</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Product Images (Select 1-5 images)</label>
                                                <input type="file" class="form-control" id="productImages" name="product_images[]" multiple accept="image/*" onchange="previewImages(this)" required>
                                                <small class="text-muted">You can select between 1 and 5 images</small>
                                                <div id="imagePreviewContainer" class="mt-3 d-flex flex-wrap gap-2">
                                                    <!-- Image previews will be displayed here -->
                                                </div>
                                            </div>

                                            <div>
                                                <button type="submit" class="btn btn-jk w-md">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                           
                        <!-- End Form Layout -->

                        

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Product List</h4>
                                        <p class="card-title-desc">Latest added products</p>
                                    </div>
                                    <div class="card-body">
                                        <!-- Filter Section -->
                                        <div class="row mb-3">
                                            <div class="col-sm-6 col-md-4">
                                                <div class="search-box me-2 mb-2 d-inline-block">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control" id="searchProduct" placeholder="Search Products...">
                                                        <i class="bx bx-search-alt search-icon"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <div class="d-flex align-items-center gap-2">
                                                    <select class="form-select form-select-sm" id="categoryFilter" style="width: auto;">
                                                        <option value="">All Categories</option>
                                                        <?php
                                                        try {
                                                            $stmt = $pdo->query("SELECT * FROM categories ORDER BY category_name");
                                                            while ($row = $stmt->fetch()) {
                                                                echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['category_name']) . '</option>';
                                                            }
                                                        } catch(PDOException $e) {
                                                            echo '<option value="">Error loading categories</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <button type="button" class="btn btn-sm btn-jk" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                                                        <i class="fas fa-plus"></i> Add Category
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Table Section -->
                                        <div class="table-responsive">
                                            <table class="table table-bordered mb-0" id="productTable">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Image</th>
                                                        <th>Product Name</th>
                                                        <th>Price</th>
                                                        <th>Stock</th>
                                                        <th>Category</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    try {
                                                        $query = "
                                                            SELECT p.*, c.category_name, 
                                                                   (SELECT image_path FROM product_images WHERE product_id = p.id LIMIT 1) as main_image 
                                                            FROM products p 
                                                            LEFT JOIN categories c ON p.category_id = c.id 
                                                            ORDER BY p.created_at DESC
                                                        ";
                                                        $stmt = $pdo->query($query);
                                                        while ($row = $stmt->fetch()) {
                                                            $imageHtml = $row['main_image'] ? 
                                                                '<img src="' . htmlspecialchars($row['main_image']) . '" class="product-thumb" alt="product image" style="width: 50px; height: 50px; object-fit: cover;">' : 
                                                                '<img src="assets/images/no-image.jpg" class="product-thumb" alt="no image" style="width: 50px; height: 50px; object-fit: cover;">';
                                                            
                                                            echo '<tr data-category="' . $row['category_id'] . '">';
                                                            echo '<td>' . $row['id'] . '</td>';
                                                            echo '<td>' . $imageHtml . '</td>';
                                                            echo '<td>' . htmlspecialchars($row['product_name']) . '</td>';
                                                            echo '<td>LKR' . number_format($row['price'], 2) . '</td>';
                                                            echo '<td>' . $row['stock'] . '</td>';
                                                            echo '<td>' . htmlspecialchars($row['category_name']) . '</td>';
                                                            echo '<td>
                                                                    <button class="btn btn-sm btn-jk edit-product" data-id="' . $row['id'] . '">
                                                                        <i class="fas fa-edit"></i>
                                                                    </button>
                                                                    <button class="btn btn-sm btn-jk delete-product" data-id="' . $row['id'] . '">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                  </td>';
                                                            echo '</tr>';
                                                        }
                                                    } catch(PDOException $e) {
                                                        echo '<tr><td colspan="7">Error loading products: ' . $e->getMessage() . '</td></tr>';
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

                
               
            </div>
            <!-- end main content-->

        </div>
        
        <div class="right-bar">
            <div data-simplebar class="h-100">
                <div class="rightbar-title d-flex align-items-center p-3">

                    <h5 class="m-0 me-2">Theme Customizer</h5>

                    <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                        <i class="mdi mdi-close noti-icon"></i>
                    </a>
                </div>

                <!-- Settings -->
                <hr class="m-0" />

                <div class="p-4">
                    <h6 class="mb-3">Layout</h6>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout"
                            id="layout-vertical" value="vertical">
                        <label class="form-check-label" for="layout-vertical">Vertical</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout"
                            id="layout-horizontal" value="horizontal">
                        <label class="form-check-label" for="layout-horizontal">Horizontal</label>
                    </div>

                    <h6 class="mt-4 mb-3 pt-2">Layout Mode</h6>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-mode"
                            id="layout-mode-light" value="light">
                        <label class="form-check-label" for="layout-mode-light">Light</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-mode"
                            id="layout-mode-dark" value="dark">
                        <label class="form-check-label" for="layout-mode-dark">Dark</label>
                    </div>

                    <h6 class="mt-4 mb-3 pt-2">Layout Width</h6>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-width"
                            id="layout-width-fuild" value="fuild" onchange="document.body.setAttribute('data-layout-size', 'fluid')">
                        <label class="form-check-label" for="layout-width-fuild">Fluid</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-width"
                            id="layout-width-boxed" value="boxed" onchange="document.body.setAttribute('data-layout-size', 'boxed')">
                        <label class="form-check-label" for="layout-width-boxed">Boxed</label>
                    </div>

                    <h6 class="mt-4 mb-3 pt-2">Layout Position</h6>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-position"
                            id="layout-position-fixed" value="fixed" onchange="document.body.setAttribute('data-layout-scrollable', 'false')">
                        <label class="form-check-label" for="layout-position-fixed">Fixed</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-position"
                            id="layout-position-scrollable" value="scrollable" onchange="document.body.setAttribute('data-layout-scrollable', 'true')">
                        <label class="form-check-label" for="layout-position-scrollable">Scrollable</label>
                    </div>

                    <h6 class="mt-4 mb-3 pt-2">Topbar Color</h6>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="topbar-color"
                            id="topbar-color-light" value="light" onchange="document.body.setAttribute('data-topbar', 'light')">
                        <label class="form-check-label" for="topbar-color-light">Light</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="topbar-color"
                            id="topbar-color-dark" value="dark" onchange="document.body.setAttribute('data-topbar', 'dark')">
                        <label class="form-check-label" for="topbar-color-dark">Dark</label>
                    </div>

                    <h6 class="mt-4 mb-3 pt-2 sidebar-setting">Sidebar Size</h6>

                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-size"
                            id="sidebar-size-default" value="default" onchange="document.body.setAttribute('data-sidebar-size', 'lg')">
                        <label class="form-check-label" for="sidebar-size-default">Default</label>
                    </div>
                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-size"
                            id="sidebar-size-compact" value="compact" onchange="document.body.setAttribute('data-sidebar-size', 'md')">
                        <label class="form-check-label" for="sidebar-size-compact">Compact</label>
                    </div>
                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-size"
                            id="sidebar-size-small" value="small" onchange="document.body.setAttribute('data-sidebar-size', 'sm')">
                        <label class="form-check-label" for="sidebar-size-small">Small (Icon View)</label>
                    </div>

                    <h6 class="mt-4 mb-3 pt-2 sidebar-setting">Sidebar Color</h6>

                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-color"
                            id="sidebar-color-light" value="light" onchange="document.body.setAttribute('data-sidebar', 'light')">
                        <label class="form-check-label" for="sidebar-color-light">Light</label>
                    </div>
                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-color"
                            id="sidebar-color-dark" value="dark" onchange="document.body.setAttribute('data-sidebar', 'dark')">
                        <label class="form-check-label" for="sidebar-color-dark">Dark</label>
                    </div>
                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-color"
                            id="sidebar-color-brand" value="brand" onchange="document.body.setAttribute('data-sidebar', 'brand')">
                        <label class="form-check-label" for="sidebar-color-brand">Brand</label>
                    </div>

                    <h6 class="mt-4 mb-3 pt-2">Direction</h6>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-direction"
                            id="layout-direction-ltr" value="ltr">
                        <label class="form-check-label" for="layout-direction-ltr">LTR</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-direction"
                            id="layout-direction-rtl" value="rtl">
                        <label class="form-check-label" for="layout-direction-rtl">RTL</label>
                    </div>

                </div>

            </div> <!-- end slimscroll-menu-->
        </div>
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->
        <script src="assets/libs/jquery/jquery.min.js"></script>
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/node-waves/waves.min.js"></script>
        <script src="assets/libs/feather-icons/feather.min.js"></script>
        <!-- pace js -->
        <script src="assets/libs/pace-js/pace.min.js"></script>

        <script src="assets/js/app.js"></script>

        <script>
        $(document).ready(function() {
            // Search functionality
            $("#searchProduct").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#productTable tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            // Category filter
            $("#categoryFilter").on("change", function() {
                var selectedCategory = $(this).val();
                if (selectedCategory === "") {
                    // Show all rows if no category is selected
                    $("#productTable tbody tr").show();
                } else {
                    // Hide all rows first
                    $("#productTable tbody tr").hide();
                    // Show only rows matching the selected category
                    $("#productTable tbody tr[data-category='" + selectedCategory + "']").show();
                }
            });

            // Delete product handler
            $(".delete-product").on("click", function() {
                var productId = $(this).data('id');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Send delete request
                        $.ajax({
                            url: 'delete_product.php',
                            type: 'POST',
                            data: { id: productId },
                            success: function(response) {
                                try {
                                    const result = JSON.parse(response);
                                    if (result.status === 'success') {
                                        Swal.fire({
                                            title: 'Deleted!',
                                            text: 'Product has been deleted.',
                                            icon: 'success',
                                            timer: 2000,
                                            showConfirmButton: false
                                        }).then(() => {
                                            location.reload();
                                        });
                                    } else {
                                        throw new Error(result.message);
                                    }
                                } catch (error) {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: error.message,
                                        icon: 'error',
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                }
                            }
                        });
                    }
                });
            });

            // Edit product handler
            $(".edit-product").on("click", function() {
                var productId = $(this).data('id');
                
                // Show loading state
                Swal.fire({
                    title: 'Loading...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Fetch product details
                $.ajax({
                    url: 'get_product.php',
                    type: 'POST',
                    data: { id: productId },
                    success: function(response) {
                        Swal.close();
                        try {
                            const product = JSON.parse(response);
                            
                            // Fill the form with product details
                            $('#edit_product_id').val(product.id);
                            $('#edit_product_name').val(product.product_name);
                            $('#edit_price').val(product.price);
                            $('#edit_stock').val(product.stock);
                            $('#edit_description').val(product.description);
                            $('#edit_category').val(product.category_id);

                            // Display current images
                            const currentImages = $('#currentImages');
                            currentImages.empty();
                            product.images.forEach(function(image) {
                                const imgWrapper = $('<div class="position-relative">');
                                imgWrapper.append(`
                                    <img src="${image.path}" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0" 
                                            onclick="deleteImage(${image.id}, this)">×</button>
                                `);
                                currentImages.append(imgWrapper);
                            });

                            // Show the modal
                            $('#editProductModal').modal('show');
                        } catch (error) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Failed to load product details',
                                icon: 'error',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    }
                });
            });

            // Update product handler
            $("#updateProduct").on("click", function() {
                const formData = new FormData($("#editProductForm")[0]);
                
                Swal.fire({
                    title: 'Updating...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: 'update_product.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        try {
                            const result = JSON.parse(response);
                            if (result.status === 'success') {
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Product updated successfully',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    $('#editProductModal').modal('hide');
                                    location.reload();
                                });
                            } else {
                                throw new Error(result.message);
                            }
                        } catch (error) {
                            Swal.fire({
                                title: 'Error!',
                                text: error.message,
                                icon: 'error',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    }
                });
            });
        });
        </script>

        <script>
        function previewImages(input) {
            const previewContainer = document.getElementById('imagePreviewContainer');
            previewContainer.innerHTML = '';
            
            if (input.files.length > 5) {
                Swal.fire({
                    title: 'Error!',
                    text: 'You can only select up to 5 images',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: false
                });
                input.value = '';
                return;
            }
            
            if (input.files.length < 1) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Please select at least 1 image',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: false
                });
                return;
            }

            for (let i = 0; i < input.files.length; i++) {
                const file = input.files[i];
                if (file) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        const previewWrapper = document.createElement('div');
                        previewWrapper.className = 'position-relative';
                        
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'img-thumbnail';
                        img.style.width = '100px';
                        img.style.height = '100px';
                        img.style.objectFit = 'cover';
                        
                        const removeBtn = document.createElement('button');
                        removeBtn.innerHTML = '×';
                        removeBtn.className = 'btn btn-danger btn-sm position-absolute top-0 end-0';
                        removeBtn.style.padding = '0 6px';
                        removeBtn.onclick = function() {
                            previewWrapper.remove();
                            // Clear the file input if all previews are removed
                            if (previewContainer.children.length === 0) {
                                input.value = '';
                            }
                        };
                        
                        previewWrapper.appendChild(img);
                        previewWrapper.appendChild(removeBtn);
                        previewContainer.appendChild(previewWrapper);
                    };
                    
                    reader.readAsDataURL(file);
                }
            }
        }
        </script>

        <script>
        // Add form submission handler
        $(document).ready(function() {
            $('#productForm').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);

                // Show loading state
                Swal.fire({
                    title: 'Processing...',
                    text: 'Please wait while we save the product',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: 'process_product.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        try {
                            const result = JSON.parse(response);
                            if (result.status === 'success') {
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Product added successfully',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    // Reset form and preview
                                    $('#productForm')[0].reset();
                                    $('#imagePreviewContainer').empty();
                                    // Optionally refresh product list
                                    location.reload();
                                });
                            } else {
                                throw new Error(result.message || 'Unknown error occurred');
                            }
                        } catch (error) {
                            Swal.fire({
                                title: 'Error!',
                                text: error.message,
                                icon: 'error',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Server error occurred',
                            icon: 'error',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });
            });
        });
        </script>

        <!-- Add Edit Modal -->
        <div class="modal fade" id="editProductModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editProductForm" enctype="multipart/form-data">
                            <input type="hidden" name="product_id" id="edit_product_id">
                            
                            <div class="mb-3">
                                <label class="form-label">Product Name</label>
                                <input type="text" class="form-control" name="product_name" id="edit_product_name" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Price</label>
                                <input type="number" class="form-control" name="price" id="edit_price" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Stock</label>
                                <input type="number" class="form-control" name="stock" id="edit_stock" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="edit_description" rows="3" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Category</label>
                                <select class="form-select" name="category" id="edit_category" required>
                                    <?php
                                    try {
                                        $stmt = $pdo->query("SELECT * FROM categories ORDER BY category_name");
                                        while ($row = $stmt->fetch()) {
                                            echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['category_name']) . '</option>';
                                        }
                                    } catch(PDOException $e) {
                                        echo '<option value="">Error loading categories</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Current Images</label>
                                <div id="currentImages" class="d-flex flex-wrap gap-2 mb-2"></div>
                                
                                <label class="form-label">Add New Images (Optional)</label>
                                <input type="file" class="form-control" name="new_images[]" multiple accept="image/*" onchange="previewNewImages(this)">
                                <div id="newImagePreview" class="d-flex flex-wrap gap-2 mt-2"></div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-jk" id="updateProduct">Update Product</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
        function deleteImage(imageId, element) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'delete_image.php',
                        type: 'POST',
                        data: { image_id: imageId },
                        success: function(response) {
                            try {
                                const result = JSON.parse(response);
                                if (result.status === 'success') {
                                    $(element).parent().remove();
                                    Swal.fire({
                                        title: 'Deleted!',
                                        text: 'Image has been deleted.',
                                        icon: 'success',
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                } else {
                                    throw new Error(result.message);
                                }
                            } catch (error) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: error.message,
                                    icon: 'error',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            }
                        }
                    });
                }
            });
        }

        function previewNewImages(input) {
            const preview = $('#newImagePreview');
            preview.empty();
            
            if (input.files.length > 5) {
                Swal.fire({
                    title: 'Error!',
                    text: 'You can only select up to 5 images',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: false
                });
                input.value = '';
                return;
            }

            for (let i = 0; i < input.files.length; i++) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgWrapper = $('<div class="position-relative">');
                    imgWrapper.append(`
                        <img src="${e.target.result}" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0" 
                                onclick="$(this).parent().remove()">×</button>
                    `);
                    preview.append(imgWrapper);
                };
                reader.readAsDataURL(input.files[i]);
            }
        }
        </script>

        <!-- Add Category Modal -->
        <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addCategoryForm">
                            <div class="mb-3">
                                <label class="form-label">Category Name</label>
                                <input type="text" class="form-control" name="category_name" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-jk" id="saveCategoryBtn">Save Category</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add this JavaScript -->
        <script>
        $(document).ready(function() {
            // Save category handler
            $("#saveCategoryBtn").on("click", function() {
                const categoryName = $("#addCategoryForm input[name='category_name']").val();
                
                if (!categoryName) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Category name is required',
                        icon: 'error',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    return;
                }

                Swal.fire({
                    title: 'Saving...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: 'add_category.php',
                    type: 'POST',
                    data: { category_name: categoryName },
                    success: function(response) {
                        try {
                            const result = JSON.parse(response);
                            if (result.status === 'success') {
                                // Add new option to all category select elements
                                const newOption = new Option(categoryName, result.category_id);
                                $('#categoryFilter').append(newOption);
                                $('#edit_category').append(newOption);
                                $('select[name="category"]').append(newOption);

                                // Reset form and close modal
                                $("#addCategoryForm")[0].reset();
                                $("#addCategoryModal").modal('hide');

                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Category added successfully',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            } else {
                                throw new Error(result.message);
                            }
                        } catch (error) {
                            Swal.fire({
                                title: 'Error!',
                                text: error.message,
                                icon: 'error',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    }
                });
            });
        });
        </script>

    </body>

<!-- Mirrored from themesbrand.com/minia/layouts/form-elements.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 20 Jun 2024 05:56:17 GMT -->
</html>
