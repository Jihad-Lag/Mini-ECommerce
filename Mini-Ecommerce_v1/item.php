<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add-to-cart'])) {
    $item = [
        'title' => $_POST['title'] ?? '',
        'description' => $_POST['description'] ?? '',
        'price' => $_POST['price'] ?? 0,
        'category' => $_POST['category'] ?? '',
        'image' => $_POST['image'] ?? '',
        'quantity' => $_POST['quantity'] ?? 1,
    ];
    $_SESSION['cart'][] = $item;
     
    header("Location: ".$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details | ShopEasy</title>
    <link rel="stylesheet" href="./css/item.css">
</head>

<body>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">Shop<span>Easy</span></div>
                <nav>
                    <ul>
                        <li>
                        <a href="./home.php">Products</a>
                        </li>
                  
                        <li>

                            <a href="./cart.php" class="cart-icon">
                                🛒
                                <?php
                                    $totalProducts = 0;
                                    foreach ($_SESSION['cart'] as $item) {
                                        if (!empty($item)) {
                                            $totalProducts++;
                                            echo "<span class='cart-count'>$totalProducts</span>";
                                        }
                                        else {
                                            echo "<span class='cart-count'>$totalProducts</span>";
                                        }
                                    }

                                    ?>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

   
    <div class="container">
        <div class="product-details">
            <div class="product-gallery">
                <img id="mainImage" src="<?php echo htmlspecialchars($_GET['image'] ?? ''); ?>" alt="<?php echo htmlspecialchars($_GET['title'] ?? ''); ?>" class="main-image">
            </div>
            <div class="product-info">
                <h1 class="product-title"><?php echo htmlspecialchars($_GET['title'] ?? ''); ?></h1>
                <div class="product-price"><?php echo htmlspecialchars($_GET['price'] ?? '0'); ?> DH</div>
                <div class="product-meta">
                    <span>Category: <?php echo htmlspecialchars($_GET['category'] ?? ''); ?></span>
                </div>
                <div class="product-description">
                    <p><?php echo htmlspecialchars($_GET['description'] ?? ''); ?></p>
                </div>

                <div class="product-actions">
                    <form method="POST">
                        <div class="quantity-selector">
                            <input type="number" name="quantity" value="1" min="1">
                        </div>
                        <br>
                        <input type="hidden" name="title" value="<?php echo htmlspecialchars($_GET['title'] ?? ''); ?>">
                        <input type="hidden" name="description" value="<?php echo htmlspecialchars($_GET['description'] ?? ''); ?>">
                        <input type="hidden" name="price" value="<?php echo htmlspecialchars($_GET['price'] ?? '0'); ?>">
                        <input type="hidden" name="category" value="<?php echo htmlspecialchars($_GET['category'] ?? ''); ?>">
                        <input type="hidden" name="image" value="<?php echo htmlspecialchars($_GET['image'] ?? ''); ?>">

                        <button class="btn btn-primary" name="add-to-cart" type="submit">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="related-products">
            <h2 class="section-title">You May Also Like</h2>
            <div class="product-grid">
                <?php
                $file = fopen("./dataset/product.csv", "r");
                $products = [];

                if ($file) {
                    fgetcsv($file); 

                    while (($product = fgetcsv($file)) !== false) {
                        $products[] = $product;
                    }
                    fclose($file);
                }

                $randomProducts = [];
                if (!empty($products)) {
                    $availableKeys = array_keys($products);
                    shuffle($availableKeys);
                    $selectedKeys = array_slice($availableKeys, 0, 4);

                    foreach ($selectedKeys as $key) {
                        $randomProducts[] = $products[$key];
                    }
                }

                foreach ($randomProducts as $index => $product) {
                    $title = $product[0] ?? '';
                    $description = $product[1] ?? '';
                    $image = $product[2] ?? '';
                    $price = $product[3] ?? '0';
                    $category = $product[4] ?? '';
                    ?>
                    <div class="product-card">
                        <div class="product-card-image">
                            <img src="<?php echo htmlspecialchars($image); ?>" alt="<?php echo htmlspecialchars($title); ?>">
                        </div>
                        <div class="product-card-info">
                            <h3 class="product-card-title"><?php echo htmlspecialchars($title); ?></h3>
                            <div class="product-card-price"><?php echo htmlspecialchars($price); ?> DH</div>
                            <a href="./item.php?title=<?php echo urlencode($title); ?>&description=<?php echo urlencode($description); ?>&price=<?php echo urlencode($price); ?>&image=<?php echo urlencode($image); ?>&category=<?php echo urlencode($category); ?>"
                                class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                    <?php
                }

                $remainingProducts = 4 - count($randomProducts);
                for ($i = 0; $i < $remainingProducts; $i++) {
                    ?>
                    <div class="product-card">
                        <div class="product-card-image">
                            <img src="https://via.placeholder.com/300x300?text=No+Product" alt="No Product Available">
                        </div>
                        <div class="product-card-info">
                            <h3 class="product-card-title">Product Coming Soon</h3>
                            <div class="product-card-price">0.00 DH</div>
                            <a href="#" class="btn btn-primary" disabled>View Details</a>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>About Us</h3>
                    <p>ShopEasy is your one-stop shop for quality products at affordable prices. We're committed
                        to
                        customer satisfaction.</p>
                </div>
                <div class="footer-section">
                </div>
                <div class="footer-section">
                    <h3>Contact Info</h3>
                    <ul>
                        <li>Phone: +212 649991224</li>
                        <li>Email: jihad.lag.25@gmail.com</li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2025 ShopEasy. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>