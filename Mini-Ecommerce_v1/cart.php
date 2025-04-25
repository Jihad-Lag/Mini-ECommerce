<?php
session_start();


if (isset($_GET['remove_from_cart'])) {
    $product_id = $_GET['remove_from_cart'];
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
}



$subtotal = 0;
foreach ($_SESSION['cart'] as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}
$tax = $subtotal * 0.1;
$total = $subtotal + $tax;
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Your Shopping Cart</title>
        <link rel="stylesheet" href="./css/cart.css">
    </head>

    <body>
        <header>
            <div class="container">
                <div class="header-content">
                    <div class="logo">Shop<span>Easy</span></div>

                </div>
            </div>
        </header>
        <br>
        <div class="cart-container">
            <h1>Your Shopping Cart - ShopEasy</h1>

            <?php if (!empty($_SESSION['cart'])): ?>
                <form method="post" action="cart.php">
                    <table class="cart-items">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($_SESSION['cart'] as $product_id => $item): ?>
                                <tr>
                                    <td>
                                        <div class="product-info">
                                            <img src="<?= htmlspecialchars($item['image']) ?>"
                                                alt="<?= htmlspecialchars($item['name']) ?>" class="product-image">
                                            <span><?= htmlspecialchars($item['name']) ?></span>
                                        </div>
                                    </td>
                                    <td><?= number_format($item['price'], 2) ?> DH</td>
                                    <td>
                                        <p class="quantity-display"><?= $item['quantity'] ?></p>
                                    </td>
                                    <td><?= number_format($item['price'] * $item['quantity'], 2) ?> DH</td>
                                    <td>
                                        <a href="cart.php?remove_from_cart=<?= $product_id ?>" class="remove-btn">Remove</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </form>

                <div class="cart-summary">
                    <h3>Order Summary</h3>
                    <p>Subtotal: <?= number_format($subtotal, 2) ?> DH</p>
                    <p>Tax (10%): <?= number_format($tax, 2) ?> DH</p>
                    <p><strong>Total: <?= number_format($total, 2) ?> DH</strong></p>
                    <br>
                    <a href="home.php" class="checkout-btn">Continue Shopping</a>
                </div>
            <?php else: ?>
                <div class="empty-cart">
                    <h2>Your cart is empty</h2>
                    <p>Continue shopping to add items to your cart</p>
                    <br>
                    <a href="home.php" class="checkout-btn">Continue Shopping</a>
                </div>
            <?php endif; ?>
        </div>
        <footer>
            <div class="container">
                <div class="footer-content">
                    <div class="footer-section">
                        <h3>About Us</h3>
                        <p>ShopEasy is your one-stop shop for quality products at affordable prices. We're committed to
                            customer satisfaction.</p>
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