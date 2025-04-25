<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ShopEasy - Admin Products</title>
        <link rel="stylesheet" href="./css/admin.css">

    </head>

    <body>
        <div class="container">
            <div class="sidebar">
                <div class="sidebar-header">
                    <h3>ShopEasy Admin</h3>
                </div>

                <div class="sidebar-menu">
                    <ul>
                        <li><a href="#" style="background-color: rgba(255,255,255,0.1);">Products</a></li>
                    </ul>
                </div>

            </div>


            <div class="main-content">
                <div class="admin-header">
                    <h1>Product Management</h1>
                </div>

                <!-- Stats Cards -->
                <div class="stats-cards">
                    <div class="stat-card">
                        <h3>Total Products</h3>

                        <?php
                        $file = fopen("./dataset/product.csv", "r");
                        $totalProducts = 0;
                        while (!feof($file)) {
                            $product = fgetcsv($file);
                            if ($product) {
                                $totalProducts++;
                            }
                        }
                        fclose($file);
                        $totalProducts = $totalProducts - 1;
                        echo "<p id='productCount'>$totalProducts</p>";

                        ?>


                    </div>
                    <div class="stat-card">
                        <h3>Total Orders</h3>
                        <p id="orderCount">0</p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3>Add New Product</h3>
                        <br>
                    </div>

                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        $productName = $_POST['productName'];
                        $productDescription = $_POST['productDescription'];
                        $productPrice = $_POST['productPrice'];
                        $productCategory = $_POST['productCategory'];
                        $productImage = $_POST['productImage'];

                       
                        if (!empty($productName) && !empty($productDescription) && !empty($productPrice) && !empty($productCategory) && !empty($productImage)) {
                            $productName = htmlspecialchars($productName, ENT_QUOTES, 'UTF-8');
                            $productDescription = htmlspecialchars($productDescription, ENT_QUOTES, 'UTF-8');
                            $productPrice = floatval($productPrice);
                            $productCategory = htmlspecialchars($productCategory, ENT_QUOTES, 'UTF-8');
                            $productImage = filter_var($productImage, FILTER_VALIDATE_URL);

                            if ($productImage) {
                                if (!file_exists('./dataset')) {
                                    mkdir('./dataset', 0777, true);
                                }

                                $file = fopen('./dataset/product.csv', 'a');
                                if ($file) {
                                    fputcsv($file, [$productName, $productDescription, $productImage, $productPrice, $productCategory]);
                                    fclose($file);
                                    echo "<p style='color: green;'>Product added successfully!</p>";
                                } else {
                                    echo "<p style='color: red;'>Failed to open the file.</p>";
                                }
                            } else {
                                echo "<p style='color: red;'>Invalid product image URL.</p>";
                            }
                        } else {
                            echo "<p style='color: red;'>Please fill in all fields.</p>";
                        }
                    }
                    ?>
                    <div class="card-body">
                        <form method="POST" >
                            <div class="form-group">
                                <label for="productName">Product Name</label>
                                <input type="text" name="productName" class="form-control"
                                    placeholder="Enter product name">
                            </div>

                            <div class="form-group">
                                <label for="productDescription">Description</label>
                                <textarea name="productDescription" class="form-control"
                                    placeholder="Enter product description"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="productPrice">Price</label>
                                <input type="number" name="productPrice" class="form-control" placeholder="Enter price">
                            </div>

                            <div class="form-group">
                                <label for="productCategory">Category</label>
                                <select name="productCategory" class="form-control">
                                    <option value="">Select category</option>
                                    <option value="electronics">Electronics</option>
                                    <option value="clothing">Clothing</option>
                                    <option value="home">Home & Garden</option>
                                    <option value="books">Books</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="productImage">Product Image</label>
                                <input type="url" name="productImage" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-success" name="add-product" >Add Product</button>
                            <?php 
                            if (isset($_POST['add-product'])) {
                                header("Refresh:2");
                                exit;
                            }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </body>

</html>