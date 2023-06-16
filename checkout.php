<?php
include 'connection.php';
if (isset($_POST['order_btn'])) {
    $name = $_POST['name'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $payment_method = $_POST['payment-method'];
    $flate = $_POST['flate'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $pin = $_POST['pin'];

    $cart_query = mysqli_query($conn, "SELECT * FROM `cart`");
    $price_total = 0;
    if (mysqli_num_rows($cart_query) > 0) {
        while ($product_item = mysqli_fetch_assoc($cart_query)) {
            $product_name[] = $product_item['name'] . ' (' . $product_item['quantity'] . ' )';
            $product_price = $product_item['price'] * $product_item['quantity'];
            $price_total += $product_price;
        }
    }
    $total_product = implode(', ', $product_name);
    $detail_query = mysqli_query($conn, "INSERT INTO `orders`( `name`, `number`, `email`, `method`, `flat`, `street`, `city`, `state`, `country`, `pin`, `total_products`, `total_price`) VALUES ('$name','$number','$email','$payment_method','$flate','$street','$city','$state','$country','$pin','$total_product','$price_total')");
    if ($cart_query && $detail_query) {
        echo "
        <div class='order-confirm-container'>
        <div class='message-container'>
            <h3>ممنون از خرید شما</h3>
            <div class='order-detail'>
                <span>".$total_product."</span>
                <span class='total'>مجموع:
                    ".$price_total."
                </span>
            </div>
            <div class='costomer-detail'>
                <p>نام: 
                    <span>".$name."</span>
                </p>
                <p>شماره تماس: 
                    <span>".$number."</span>
                </p>
                <p>ایمیل: 
                    <span>".$email."</span>
                </p>
                <p>آدرس: 
                    <span>".$country.",".$city.",".$state.",".$street.",".$flate.",".$pin."</span>
                </p>
                <p>روش ارسال: 
                    <span>".$payment_method."</span>
                </p>
                <p class='pay'>('پرداخت در محل')</p>
                <a href='products.php' class='btn'>ادامه خرید</a>
            </div>
        </div>
    </div>
        ";
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
    <title>افزودن محصولات</title>
</head>

<body>
   
    <?php include 'header.php'; ?>
    <div class="checkout-form">
        <h1>صفحه پرداخت</h1>
        <div class="display-order">
            <?php
            $select_cart = mysqli_query($conn, "SELECT * FROM `cart`");
            $total = 0;
            $grand_total = 0;
            if (mysqli_num_rows($select_cart) > 0) {
                while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                    $total_price = $fetch_cart['price'] * $fetch_cart['quantity'];
                    $grand_total = $total += $total_price;

                    ?>
                    <span>
                        <?= $fetch_cart['name']; ?>(
                        <?= $fetch_cart['quantity']; ?>)
                    </span>
                    <?php
                }
            }
            ?>
            <span class="grand-total">مجموع قابل پرداخت:
                <?= $grand_total; ?> ت
            </span>
        </div>
        <form method="post">
            <div class="input-field">
                <span>نام شما</span>
                <input type="text" name="name" placeholder="نام خود را وارد کنید" required>
            </div>
            <div class="input-field">
                <span>شماره شما</span>
                <input type="number" name="number" placeholder="شماره تماس خود را وارد کنید" required>
            </div>
            <div class="input-field">
                <span>ایمیل شما</span>
                <input type="email" name="email" placeholder="ایمیل خود را وارد کنید" required>
            </div>
            <div class="input-field">
                <span>روش ارسال</span>
                <select name="payment-method">
                    <option value="پرداخت در محل">پرداخت هنگام تحویل</option>
                    <option value="اعتباری">پرداخت اعتباری</option>
                </select>
            </div>
            <div class="input-field">
                <span>کوچه</span>
                <input type="text" name="flate" placeholder="کوچه" required>
            </div>
            <div class="input-field">
                <span>خیابان</span>
                <input type="text" name="street" placeholder="نام خیابان" required>
            </div>
            <div class="input-field">
                <span>شهر</span>
                <input type="text" name="city" placeholder="نام شهر" required>
            </div>
            <div class="input-field">
                <span>منطقه</span>
                <input type="text" name="state" placeholder="نام منطقه" required>
            </div>
            <div class="input-field">
                <span>کشور</span>
                <input type="text" name="country" placeholder="نام کشور" required>
            </div>
            <div class="input-field">
                <span>پلاک</span>
                <input type="number" name="pin" placeholder="شماره پلاک" required>
            </div>
            <input type="submit" name="order_btn" value="سفارش دهید" class="btn">

        </form>
    </div>
</body>

</html>