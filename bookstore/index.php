<?php
session_start();
include 'includes/books.php';


// Add to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_id'])) {
    $book_id = $_POST['book_id'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$book_id])) {
        $_SESSION['cart'][$book_id]++;
    } else {
        $_SESSION['cart'][$book_id] = 1;
    }

    header("Location: index.php?added=$book_id");
    exit;
}

include 'includes/header.php';
?>
<?php if (isset($_GET['order']) && $_GET['order'] === 'success'): ?>
    <p class="checkout-message success">
        ✅ Thank you! Your order has been placed successfully. We will contact you soon.
    </p>
<?php endif; ?>


<main>
    <?php if (isset($_GET['added'])): ?>
        <p class="checkout-message">✅ Book added to cart!</p>
    <?php endif; ?>

    <h1>Explore Our Books</h1>
    <div class="book-grid">
        <?php foreach ($books as $id => $book): ?>
            <div class="book-card">
                <img src="<?= $book['image'] ?>" alt="<?= $book['title'] ?>">
                <h2><?= $book['title'] ?></h2>
                <p>Rs <?= $book['price'] ?></p>
                <form method="post">
                    <input type="hidden" name="book_id" value="<?= $id ?>">
                    <button type="submit">Add to Cart</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
