<?php
include 'connection.php';

if (isset($_POST['update_btn'])) {
    $update_value = $_POST['update_quantity'];
    $update_id = $_POST['update_quantity_id'];

    $update_query = mysqli_query($conn, "UPDATE `cart` SET  quantity='$update_value' WHERE id='$update_id'") or die('query failed');
    if ($update_query) {
        header('location:cart.php');
    }
}
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    mysqli_query($conn, "DELETE FROM `cart` WHERE id='$remove_id'");
    header('location:cart.php');
}
if (isset($_GET['delete_all'])) {
    mysqli_query($conn, "DELETE FROM `cart`");
    header('location:cart.php');
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
                                <?php echo $sub_total = $fetch_cart['price'] * $fetch_cart['quantity']; ?>ت
                            </td>
                            <td> <a href="cart.php?remove=<?php echo $fetch_cart['id']; ?>"
                                    onclick="return confirm('محصول از سبد خرید حذف شود؟ ');" class="delete-btn">حذف</a> </td>
                        </tr>
                        <?php
                        $grand_total += $sub_total;
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
                        <?php echo number_format($grand_total) ?>ت
                    </td>
                    <td> <a href="cart.php?delete_all"
                            onclick="return confirm('کل سبد خرید پاک شود؟');" class="delete-btn">حذف همه</a>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="checkout-btn">
            <a href="checkout.php" class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>">پرداخت</a>
        </div>
    </div>

</body>

</html>