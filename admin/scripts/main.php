<?php
ob_start();
require "configs/connection.php";
require "configs/test.data.php";

###############################    SIGNIN       ################################

if (isset($_POST["signin"])) {
    $id = TestData($_POST["id"]);
    $password = sha1(TestData($_POST["password"]));

    $query = mysqli_query($connection, "SELECT * FROM users WHERE (user_phone = '$id' OR user_email = '$id') AND user_password = '$password'") or die(mysqli_error($connection));

    $count = mysqli_num_rows($query);
    if ($count == 1) {

        $data = mysqli_fetch_assoc($query);
        $alert = "success";
        $msg = "You have successfully signed in.";

        setcookie("CK_USER_ID", $data["user_id"], time() + (86400 * 30), "/");
        setcookie("CK_USER_ROLE", $data["user_role"], time() + (86400 * 30), "/");
        setcookie("CK_USER_USERNAME", $data["user_name"], time() + (86400 * 30), "/");


        ?>
        <script type="text/javascript">
            setTimeout(function () {
                window.location = "dashboard";
            }, 3000);
        </script>
        <?php
    } else {
        $alert = "danger";
        $msg = "Invalid login information, please try again.";
    }

    require "templates/alert.php";
}

//#####################################  USER REGISTRATION  ######################//
if (isset($_POST["addEmployee"])) {

    $names = TestData($_POST["names"]);
    $nameParts = explode(" ", $names);
    $fname = isset($nameParts[0]) ? $nameParts[0] : '';
    $lname = isset($nameParts[1]) ? $nameParts[1] : '';
    if (count($nameParts) > 2) {
        $lname = implode(" ", array_slice($nameParts, 1));
    }

    $phone = TestData($_POST["phone"]);
    $email = TestData($_POST["email"]);
    $role = TestData($_POST["role"]);

    // Check if user already exists based on phone or email
    $check_query = mysqli_query($connection, "SELECT * FROM `users` WHERE `user_phone` = '$phone' OR `user_email` = '$email'") or die(mysqli_error($connection));

    if (mysqli_num_rows($check_query) > 0) {
        // User already exists
        $alert = "danger";
        $msg = "User with this phone number or email already exists!";
        require("templates/alert.php");
    } else {
        // GENERATE PASSWORD
        $digits_needed = 6;
        $random_number = ''; // set up a blank string
        $count = 0;
        while ($count < $digits_needed) {
            $random_digit = mt_rand(0, 9);
            $random_number .= $random_digit;
            $count++;
        }

        $password = $random_number;
        $hashed_password = sha1($password);

        function generate_token($length = 52)
        {
            return bin2hex(random_bytes($length / 2));
        }

        // Example usage:
        $token = generate_token();

        $query = mysqli_query($connection, "INSERT INTO `users` (`user_id`, `user_name`, `user_lname`, `user_fname`, `user_phone`, `user_email`, `user_password`, `token`, `user_role`, `user_status`) 
        VALUES (NULL, '$fname', '$lname', '$fname', '$phone', '$email', '$hashed_password', '$token', '$role', 'active')") or die(mysqli_error($connection));

        if ($query) {


            // Define your variables
            $title = urlencode('Welcome to Discrounts');
            $body = urlencode("Dear $fname $lname,<br>Welcome to our service! Your account has been created successfully.<br>Your credentials are as follows:<br><br>Phone: $phone<br>Password: $password <br><br>Best regards,<br> Melartmart Ltd");
            $receiverMail = $email;
            $receiverName = $fname;

            // Construct the URL with variables
            $url = "https://disscrounts.rw/api/mail/?sendMail=Yes&title={$title}&body={$body}&receiverMail={$receiverMail}&receiverName={$receiverName}";

            // Initialize cURL
            $curl = curl_init();

            // Set cURL options
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            // Execute cURL request
            $response = curl_exec($curl);

            // Close cURL session
            curl_close($curl);

            // Output the response
            //echo $response;

            // END SEND EMAIL NOTIFICATION

            $alert = "success";
            $msg = "You have successfully registered a new user and an email has been sent!";


            require("templates/alert.php");

            // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
            require("configs/deny.resubmit.php");
            // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
        }
    }
}

// RESET PASSWORD

if (isset($_POST['resetPassword'])) {
    $email = TestData($_POST['email']);
    $query = mysqli_query($connection, "SELECT * FROM users WHERE user_email = '$email'") or die(mysqli_error($connection));
    $count = mysqli_num_rows($query);
    if ($count == 1) {
        $data = mysqli_fetch_assoc($query);
        $userId = $data['user_id'];
        $fname = $data['user_fname'];
        $lname = $data['user_lname'];
        $data = mysqli_fetch_assoc($query);
        $token = sha1(uniqid(rand(), true));
        $newPassword = sha1(uniqid(rand(), true));
        $query = mysqli_query($connection, "UPDATE users SET token = '$token' WHERE user_id = '$userId'") or die(mysqli_error($connection));
        if ($query) {

            // Define your variables
            $title = urlencode('Reset Your Password for Discrounts');
            $body = urlencode("Dear $fname $lname,<br>We received a request to reset your password for your <strong>Discrounts</strong> account associated with this email address. If you did not request this, please disregard this email.<br><br>To reset your password, please click on the link below:<br><br><a href='http://disscrounts.rw/admin/reset-password?token=$token' style='background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Reset Password</a><br><br>For your security, this link will expire in 24 hours. If the link does not work, copy and paste the following URL into your web browser:<br><br><a href='http://disscrounts.rw/admin/reset-password?token=$token'>http://disscrounts.rw/admin/reset-password?token=$token</a><br><br>After resetting your password, you'll be able to log in with your new credentials.<br><br>If you have any questions or need further assistance, feel free to contact our support team.<br><br>Best regards,<br>Discrounts Ltd Support Team");
            $receiverMail = $email;
            $receiverName = $fname;

            // Construct the URL with variables
            $url = "https://disscrounts.rw/api/mail/?sendMail=Yes&title={$title}&body={$body}&receiverMail={$receiverMail}&receiverName={$receiverName}";

            // Initialize cURL
            $curl = curl_init();

            // Set cURL options
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            // Execute cURL request
            $response = curl_exec($curl);

            // Close cURL session
            curl_close($curl);

            $alert = "success";
            $msg = "We have sent you an email with instructions to reset your password!";
            require("templates/alert.php");
            ?>

            <script type="text/javascript">
                setTimeout(function () {
                    window.location = "./";
                }, 3000);
            </script>
            <?php
        }
    } else {
        $alert = "danger";
        $msg = "Invalid email address!";
        require("templates/alert.php");
    }
}

/// #####  change password  #####
if (isset($_POST['changePassword'])) {
    $token= TestData($_POST['token']);

    $newPassword = sha1(TestData($_POST['newPassword']));
    $confirmPassword = sha1(TestData($_POST['confirmPassword']));

    if ($newPassword == $confirmPassword) {
        $query = mysqli_query($connection, "UPDATE users SET user_password = '$newPassword' WHERE token = '$token'") or die(mysqli_error($connection));
        if ($query) {
            $alert = "success";
            $msg = "You have successfully changed password!";
            require("templates/alert.php");
        }
    } else {
        $alert = "danger";
        $msg = "Passwords do not match!";
        require("templates/alert.php");
    }
}


//#####################################  USER REGISTRATION  ######################//

if (isset($_POST["addCustomer"])) {

    $fname = TestData($_POST["fname"]);
    $lname = TestData($_POST["lname"]);
    $phone = TestData($_POST["phone"]);
    $email = TestData($_POST["email"]);
    $company = TestData($_POST["company"]);
    $address1 = TestData($_POST["address1"]);
    $address2 = TestData($_POST["address2"]);
    $street = TestData($_POST["street"]);
    $regDate = date("Y-m-d");

    // GENERATE PASSWORD

    $digits_needed = 6;
    $random_number = ''; // set up a blank string
    $count = 0;
    while ($count < $digits_needed) {
        $random_digit = mt_rand(0, 9);

        $random_number .= $random_digit;
        $count++;
    }

    $password = $random_number;

    $query = mysqli_query($connection, "INSERT INTO `customers` (`customer_id`, `customer_fname`, `customer_lname`, `customer_company`, `customer_phone`, `customer_email`, `customer_password`, `country_id`, `district_id`, `customer_street`, `customer_address`, `customer_address_2`, `customer_reg_date`) 
  VALUES (NULL, '$fname', '$lname', '$company', '$phone', '$email', '$password', '0', '0', '$street', '$address1', '$address2', '$regDate')") or die(mysqli_error($connection));

    if ($query) {

        // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
        require("configs/deny.resubmit.php");
        // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

        $alert = "success";
        $msg = "You have successfully registered new Customer!";
        require("templates/alert.php");
    }
}


//#####################################  VENDOR REGISTRATION  ######################//

if (isset($_POST["addVendor"])) {

    $vendorName = TestData($_POST["vendorName"]);
    $vendorEmail = TestData($_POST["vendorEmail"]);
    $VendorPhone = TestData($_POST["vendorPhone"]);

    // GENERATE PASSWORD

    $digits_needed = 6;
    $random_number = ''; // set up a blank string
    $count = 0;
    while ($count < $digits_needed) {
        $random_digit = mt_rand(0, 9);

        $random_number .= $random_digit;
        $count++;
    }

    $password = $random_number;

    $query = mysqli_query($connection, "INSERT INTO `vendors` (`vendor_id`, `vendor_name`, `vendor_email`, `vendor_phone`, `vendor_password`, `vendor_status`) 
  VALUES (NULL, '$vendorName', '$vendorEmail', '$VendorPhone', '$password', 'active')") or die(mysqli_error($connection));

    if ($query) {

        // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
        require("configs/deny.resubmit.php");
        // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

        $alert = "success";
        $msg = "You have successfully registered new vendor!";
        require("templates/alert.php");

    }
}


# DELETE CATEGORY

if (isset($_GET["deletevendor"])) {

    $vendorId = TestData($_GET["deletevendor"]);
    $query = mysqli_query($connection, "DELETE FROM `vendors` WHERE `vendor_id` = '$vendorId'") or die(mysqli_error($connection));

    if ($query) {

        // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
        require("configs/deny.resubmit.php");
        // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

        $alert = "success";
        $msg = "You have successfully deleted vendor!";
        require("templates/alert.php");
    }
}

# DELETE USER

if (isset($_GET["deleteuser"])) {

    $userId = TestData($_GET["deleteuser"]);
    $query = mysqli_query($connection, "DELETE FROM `users` WHERE `user_id` = '$userId'") or die(mysqli_error($connection));

    if ($query) {

        // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
        require("configs/deny.resubmit.php");
        // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

        $alert = "success";
        $msg = "You have successfully deleted user!";
        require("templates/alert.php");
    }
}

# DEACTIVATE CATEGORY

if (isset($_GET["deactivateCategory"])) {

    $categoryId = TestData($_GET["deactivateCategory"]);
    $query = mysqli_query($connection, "UPDATE `categories` SET `category_status` = 'desactivated' WHERE `categories`.`category_id` = '$categoryId'") or die(mysqli_error($connection));

    if ($query) {

        // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
        require("configs/deny.resubmit.php");
        // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

        $alert = "success";
        $msg = "You have successfully deactivated category!";
        require("templates/alert.php");
    }
}

# ACTIVATE CATEGORY

if (isset($_GET["activateCategory"])) {

    $categoryId = TestData($_GET["activateCategory"]);
    $query = mysqli_query($connection, "UPDATE `categories` SET `category_status` = 'active' WHERE `categories`.`category_id` = '$categoryId'") or die(mysqli_error($connection));

    if ($query) {

        // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
        require("configs/deny.resubmit.php");
        // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

        $alert = "success";
        $msg = "You have successfully activated category!";
        require("templates/alert.php");
    }
}

# DELETE PARCEL

if (isset($_GET["deleteParcel"])) {

    $parcelId = TestData($_GET["deleteParcel"]);
    $query = mysqli_query($connection, "UPDATE `parcels` SET `parcel_status` = 'deleted' WHERE `parcels`.`parcel_id` = '$parcelId'") or die(mysqli_error($connection));

    if ($query) {

        // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
        require("configs/deny.resubmit.php");
        // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

        $alert = "success";
        $msg = "You have successfully deleted vendor!";
        require("templates/alert.php");
    }
}

# ADD CATEGORY

if (isset($_POST["addCategory"])) {

    $categoryName = TestData($_POST["categoryName"]);
    $categoryDescription = TestData($_POST["categoryDescription"]);
    $parentId = TestData($_POST['parentId']);

    $fileName = $_FILES["categoryImage"]["name"];
    $fileSize = $_FILES["categoryImage"]["size"] / 1024;
    $fileType = $_FILES["categoryImage"]["type"];
    $fileTmpName = $_FILES["categoryImage"]["tmp_name"];

    if (
        $fileType == "image/png"
        || $fileType == "image/PNG"
        || $fileType == "image/JPG"
        || $fileType == "image/jpg"
        || $fileType == "image/jpeg"
        || $fileType == "image/JPEG"
        || $fileType == "image/gif"
        || $fileType == "image/webp"

    ) {

        //New file name
        $random = sha1(rand());
        $newFileName = $random . $fileName;

        //File upload path
        $uploadPath = "../catalog/categories/" . $newFileName;

        $newFileName = "catalog/categories/" . $newFileName;

        //function for upload file
        if (move_uploaded_file($fileTmpName, $uploadPath)) {

            $query = mysqli_query($connection, "INSERT INTO `categories` (`category_id`, `parent_id`,`category_name`, `category_image`, `category_description`) 
      VALUES (NULL, '$parentId','$categoryName', '$newFileName', '$categoryDescription')") or die(mysqli_error($connection));

            if ($query) {

                // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
                require("configs/deny.resubmit.php");
                // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

                $alert = "success";
                $msg = "You have successfully registered new category!";
                require("templates/alert.php");
            }
        } else {
            $alert = "danger";
            $msg = "Something wrong happened";
            require("templates/alert.php");
        }
    } else {

        $alert = "danger";
        $msg = "Invalid image type!" . $fileType;
        require("templates/alert.php");
    }
}

if (isset($_POST['editCategory'])) {
    $categoryId = $_POST['id'];
    $categoryName = TestData($_POST['categoryName']);
    $categoryDescription = TestData($_POST['categoryDescription']);
    $parentId = TestData($_POST['parentId']);

    if (!empty($_FILES['categoryImage']['name'])) { // If a new image is uploaded
        $fileName = $_FILES['categoryImage']['name'];
        $fileSize = $_FILES['categoryImage']['size'] / 1024;
        $fileType = $_FILES['categoryImage']['type'];
        $fileTmpName = $_FILES['categoryImage']['tmp_name'];

        if (
            $fileType == "image/png"
            || $fileType == "image/PNG"
            || $fileType == "image/JPG"
            || $fileType == "image/jpg"
            || $fileType == "image/jpeg"
            || $fileType == "image/JPEG"
            || $fileType == "image/gif"
            || $fileType == "image/webp"
        ) {
            // New file name
            $random = sha1(rand());
            $newFileName = $random . $fileName;

            // File upload path
            $uploadPath = "../catalog/categories/" . $newFileName;

            $newFileName = "catalog/categories/" . $newFileName;

            // Function for upload file
            if (move_uploaded_file($fileTmpName, $uploadPath)) {
                $query = mysqli_query($connection, "UPDATE `categories` SET `category_name` = '$categoryName', `category_image` = '$newFileName', `category_description` = '$categoryDescription', `parent_id` = '$parentId' WHERE `category_id` = $categoryId") or die(mysqli_error($connection));

                if ($query) {
                    // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
                    require("configs/deny.resubmit.php");
                    // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

                    $alert = "success";
                    $msg = "You have successfully updated the category!";
                    require("templates/alert.php");
                }
            } else {
                $alert = "danger";
                $msg = "Something wrong happened during the image upload.";
                require("templates/alert.php");
            }
        } else {
            $alert = "danger";
            $msg = "Invalid image type!" . $fileType;
            require("templates/alert.php");
        }
    } else { // If no new image is uploaded
        $query = mysqli_query($connection, "UPDATE `categories` SET `category_name` = '$categoryName', `category_description` = '$categoryDescription', `parent_id` = '$parentId' WHERE `category_id` = $categoryId") or die(mysqli_error($connection));

        if ($query) {
            // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
            require("configs/deny.resubmit.php");
            // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

            $alert = "success";
            $msg = "You have successfully updated the category!";
            require("templates/alert.php");
        }
    }
}


# DELETE CATEGORY

if (isset($_GET["deleteCategory"])) {

    $categoryId = TestData($_GET["deleteCategory"]);
    $query = mysqli_query($connection, "DELETE FROM `categories` WHERE `category_id` = '$categoryId'") or die(mysqli_error($connection));

    if ($query) {

        // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
        require("configs/deny.resubmit.php");
        // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

        $alert = "success";
        $msg = "You have successfully deleted category!";
        require("templates/alert.php");
    }
}


# ADD PRODUCT

if (isset($_POST["addProduct"])) {

    $productName = TestData($_POST["productName"]);
    $productDescription = TestData($_POST["productDescription"]);
    $productPrice = TestData($_POST["productPrice"]);
    $discountPrice = TestData($_POST["discountPrice"]);
    $categoryId = TestData($_POST["categoryId"]);
    $storeId = TestData($_POST["storeId"]);

    // SKU GENERATOR
    function generateRandomString($length = 10)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $length > $i; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    $productSku = generateRandomString();

    $fileName = $_FILES["productImage"]["name"];
    $fileSize = $_FILES["productImage"]["size"] / 1024;
    $fileType = $_FILES["productImage"]["type"];
    $fileTmpName = $_FILES["productImage"]["tmp_name"];

    if (
        $fileType == "image/png"
        || $fileType == "image/PNG"
        || $fileType == "image/JPG"
        || $fileType == "image/jpg"
        || $fileType == "image/jpeg"
        || $fileType == "image/JPEG"
        || $fileType == "image/gif"
        || $fileType == "image/webp"
    ) {
        //New file name
        $random = sha1(rand());
        $newFileName = $random . $fileName;

        //File upload path
        $uploadPath = "../catalog/products/" . $newFileName;

        // Move the uploaded file
        if (move_uploaded_file($fileTmpName, $uploadPath)) {
            // Resize and pad the image
            $imagePath = $uploadPath;
            $padding = 40;

            // Detect image type
            $imageType = exif_imagetype($imagePath);
            switch ($imageType) {
                case IMAGETYPE_JPEG:
                    $originalImage = imagecreatefromjpeg($imagePath);
                    break;
                case IMAGETYPE_PNG:
                    $originalImage = imagecreatefrompng($imagePath);
                    break;
                case IMAGETYPE_WEBP:
                    $originalImage = imagecreatefromwebp($imagePath);
                    break;
                default:
                    die("Unsupported image type: " . $imagePath);
            }

            $originalWidth = imagesx($originalImage);
            $originalHeight = imagesy($originalImage);

            $size = max($originalWidth, $originalHeight) + (2 * $padding);

            $squareImage = imagecreatetruecolor($size, $size);
            $white = imagecolorallocate($squareImage, 255, 255, 255);
            imagefill($squareImage, 0, 0, $white);

            $x = ($size - $originalWidth) / 2;
            $y = ($size - $originalHeight) / 2;

            imagecopy($squareImage, $originalImage, $x, $y, 0, 0, $originalWidth, $originalHeight);

            // Save the new image
            imagejpeg($squareImage, $imagePath, 100);

            imagedestroy($originalImage);
            imagedestroy($squareImage);

            // Insert product into the database
            $newFileName = "catalog/products/" . $newFileName;
            $query = mysqli_query($connection, "INSERT INTO `products` (`product_id`, `store_id`, `product_sku`, `product_name`, `product_description`, `product_image`, `product_price`, `product_discount_price`, `product_status`) 
            VALUES (NULL,'$storeId', '$productSku', '$productName', '$productDescription', '$newFileName', '$productPrice', '$discountPrice', 'active')") or die(mysqli_error($connection));

            $productId = mysqli_insert_id($connection);

            mysqli_query($connection, "INSERT INTO `products_categories` (`id`, `product_id`, `category_id`) VALUES (NULL, '$productId', '$categoryId')") or die(mysqli_error($connection));

            if ($query) {
                require("configs/deny.resubmit.php");
                $alert = "success";
                $msg = "You have successfully registered new product!";
                require("templates/alert.php");
            }
        } else {
            $alert = "danger";
            $msg = "Something wrong happened";
            require("templates/alert.php");
        }
    } else {
        $alert = "danger";
        $msg = "Invalid image type!" . $fileType;
        require("templates/alert.php");
    }
}

# ADD PRODUCT IMAGE


if (isset($_POST["addProductImage"])) {


    $productId = $_POST['productId'];

    // Directory where you want to save the uploaded files
    $uploadDir = "../catalog/products/";

    // Loop through each file
    foreach ($_FILES['productImages']['name'] as $key => $val) {
        $fileName = $_FILES['productImages']['name'][$key];
        $fileSize = $_FILES['productImages']['size'][$key] / 1024;
        $fileType = $_FILES['productImages']['type'][$key];
        $fileTmpName = $_FILES['productImages']['tmp_name'][$key];

        // Check if file is a valid image type
        if (
            $fileType == "image/png"
            || $fileType == "image/PNG"
            || $fileType == "image/JPG"
            || $fileType == "image/jpg"
            || $fileType == "image/jpeg"
            || $fileType == "image/JPEG"
            || $fileType == "image/gif"
            || $fileType == "image/webp"
        ) {
            // New file name
            $random = sha1(rand());
            $newFileName = $random . $fileName;

            // File upload path
            $uploadPath = $uploadDir . $newFileName;

            // Move the uploaded file
            if (move_uploaded_file($fileTmpName, $uploadPath)) {
                // Resize and pad the image
                $imagePath = $uploadPath;
                $padding = 40;

                // Detect image type
                $imageType = exif_imagetype($imagePath);
                switch ($imageType) {
                    case IMAGETYPE_JPEG:
                        $originalImage = imagecreatefromjpeg($imagePath);
                        break;
                    case IMAGETYPE_PNG:
                        $originalImage = imagecreatefrompng($imagePath);
                        break;
                    case IMAGETYPE_WEBP:
                        $originalImage = imagecreatefromwebp($imagePath);
                        break;
                    default:
                        die("Unsupported image type: " . $imagePath);
                }

                $originalWidth = imagesx($originalImage);
                $originalHeight = imagesy($originalImage);

                $size = max($originalWidth, $originalHeight) + (2 * $padding);

                $squareImage = imagecreatetruecolor($size, $size);
                $white = imagecolorallocate($squareImage, 255, 255, 255);
                imagefill($squareImage, 0, 0, $white);

                $x = ($size - $originalWidth) / 2;
                $y = ($size - $originalHeight) / 2;

                imagecopy($squareImage, $originalImage, $x, $y, 0, 0, $originalWidth, $originalHeight);

                // Save the new image
                imagejpeg($squareImage, $imagePath, 100);

                imagedestroy($originalImage);
                imagedestroy($squareImage);

                // Insert product into the database (assuming you have a database connection)
                $newFileName = "catalog/products/" . $newFileName;

                mysqli_query($connection, "INSERT INTO `product_images` (`product_image_id`, `product_id`, `image_url`) VALUES (NULL, '$productId', '$newFileName')");


                //echo "The file $fileName has been uploaded successfully.<br>";
            } else {
                echo "Sorry, there was an error uploading $fileName.<br>";
            }
        } else {
            echo "Sorry, only JPG, JPEG, PNG, GIF, & WEBP files are allowed to upload.<br>";
        }
    }


    $alert = "success";
    $msg = "You have successfully uploaded new product images!";
    require("templates/alert.php");
}

if (isset($_POST["editProduct"])) {

    $productId = TestData($_POST["productId"]);
    $categoryId = TestData($_POST["categoryId"]);
    $productName = TestData($_POST["productName"]);
    $productDescription = TestData($_POST["productDescription"]);
    $productPrice = TestData($_POST["productPrice"]);
    $discountPrice = TestData($_POST["discountPrice"]);

    // Check if a new image has been uploaded
    if (!empty($_FILES["productImage"]["name"])) {
        $fileName = $_FILES["productImage"]["name"];
        $fileSize = $_FILES["productImage"]["size"] / 1024;
        $fileType = $_FILES["productImage"]["type"];
        $fileTmpName = $_FILES["productImage"]["tmp_name"];

        if (
            $fileType == "image/png"
            || $fileType == "image/PNG"
            || $fileType == "image/JPG"
            || $fileType == "image/jpg"
            || $fileType == "image/jpeg"
            || $fileType == "image/JPEG"
            || $fileType == "image/gif"
        ) {

            // New file name
            $random = sha1(rand());
            $newFileName = $random . $fileName;

            // File upload path
            $uploadPath = "../catalog/products/" . $newFileName;

            $newFileName = "catalog/products/" . $newFileName;

            // Function for uploading file
            if (move_uploaded_file($fileTmpName, $uploadPath)) {
                $imageSetClause = ", `product_image` = '$newFileName'";
            } else {
                $alert = "danger";
                $msg = "Something wrong happened";
                require("templates/alert.php");
                exit();
            }
        } else {
            $alert = "danger";
            $msg = "Invalid image type!" . $fileType;
            require("templates/alert.php");
            exit();
        }
    } else {
        $imageSetClause = "";
    }

    // Update query
    $query = mysqli_query($connection, "UPDATE `products` SET `product_name` = '$productName', `product_description` = '$productDescription', `product_price` = '$productPrice', `product_discount_price` = '$discountPrice' $imageSetClause WHERE `products`.`product_id` = '$productId'") or die(mysqli_error($connection));

    // Update category
    mysqli_query($connection, "UPDATE `products_categories` SET `category_id` = '$categoryId' WHERE `products_categories`.`product_id` = '$productId'");

    if ($query) {
        // Prevent form resubmit on refresh
        require("configs/deny.resubmit.php");

        $alert = "success";
        $msg = "You have successfully updated product information!";
        require("templates/alert.php");
    }
}


# DELETE PRODUCT

if (isset($_GET["deleteProduct"])) {

    $productId = TestData($_GET["deleteProduct"]);

    $query = mysqli_query($connection, "SELECT * FROM products WHERE product_id ='$productId'") or die(mysqli_error($connection));
    $data = mysqli_fetch_assoc($query);
    $productImage = "../" . $data["product_image"];

    @unlink($productImage);

    $query = mysqli_query($connection, "UPDATE products SET product_status='Deleted' WHERE `products`.`product_id` = '$productId'") or die(mysqli_error($connection));

    if ($query) {

        // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
        require("configs/deny.resubmit.php");
        // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

        $alert = "success";
        $msg = "You have successfully deleted product!";
        require("templates/alert.php");
    }
}

#OUT OF STOCK PRODUCT

if (isset($_GET["outOfStock"])) {

    $productId = TestData($_GET["outOfStock"]);
    $query = mysqli_query($connection, "UPDATE `products` SET `product_status` = 'out_of_stock' WHERE `products`.`product_id` = '$productId'") or die(mysqli_error($connection));

    if ($query) {

        // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
        require("configs/deny.resubmit.php");
        // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

        $alert = "success";
        $msg = "You have successfully changed product status to out of stock!";
        require("templates/alert.php");
    }
}

#IN STOCK PRODUCT

if (isset($_GET["inStock"])) {

    $productId = TestData($_GET["inStock"]);
    $query = mysqli_query($connection, "UPDATE `products` SET `product_status` = 'in_stock' WHERE `products`.`product_id` = '$productId'") or die(mysqli_error($connection));

    if ($query) {

        // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
        require("configs/deny.resubmit.php");
        // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

        $alert = "success";
        $msg = "You have successfully changed product status to in stock!";
        require("templates/alert.php");
    }
}

# DELETE USER

if (isset($_GET["deleteUser"])) {

    $userId = TestData($_GET["deleteUser"]);
    $query = mysqli_query($connection, "DELETE FROM `users` WHERE `users`.`user_id` = '$userId'") or die(mysqli_error($connection));

    if ($query) {

        // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
        require("configs/deny.resubmit.php");
        // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

        $alert = "success";
        $msg = "You have successfully deleted a user from system!";
        require("templates/alert.php");
    }
}

#Add Slide
if (isset($_POST["addSlide"])) {
    $slideName = TestData($_POST["slideName"]);
    $slideImage = TestData($_POST['slideImage']);
    $slideImageName = basename($slideImage);
    $fileName = $_FILES["slideImage"]["name"];
    $fileSize = $_FILES["slideImage"]["size"] / 1024;
    $fileType = $_FILES["slideImage"]["type"];
    $fileTmpName = $_FILES["slideImage"]["tmp_name"];
    if (
        $fileType == "image/png"
        || $fileType == "image/PNG"
        || $fileType == "image/JPG"
        || $fileType == "image/jpg"
        || $fileType == "image/jpeg"
        || $fileType == "image/JPEG"
        || $fileType == "image/gif"
        || $fileType == "image/webp"
    ) {
        //New file name
        $random = sha1(rand());
        $newFileName = $random . $fileName;
        //File upload path
        $uploadPath = "../catalog/slides/" . $newFileName;
        // Move the uploaded file
        if (move_uploaded_file($fileTmpName, $uploadPath)) {
            // Resize and pad the image

            // Insert slide into the database
            $newFileName = "catalog/slides/" . $newFileName;
            $query = mysqli_query($connection, "INSERT INTO `slides` (`slide_id`,`category_id`, `slide_name`, `slide_url`) 
            VALUES (NULL,0, '$slideName', '$newFileName')") or die(mysqli_error($connection));


            if ($query) {
                require("configs/deny.resubmit.php");
                $alert = "success";
                $msg = "You have successfully registered new slide!";
                require("templates/alert.php");
            }
        } else {
            $alert = "danger";
            $msg = "Something wrong happened";
            require("templates/alert.php");
        }
    } else {
        $alert = "danger";
        $msg = "Invalid image type!" . $fileType;
        require("templates/alert.php");
    }
}


# DELETE SLIDE

if (isset($_GET["deleteSlide"])) {

    $slideId = TestData($_GET["deleteSlide"]);
    $query = mysqli_query($connection, "DELETE FROM `slides` WHERE `slides`.`slide_id` = '$slideId'") or die(mysqli_error($connection));

    if ($query) {

        // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
        require("configs/deny.resubmit.php");
        // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

        $alert = "success";
        $msg = "You have successfully deleted a slide from system!";
        require("templates/alert.php");
    }
}

if (isset($_GET["processOrder"])) {

    $orderId = TestData($_GET["processOrder"]);
    $query = mysqli_query($connection, "UPDATE `orders` SET `order_status` = 'processing' WHERE `orders`.`order_id` = '$orderId'") or die(mysqli_error($connection));

    #ORDER HISTORY
    mysqli_query($connection, "INSERT INTO `order_history` (`history_id`, `order_id`, `history_time`, `history_event`) VALUES (NULL, '$orderId', current_timestamp(), 'Your order is being processed')");

    if ($query) {
        // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
        require("configs/deny.resubmit.php");
        // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

        $alert = "success";
        $msg = "You have successfully changed order status to processing";
        require("templates/alert.php");
    }
}

if (isset($_GET["completeOrder"])) {

    $orderId = TestData($_GET["completeOrder"]);
    $query = mysqli_query($connection, "UPDATE `orders` SET `order_status` = 'completed' WHERE `orders`.`order_id` = '$orderId'") or die(mysqli_error($connection));

    #ORDER HISTORY
    mysqli_query($connection, "INSERT INTO `order_history` (`history_id`, `order_id`, `history_time`, `history_event`) VALUES (NULL, '$orderId', current_timestamp(), 'Your order is being completed')");

    if ($query) {
        // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
        require("configs/deny.resubmit.php");
        // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

        $alert = "success";
        $msg = "You have successfully changed order status to completed";
        require("templates/alert.php");
    }
}


if (isset($_GET["cancelOrder"])) {

    $orderId = TestData($_GET["cancelOrder"]);
    $query = mysqli_query($connection, "UPDATE `orders` SET `order_status` = 'canceled' WHERE `orders`.`order_id` = '$orderId'") or die(mysqli_error($connection));

    #ORDER HISTORY
    mysqli_query($connection, "INSERT INTO `order_history` (`history_id`, `order_id`, `history_time`, `history_event`) VALUES (NULL, '$orderId', current_timestamp(), 'Your order is canceled')");

    if ($query) {
        // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
        require("configs/deny.resubmit.php");
        // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

        $alert = "success";
        $msg = "You have successfully changed order status to canceled";
        require("templates/alert.php");
    }
}


# ADD PAYMENT

if (isset($_POST["addPayment"])) {

    $orderId = TestData($_POST["orderId"]);
    $paymentMethod = TestData($_POST["paymentMethod"]);
    $paymentAmount = TestData($_POST["paymentAmount"]);
    $paymentDate = TestData($_POST["paymentDate"]);

    $transactionId = "MRT" . rand(0000, 9999);

    $query = mysqli_query($connection, "INSERT INTO `payments` (`payment_id`, `payment_method_id`, `order_id`, `transaction_id`, `external_transaction_id`, `transaction_time`, `transaction_status`) 
VALUES (NULL, '$paymentMethod', '$orderId', '$transactionId', '$transactionId', CURRENT_TIMESTAMP, 'Paid')") or die(mysqli_error($connection));

    if ($query) {

        mysqli_query($connection, "UPDATE orders SET order_status='Paid' WHERE order_id='$orderId'");

        // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
        require("configs/deny.resubmit.php");
        // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

        $alert = "success";
        $msg = "You have successfully registered new payment!";
        require("templates/alert.php");
    }
}

ob_end_flush();
?>