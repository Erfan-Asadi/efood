<?php
include 'connection.php';

if (isset($_POST['add_to_cart'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $quantity = 1;
    
    $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name='$name'");
    if(mysqli_num_rows($select_cart)>0) {
        $message[] = 'محصول در سبد خرید موجود است.';
    } else {
        $query = "INSERT INTO `cart`(`name`, `price`, `image`, `quantity`) VALUES ('$name','$price', '$image', '$quantity')";
        $insert_query = mysqli_query($conn, $query);
        
        $message[] = 'محصول به سبد خرید اضافه شد.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
    <title>محصولات</title>
</head>

<body>
    <?php include 'header.php'; ?>
    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '
                    <div class="message" >
                        <span onclick="this.parentElement.style.display=`none`"> ' . $message . ' <i class="bi bi-x"></i>
                        </span>
                    </div>
                ';
        }
    }
    ?>
    <section class="product-container">
        <h1>آخرین محصولات</h1>
        <div class="product-item-container">
            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `products`");
            if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($select_products)) {

                    ?>
                    <form method="post">
                        <div class="box">
                            <img src="images/<?php echo $fetch_products['image']; ?>" alt="">
                            <h3><?php echo $fetch_products['name']; ?></h3>
                            <div class="price"><?php echo $fetch_products['price']; ?>ت</div>
                            <input type="hidden" name="name" value="<?php echo $fetch_products['name']; ?>">
                            <input type="hidden" name="price" value="<?php echo $fetch_products['price']; ?>">
                            <input type="hidden" name="image" value="<?php echo $fetch_products['image']; ?>">
                            <input type="submit" name="add_to_cart" value="افزودن به سبد خرید" class="btn add-to-cart">
                        </div>
                    </form>
                <?php
                }
            }
            ?>
        </div>
    </section>
</body>

</html>