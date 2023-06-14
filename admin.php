<?php
include 'connection.php';

// updating product
if (isset($_POST['update_product'])) {
    $update_p_id = $_POST['update_p_id'];
    $update_p_name = $_POST['update_p_name'];
    $update_p_price = $_POST['update_p_price'];
    $update_p_img = $_FILES['update_p_image']['name'];
    $update_p_tmp_name = $_FILES['update_p_image']['tmp_name'];
    $update_p_folder = 'images/'.$update_p_img;

    $update_query = mysqli_query($conn, " UPDATE `products` SET id='$update_p_id', name='$update_p_name', price='$update_p_price', image='$update_p_img' WHERE id= '$update_p_id' ") or die('query failed');
    if($update_query) {
        move_uploaded_file($update_p_tmp_name, $update_p_folder);
        $message[] = 'محصول با موفقیت ویرایش شد.';
        header('location:admin.php');
    } else {
        $message[] = 'ویرایش محصول موفقیت آمیز نبود.';
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
    <title>پنل ادمین</title>
</head>

<body>
    <?php include 'header.php'; ?>
    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '
                    <div class="message">
                        <span> ' . $message . ' <i class="bi bi-x"
                                    onclick="this.parentElement.style.display=`none`"></i>
                        </span>
                    </div>
                ';
        }
    }
    ?>
    <a href="product_form.php" class="add">+</a>
    <section class="show-product">
        <table class="product-table">
            <thead>
                <tr>
                    <th>عکس</th>
                    <th>نام</th>
                    <th>قیمت</th>
                    <th colspan="2">اکشن</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
                if (mysqli_num_rows($select_products) > 0) {
                    while ($row = mysqli_fetch_assoc($select_products)) {

                        ?>
                        <tr>
                            <td><img class="product-image" src="images/<?php echo $row['image']; ?>"></td>
                            <td>
                                <?php echo $row['name']; ?>
                            </td>
                            <td>
                                <?php echo $row['price']; ?>ت
                            </td>
                            <td>
                                <a title="حذف" href="admin.php?delete=<?php echo $row['id']; ?>" class="delete-btn"
                                    onclick="return confirm('از حذف محصول اطمینان دارید؟')">
                                    <i class="bi bi-trash"></i>
                                    حذف
                                </a>
                            </td>
                            <td>
                                <a title="ویرایش" href="admin.php?edit=<?php echo $row['id']; ?>" class="option-btn">
                                    <i class="bi bi-pencil"></i>
                                    ویرایش
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </section>
    <section class="edit-form">
        <?php
        if (isset($_GET['edit'])) {
            $edit_id = $_GET['edit'];
            $edit_query = mysqli_query($conn, "SELECT * FROM `products` where id=$edit_id") or die('query failed');

            if (mysqli_num_rows($edit_query) > 0) {
                while ($fetch_edit = mysqli_fetch_assoc($edit_query)) {

                    ?>
                    <form method="post" enctype="multipart/form-data">
                        <h3>ویرایش محصول</h3>
                        <img class="product-image" src="images/<?php echo $fetch_edit['image']; ?>" alt="">
                        <input type="hidden" name="update_p_id" value="<?php echo $fetch_edit['id']; ?>">
                        <input type="text" name="update_p_name" value="<?php echo $fetch_edit['name']; ?>" required>
                        <input type="number" name="update_p_price" min="0" value="<?php echo $fetch_edit['price']; ?>" required>
                        <input type="file" name="update_p_image" accept="image/png, image/jpg, image/jpeg" required>
                        <input type="submit" name="update_product" value="ثبت ویرایش" class="btn submit-button update">
                        <input type="reset" value="لغو" class="btn cancel" id="close-edit">
                    </form>
                    <?php
                }
            }
            echo "<script>document.querySelector('.edit-form').style.display= 'flex';</script>";
        }
        ?>
    </section>
    <script type="text/javascript">
        const closeButton = document.querySelector('#close-edit');
        closeButton.addEventListener('click', () => {
            document.querySelector('.edit-form').style.display = 'none';
        })
    </script>
</body>

</html>