<?php
ob_start();
require "configs/connection.php";
require "configs/test.data.php";

###############################    SIGNIN       ################################

if (isset($_POST["signin"])) {
  $id         = TestData($_POST["id"]);
  $password   = TestData($_POST["password"]);
  $query      = mysqli_query($connection, "SELECT * FROM vendors WHERE vendor_phone ='$id' OR vendor_email='$id' AND vendor_password ='$password'  AND vendor_status ='active'") or die(mysqli_error($connection));
  $count      = mysqli_num_rows($query);
  if ($count == 1) {

    $data = mysqli_fetch_assoc($query);

    $alert  = "success";
    $msg    = "You have successfully signed in.";

    setcookie("CK_VENDOR_ID", $data["vendor_id"], time() + (86400 * 30), "/");
    setcookie("CK_VENDOR_NAME", $data["vendor_name"], time() + (86400 * 30), "/");

    $home = "dashboard";


?>
    <script type="text/javascript">
      setTimeout(function() {
        window.location = "<?php print($home) ?>";
      }, 3000);
    </script>
<?php
  } else {
    $alert  = "danger";
    $msg    = "Invalid login information, please try again.";
  }

  require "templates/alert.php";
}


//#####################################  USER REGISTRATION  ######################//

if (isset($_POST["addUser"])) {

  $fname                = TestData($_POST["fname"]);
  $lname                = TestData($_POST["lname"]);
  $phone                = TestData($_POST["phone"]);
  $email                = TestData($_POST["email"]);
  $role                 = TestData($_POST["role"]);

  // GENERATE PASSWORD

  $digits_needed = 6;
  $random_number = ''; // set up a blank string
  $count = 0;
  while ($count < $digits_needed) {
    $random_digit = mt_rand(0, 9);

    $random_number .= $random_digit;
    $count++;
  }

  $password             = $random_number;

  $query = mysqli_query($connection, "INSERT INTO `users` (`user_id`, `user_name`, `user_lname`, `user_fname`, `user_phone`, `user_email`, `user_password`, `user_role`, `user_status`) 
  VALUES (NULL, '$fname', '$lname', '$fname', '$phone', '$email', '$password', '$role', 'active')") or die(mysqli_error($connection));

  if ($query) {

    // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
    require("configs/deny.resubmit.php");
    // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

    $alert  = "success";
    $msg    = "You have successfully registered new user!";
    require("templates/alert.php");
  }
}

# ADD CATEGORY

if (isset($_POST["addCategory"])) {

  $categoryName               = TestData($_POST["categoryName"]);
  $categoryDescription        = TestData($_POST["categoryDescription"]);
  $top                        = TestData($_POST["top"]);

  $fileName                   = $_FILES["categoryImage"]["name"];
  $fileSize                   = $_FILES["categoryImage"]["size"] / 1024;
  $fileType                   = $_FILES["categoryImage"]["type"];
  $fileTmpName                = $_FILES["categoryImage"]["tmp_name"];

  if (
    $fileType == "image/png"
    || $fileType == "image/PNG"
    || $fileType == "image/JPG"
    || $fileType == "image/jpg"
    || $fileType == "image/jpeg"
    || $fileType == "image/JPEG"
    || $fileType == "image/gif"

  ) {

    //New file name
    $random = sha1(rand());
    $newFileName = $random . $fileName;

    //File upload path
    $uploadPath = "../catalog/categories/" . $newFileName;

    $newFileName = "catalog/categories/" . $newFileName;

    //function for upload file
    if (move_uploaded_file($fileTmpName, $uploadPath)) {

      $query = mysqli_query($connection, "INSERT INTO `categories` (`category_id`, `category_name`, `category_image`, `category_description`, `top_category`) 
      VALUES (NULL, '$categoryName', '', '$categoryDescription', '$top')") or die(mysqli_error($connection));

      if ($query) {

        // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
        require("configs/deny.resubmit.php");
        // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

        $alert  = "success";
        $msg    = "You have successfully registered new product!";
        require("templates/alert.php");
      }
    } else {
      $alert  = "danger";
      $msg    = "Something wrong happened";
      require("templates/alert.php");
    }
  } else {

    $alert  = "danger";
    $msg    = "Invalid image type!" . $fileType;
    require("templates/alert.php");
  }
}



# DELETE CATEGORY

if (isset($_GET["deleteCategory"])) {

  $categoryId      = TestData($_GET["deleteCategory"]);
  $query = mysqli_query($connection, "DELETE FROM `categories` WHERE `category_id` = '$categoryId'") or die(mysqli_error($connection));

  if ($query) {

    // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
    require("configs/deny.resubmit.php");
    // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

    $alert  = "success";
    $msg    = "You have successfully deleted category!";
    require("templates/alert.php");
  }
}


# ADD PRODUCT

if (isset($_POST["addProduct"])) {

  $productName                = TestData($_POST["productName"]);
  $productDescription         = TestData($_POST["productDescription"]);
  $productPrice               = TestData($_POST["productPrice"]);
  $discountPrice              = TestData($_POST["discountPrice"]);
  $categoryId                 = TestData($_POST["categoryId"]);

  // SKU GENERATOR 
  function generateRandomString($length = 10)
  {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }

  $productSku    = generateRandomString();

  $fileName                   = $_FILES["productImage"]["name"];
  $fileSize                   = $_FILES["productImage"]["size"] / 1024;
  $fileType                   = $_FILES["productImage"]["type"];
  $fileTmpName                = $_FILES["productImage"]["tmp_name"];


  if (
    $fileType == "image/png"
    || $fileType == "image/PNG"
    || $fileType == "image/JPG"
    || $fileType == "image/jpg"
    || $fileType == "image/jpeg"
    || $fileType == "image/JPEG"
    || $fileType == "image/gif"

  ) {

    //New file name
    $random = sha1(rand());
    $newFileName = $random . $fileName;

    //File upload path
    $uploadPath = "../catalog/products/" . $newFileName;

    $newFileName = "catalog/products/" . $newFileName;

    //function for upload file
    if (move_uploaded_file($fileTmpName, $uploadPath)) {

      $query = mysqli_query($connection, "INSERT INTO `products` (`product_id`,`vendor_id`,`product_sku`, `product_name`, `product_description`, `product_image`, `product_price`, `product_discount_price`, `product_status`) 
      VALUES (NULL,'$vendorId', '$productSku','$productName', '$productDescription', '$newFileName', '$productPrice', '$discountPrice', 'active')") or die(mysqli_error($connection));

      $productId = mysqli_insert_id($connection);

      mysqli_query($connection, "INSERT INTO `products_categories` (`id`, `product_id`, `category_id`) VALUES (NULL, '$productId', '$categoryId')") or die(mysqli_error($connection));
      if ($query) {

        // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
        require("configs/deny.resubmit.php");
        // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

        $alert  = "success";
        $msg    = "You have successfully registered new product!";
        require("templates/alert.php");
      }
    } else {
      $alert  = "danger";
      $msg    = "Something wrong happened";
      require("templates/alert.php");
    }
  } else {

    $alert  = "danger";
    $msg    = "Invalid image type!" . $fileType;
    require("templates/alert.php");
  }
}

# ADD PRODUCT IMAGE


if (isset($_POST["addProductImage"])) {

  $productId               = TestData($_POST["productId"]);
  $fileName                   = $_FILES["productImage"]["name"];
  $fileSize                   = $_FILES["productImage"]["size"] / 1024;
  $fileType                   = $_FILES["productImage"]["type"];
  $fileTmpName                = $_FILES["productImage"]["tmp_name"];


  if (
    $fileType == "image/png"
    || $fileType == "image/PNG"
    || $fileType == "image/JPG"
    || $fileType == "image/jpg"
    || $fileType == "image/jpeg"
    || $fileType == "image/JPEG"
    || $fileType == "image/gif"

  ) {

    //New file name
    $random = sha1(rand());
    $newFileName = $random . $fileName;

    //File upload path
    $uploadPath = "../catalog/products/" . $newFileName;

    $newFileName = "catalog/products/" . $newFileName;

    //function for upload file
    if (move_uploaded_file($fileTmpName, $uploadPath)) {

      mysqli_query($connection, "INSERT INTO `product_images` (`product_image_id`, `product_id`, `image_url`) VALUES (NULL, '$productId', '$newFileName')");

      if ($query) {

        // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
        require("configs/deny.resubmit.php");
        // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

        $alert  = "success";
        $msg    = "You have successfully registered new product image!";
        require("templates/alert.php");
      }
    } else {
      $alert  = "danger";
      $msg    = "Something wrong happened";
      require("templates/alert.php");
    }
  } else {

    $alert  = "danger";
    $msg    = "Invalid image type!" . $fileType;
    require("templates/alert.php");
  }
}

# UPDATE PRODUCT

if (isset($_POST["editProduct"])) {

  $productId                  = TestData($_POST["productId"]);
  $productName                = TestData($_POST["productName"]);
  $productDescription         = TestData($_POST["productDescription"]);
  $productPrice               = TestData($_POST["productPrice"]);
  $discountPrice              = TestData($_POST["discountPrice"]);

  $fileName                   = $_FILES["productImage"]["name"];
  $fileSize                   = $_FILES["productImage"]["size"] / 1024;
  $fileType                   = $_FILES["productImage"]["type"];
  $fileTmpName                = $_FILES["productImage"]["tmp_name"];


  if (
    $fileType == "image/png"
    || $fileType == "image/PNG"
    || $fileType == "image/JPG"
    || $fileType == "image/jpg"
    || $fileType == "image/jpeg"
    || $fileType == "image/JPEG"
    || $fileType == "image/gif"

  ) {

    //New file name
    $random = sha1(rand());
    $newFileName = $random . $fileName;

    //File upload path
    $uploadPath = "../catalog/products/" . $newFileName;

    $newFileName = "catalog/products/" . $newFileName;

    //function for upload file
    if (move_uploaded_file($fileTmpName, $uploadPath)) {

      $query = mysqli_query($connection, "UPDATE `products` SET `product_name` = '$productName', `product_description` = '$productDescription', `product_image` = '$newFileName', `product_price` = '$productPrice', `product_discount_price` = '$discountPrice' WHERE `products`.`product_id` = '$productId'") or die(mysqli_error($connection));


      if ($query) {

        // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
        require("configs/deny.resubmit.php");
        // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

        $alert  = "success";
        $msg    = "You have successfully updated product information!";
        require("templates/alert.php");
      }
    } else {
      $alert  = "danger";
      $msg    = "Something wrong happened";
      require("templates/alert.php");
    }
  } else {

    $alert  = "danger";
    $msg    = "Invalid image type!" . $fileType;
    require("templates/alert.php");
  }
}


# DELETE PRODUCT

if (isset($_GET["deleteProduct"])) {

  $productId      = TestData($_GET["deleteProduct"]);

  $query = mysqli_query($connection, "SELECT * FROM products WHERE product_id ='$productId'") or die(mysqli_error($connection));
  $data = mysqli_fetch_assoc($query);
  $productImage = "http://localhost/Discrounts/storage/products/" . $data["product_image"];

  @unlink($productImage);

  $query = mysqli_query($connection, "DELETE FROM `products` WHERE `products`.`product_id` = '$productId'") or die(mysqli_error($connection));

  if ($query) {

    // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
    require("configs/deny.resubmit.php");
    // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

    $alert  = "success";
    $msg    = "You have successfully deleted product!";
    require("templates/alert.php");
  }
}

# DELETE USER

if (isset($_GET["deleteUser"])) {

  $userId      = TestData($_GET["deleteUser"]);
  $query = mysqli_query($connection, "DELETE FROM `users` WHERE `users`.`user_id` = '$userId'") or die(mysqli_error($connection));

  if ($query) {

    // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
    require("configs/deny.resubmit.php");
    // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

    $alert  = "success";
    $msg    = "You have successfully deleted a user from system!";
    require("templates/alert.php");
  }
}


if (isset($_GET["processOrder"])) {

  $orderId      = TestData($_GET["processOrder"]);
  $query = mysqli_query($connection, "UPDATE `orders` SET `order_status` = 'processing' WHERE `orders`.`order_id` = '$orderId'") or die(mysqli_error($connection));

  #ORDER HISTORY
  mysqli_query($connection, "INSERT INTO `order_history` (`history_id`, `order_id`, `history_time`, `history_event`) VALUES (NULL, '$orderId', current_timestamp(), 'Your order is being processed')");

  if ($query) {
    // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
    require("configs/deny.resubmit.php");
    // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

    $alert  = "success";
    $msg    = "You have successfully changed order status to processing";
    require("templates/alert.php");
  }
}

if (isset($_GET["completeOrder"])) {

  $orderId      = TestData($_GET["completeOrder"]);
  $query = mysqli_query($connection, "UPDATE `orders` SET `order_status` = 'completed' WHERE `orders`.`order_id` = '$orderId'") or die(mysqli_error($connection));

  #ORDER HISTORY
  mysqli_query($connection, "INSERT INTO `order_history` (`history_id`, `order_id`, `history_time`, `history_event`) VALUES (NULL, '$orderId', current_timestamp(), 'Your order is being completed')");

  if ($query) {
    // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
    require("configs/deny.resubmit.php");
    // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

    $alert  = "success";
    $msg    = "You have successfully changed order status to completed";
    require("templates/alert.php");
  }
}


if (isset($_GET["cancelOrder"])) {

  $orderId      = TestData($_GET["cancelOrder"]);
  $query = mysqli_query($connection, "UPDATE `orders` SET `order_status` = 'canceled' WHERE `orders`.`order_id` = '$orderId'") or die(mysqli_error($connection));

  #ORDER HISTORY
  mysqli_query($connection, "INSERT INTO `order_history` (`history_id`, `order_id`, `history_time`, `history_event`) VALUES (NULL, '$orderId', current_timestamp(), 'Your order is canceled')");

  if ($query) {
    // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
    require("configs/deny.resubmit.php");
    // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

    $alert  = "success";
    $msg    = "You have successfully changed order status to canceled";
    require("templates/alert.php");
  }
}
ob_end_flush();
?>