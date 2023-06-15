<?php
include 'connection.php';


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
    <div class="cart-container">
        <h1>سبد خرید</h1>
        <table>
            <thead>
                <tr>
                    <th>عکس</th>
                    <th>نام</th>
                    <th>قیمت</th>
                    <th>تعداد</th>
                    <th>مجموع قیمت</th>
                    <th>اکشن</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $select_cart = mysqli_query($conn, "SELECT * FROM `cart`");
                $grand_total = 0;

                if (mysqli_num_rows($select_cart) > 0) {
                    while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {

                        ?>
                        <tr>
                            <td> <img src="images/<?php echo $fetch_cart['image']; ?>" alt="عکس محصول"> </td>
                            <td>
                                <?php echo $fetch_cart['name']; ?>
                            </td>
                            <td>
                                <?php echo $fetch_cart['price']; ?>ت
                            </td>
                            <td class="quantity">
                                <form method="post">
                                    <input type="hidden" name="update_quantity_id" value="<?php echo $fetch_cart['id']; ?>">
                                    <input type="number" min="1" name="update_quantity"
                                        value="<?php echo $fetch_cart['quantity']; ?>">
                                    <input type="submit" name="update_btn" value="آپدیت">
                                </form>
                            </td>
                            <td>
                                <?php echo $sub_total = number_format($fetch_cart['price'] * $fetch_cart['quantity']) ?>ت
                            </td>
                            <td> <a href="cart.php?remove=<?php echo $fetch_cart['id']; ?>"
                                    onclick="return confirm('محصول از سبد خرید حذف شود؟ ');" class="delete-btn">حذف</a> </td>
                        </tr>
                        <?php
                        $grand_total = $sub_total;
                    }
                }
                ?>
                <tr class="table-bottom">
                    <td>
                        <a href="products.php" class="option-btn">ادامه فرآیند خرید</a>
                    </td>
                    <td colspan="3">
                        <h1>مجموع قابل پرداخت</h1>
                    </td>
                    <td style="font-weight: bold">
                        <?php echo $grand_total ?>ت
                    </td>
                    <td> <a href="cart.php?delete_all=<?php echo $fetch_cart['id']; ?>"
                            onclick="return confirm('کل سبد خرید پاک شود؟');" class="delete-btn">پاک کردن سبد خرید</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</body>

</html>