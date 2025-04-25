<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ShopEasy - Mini E-Commerce</title>
        <link rel="stylesheet" href="./css/home.css">
    </head>



<?php 
session_start();

?>
    <body>

        <header>
            <div class="container">
                <div class="header-content">
                    <div class="logo">Shop<span>Easy</span></div>
                    <nav>
                        <ul>
                            <li>
                                <a href="cart.php" class="cart-icon">
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




        <!-- Products -->
        <section class="products" id="products">
            <div class="container">
                <h2 class="section-title">Products</h2>
                <div class="product-grid">

                <?php
$file = fopen("./dataset/product.csv", "r");
if ($file) {
    
    fgetcsv($file);
    
    while (($product = fgetcsv($file)) !== false) {
        
        if (count($product) >= 5) {
            
            $title = (isset($_GET['title']) && $_GET['title'] == $product[0]) ? $_GET['title'] : $product[0];
            $description = (isset($_GET['description']) && $_GET['description'] == $product[1]) ? $_GET['description'] : $product[1];
            $image = (isset($_GET['image']) && $_GET['image'] == $product[2]) ? $_GET['image'] : $product[2];
            $price = (isset($_GET['price']) && $_GET['price'] == $product[3]) ? $_GET['price'] : $product[3];
            $category = (isset($_GET['category']) && $_GET['category'] == $product[4]) ? $_GET['category'] : $product[4];
            ?>
            
            <div class="product-card">
                <div class="product-image">
                    <img src="<?php echo htmlspecialchars($image); ?>" 
                         alt="<?php echo htmlspecialchars($title); ?>">
                </div>
                <div class="product-info">
                    <h3 class="product-title"><?php echo htmlspecialchars($title); ?></h3>
                    <p class="product-price"><?php echo htmlspecialchars($price); ?> DH</p>
                    <p class="product-category"><?php echo htmlspecialchars($category); ?></p>
                    <a href="./item.php?title=<?php echo urlencode($title); ?>&description=<?php echo urlencode($description); ?>&price=<?php echo urlencode($price); ?>&image=<?php echo urlencode($image); ?>&category=<?php echo urlencode($category); ?>" 
                       class="add-to-cart">View Details</a>
                </div>
            </div>
            
            <?php
        }
    }
    fclose($file);
} else {
    echo "<p>Error: Could not open the products file.</p>";
}
?>

        </section>

        
        <footer>
            <div class="container">
                <div class="footer-content">
                    <div class="footer-section">
                        <h3>About Us</h3>
                        <p>ShopEasy is your one-stop shop for quality products at affordable prices. We're committed to
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