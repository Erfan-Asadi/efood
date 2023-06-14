<header>
    <a href="" class="logo">ایفود </a>
    <nav class="navbar">
        <ul>
            <li>
                <a href="admin.php">مشاهده محصولات</a>
            </li>
            <li>
                <a href="products.php">فروشگاه</a>
            </li>
        </ul>
    </nav>
    <?php 
        $select_rows = mysqli_query($conn, "SELECT * FROM `cart`") or die('query failed');
        $row_count = mysqli_num_rows($select_rows);
    ?>
    <a href="cart.php" class="cart">
        <i class="bi bi-cart-check-fill"></i>
        <span><?php echo $row_count; ?></span>
    </a>
</header>