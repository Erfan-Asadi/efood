<?php 
    include 'connection.php';

    if(isset($_POST['add_product'])) {
        $name = $_POST['p_name'];
        $price = $_POST['p_price'];
        $p_image = $_FILES['p_image']['name'];
        $p_image_temp_name = $_FILES['p_image']['tmp_name'];
        $p_image_folder = 'image/'.$p_image;

        $query = "INSERT INTO `products`(`name`, `price`, `image`) VALUES ('$name','$price', '$p_image')";
        $insert_query = mysqli_query($conn, $query);

        if($insert_query) {
            move_uploaded_file($p_image_temp_name, $p_image_folder);
            $message[] = 'محصول با موفقیت افزوده شد.';
            header('location:admin.php');
        } else {
            $message[] = 'افزودن محصول با خطا مواجه شد.';
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
    <?php 
        if(isset($message)) {
            foreach ($message as $message) {
                echo '
                    <div class="message">
                        <span> '.$message.' <i class="bi bi-x"
                                    onclick="this.parentElement.style.display=`none`"></i>
                        </span>
                    </div>
                ';
            }
        }
    ?>
    <div class="form">
        <form method="post" enctype="multipart/form-data">
            <h3>افزودن محصول جدید </h3>
            <input type="text" name="p_name" placeholder="نام محصول" required>
            <input type="number" name="p_price" min="0" placeholder="قیمت محصول" required>
            <input type="file" name="p_image" accept="image/png, image/jpg, image/jpeg" required>
            <input type="submit" name="add_product" value="افزودن" class="btn submit-button">
        </form>
    </div>
</body>
</html>