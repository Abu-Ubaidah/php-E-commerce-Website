<?php
session_start();
include 'includes/books.php';

$checkout_message = ''; // ✅ Initialize to avoid warning

if (isset($_GET['checkout']) && $_GET['checkout'] === 'success') {
    $checkout_message = '✅ Your order has been placed successfully!';
}

// Remove item from cart
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    unset($_SESSION['cart'][$remove_id]);
    header("Location: cart.php");
    exit;
}


// Update quantities
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    foreach ($_POST['qty'] as $id => $newQty) {
        if (isset($_SESSION['cart'][$id])) {
            if ($newQty > 0) {
                $_SESSION['cart'][$id] = $newQty;
            } else {
                unset($_SESSION['cart'][$id]); // Remove if qty is 0
            }
        }
    }
    header("Location: cart.php");
    exit;
}

// Checkout (Simple COD simulation)
if (isset($_POST['checkout'])) {
    if (isset($_POST['cod'])) {
        $_SESSION['cart'] = [];
        $_SESSION['order_placed'] = true;
        header("Location: index.php?order=success");
        exit;
    } else {
        $checkout_message = "❌ Please select Cash on Delivery to proceed.";
    }
}



include 'includes/header.php';
?>

<main class="cart-page">
    <h1>Your Cart</h1>

    <?php if ($checkout_message): ?>
    <p class="checkout-message"><?= $checkout_message ?></p>
<?php endif; ?>


    <?php if (empty($_SESSION['cart'])): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <form method="POST">
            <table class="cart-table">
                <tr>
                    <th>Book</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
                <?php
                $total = 0;
                foreach ($_SESSION['cart'] as $id => $qty):
                    if (!isset($books[$id])) continue;
                    $item = $books[$id];
                    $subtotal = $item['price'] * $qty;
                    $total += $subtotal;
                ?>
                <tr>
                    <td><?= $item['title'] ?></td>
                    <td>Rs <?= $item['price'] ?></td>
                    <td>
                        <select name="qty[<?= $id ?>]">
                            <?php for ($i = 1; $i <= 10; $i++): ?>
                                <option value="<?= $i ?>" <?= $qty == $i ? 'selected' : '' ?>><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </td>
                    <td>Rs <?= $subtotal ?></td>
                    <td><a href="cart.php?remove=<?= $id ?>" class="remove-link">Remove</a></td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" align="right"><strong>Total:</strong></td>
                    <td colspan="2"><strong>Rs <?= $total ?></strong></td>
                </tr>
            </table>

            <div class="cart-buttons">
                <button type="submit" name="update">Update Cart</button>
            </div>
        </form>

        <form method="POST" class="checkout-form">
            <label><input type="checkbox" name="cod" value="1"> Cash on Delivery</label><br><br>
            <button type="submit" name="checkout">Place Order</button>
        </form>
    <?php endif; ?>
</main>

<?php include 'includes/footer.php'; ?>
