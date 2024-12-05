<?php

if (isset($_POST["placeOrder"])) {

    $fname = TestData($_POST["fname"]);
    $lname = TestData($_POST["lname"]);
    $address = TestData($_POST["address"]);

    $phone = TestData($_POST["phone"]);
    $email = TestData($_POST["email"]);
    $password = sha1(TestData($_POST["password"]));
    $regDate = date("Y-m-d");

    function generate_token($length = 52)
    {
        return bin2hex(random_bytes($length / 2));
    }

// Example usage:
    $token = generate_token();

    # CHECK IF CUSTOMER IS NOT REGISTERED YET

    $query = mysqli_query($connection, "SELECT * FROM users WHERE user_phone ='$phone' OR user_email ='$email'");
    $count = mysqli_num_rows($query);

    if ($count > 0) {
        $data = mysqli_fetch_assoc($query);
        $customerId = $data["user_id"];
    } else {

        mysqli_query($connection, "INSERT INTO `users` (`user_id`, `user_name`, `user_lname`, `user_fname`, `user_phone`, `user_email`, `address`, `user_password`, `user_role`, `token`, `user_status`) 
VALUES (NULL, '$fname', '$lname', '$fname', '$phone', '$email', '$address', '$password', 'Customer', '$token', 'active')") or die(mysqli_error($connection));

        # CUSTOMER ID

        $customerId = mysqli_insert_id($connection);
    }

    # UPDATE CART || CUSTOMER ID

    mysqli_query($connection, "UPDATE carts SET customer_id ='$customerId' WHERE session_id ='$sessionId'") or die(mysqli_error($connection));

    $paymentMethodId = $_POST["payment_method_id"];

    $orderNotes = TestData($_POST["order_notes"]);

    #GENERATE TRACKING NUMBER

    function generateRandomString($length = 8)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    $orderTrackId = "CK" . generateRandomString();

    # SAVE ORDER INFO

    if ($paymentMethodId == 3) {
        $status = "processing";
    } else {
        $status = 'pending';
    }

    mysqli_query($connection, "INSERT INTO `orders` (`order_id`, `customer_id`, `order_total`,`order_track_id`,`order_notes`, `order_time`, `payment_method_id`, `order_status`) 
    VALUES (NULL, '$customerId', '0','$orderTrackId','$orderNotes', current_timestamp(), '$paymentMethodId', '$status')") or die(mysqli_error($connection));

    $orderId = mysqli_insert_id($connection);

    # ORDER PRODUCTS 

    $query = mysqli_query($connection, "SELECT * FROM carts WHERE session_id ='$sessionId'");
    $orderTotal = 0;
    while ($data = mysqli_fetch_assoc($query)) {
        $productId = $data["product_id"];
        $orderTotal = $orderTotal + $data["cart_total"];
        $orderQty = $data["cart_qty"];

        mysqli_query($connection, "INSERT INTO `order_products` (`order_product_id`, `order_id`,`order_qty`, `product_id`) VALUES (NULL, '$orderId', '$orderQty','$productId')");
    }

    # UPDATE ORDER

    mysqli_query($connection, "UPDATE orders SET order_total ='$orderTotal' WHERE order_id ='$orderId'");

    #DELETE CART & SESSION

    mysqli_query($connection, "DELETE FROM carts WHERE session_id ='$sessionId'");


    $alert = "success";
    $msg = "Thank you for shopping with us";
    require "templates/alert.php";

    // SEND EMAIL NOTIFICATION

    $to = "admin@Discrounts.com";
    $subject = "New Order " . $orderId;
    $message = "
    <html>
    <body>
    <p>New order has been placed</p>
    </body>
    </html>
    ";
    require("configs/email.php");

    // END SEND EMAIL NOTIFICATION
}


# LOGIN

if (isset($_POST["login"])) {
    $id = TestData($_POST["id"]);
    $password = TestData($_POST["password"]);


    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://disscrounts.rw/api/account/login',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode(array(
            'phone' => $id,
            'password' => $password
        )),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

// Decode the JSON response
    $responseData = json_decode($response, true);

    if ($responseData['code'] === 200 && $responseData['status'] === 'Success') {
        // Store the data in variables
        $customerId = $responseData['data']['user_id'];
        $userName = $responseData['data']['user_name'];
        $userLname = $responseData['data']['user_lname'];

        $customerName = $userName . " " . $userLname;

        $userFname = $responseData['data']['user_fname'];
        $userPhone = $responseData['data']['user_phone'];
        $userEmail = $responseData['data']['user_email'];
        $address = $responseData['data']['address'];
        $userRole = $responseData['data']['user_role'];
        $token = $responseData['data']['token'];
        $userStatus = $responseData['data']['user_status'];

        setcookie("CKCUSTOMERID", $customerId, time() + (86400 * 30), "/");
        setcookie("CKCUSTOMERNAME", $customerName, time() + (86400 * 30), "/");

        $alert = "success";
        $msg = $responseData['message'];
        require "templates/alert.php";

        ?>
        <script type="text/javascript">
            setTimeout(function () {
                window.location = "myaccount";
            }, 3000);
        </script>
        <?php

    } else {

        $alert = "danger";
        $msg = $responseData['message'];
        require "templates/alert.php";
    }


}

# SIGN UP

if (isset($_POST["register"])) {
    $names = TestData($_POST["names"]);
    $email = TestData($_POST["email"]);
    $password = TestData($_POST["password"]);
    $phone = TestData($_POST["phone"]);
    $address = "";


    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://disscrounts.rw/api/account/registration',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode(array(
            'names' => $names,
            'email' => $email,
            'password' => $password,
            'phone' => $phone,
            'address' => $address
        )),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

// Decode the JSON response
    $responseData = json_decode($response, true);

    if ($responseData['code'] === 200 && $responseData['status'] === 'Success') {
        // Store the data in variables
        $customerId = $responseData['data']['user_id'];
        $userName = $responseData['data']['user_name'];
        $userLname = $responseData['data']['user_lname'];

        $customerName = $userName . " " . $userLname;

        $userFname = $responseData['data']['user_fname'];
        $userPhone = $responseData['data']['user_phone'];
        $userEmail = $responseData['data']['user_email'];
        $address = $responseData['data']['address'];
        $userRole = $responseData['data']['user_role'];
        $token = $responseData['data']['token'];
        $userStatus = $responseData['data']['user_status'];

        setcookie("CKCUSTOMERID", $customerId, time() + (86400 * 30), "/");
        setcookie("CKCUSTOMERNAME", $customerName, time() + (86400 * 30), "/");

        $alert = "success";
        $msg = $responseData['message'];
        require "templates/alert.php";

        ?>
        <script type="text/javascript">
            setTimeout(function () {
                window.location = "myaccount";
            }, 3000);
        </script>
        <?php

    } else {

        $alert = "danger";
        $msg = $responseData['message'];
        require "templates/alert.php";
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
            $body = urlencode("Dear $fname $lname,<br>We received a request to reset your password for your <strong>Discrounts</strong> account associated with this email address. If you did not request this, please disregard this email.<br><br>To reset your password, please click on the link below:<br><br><a href='https://disscrounts.rw/reset-password?token=$token' style='background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Reset Password</a><br><br>For your security, this link will expire in 24 hours. If the link does not work, copy and paste the following URL into your web browser:<br><br><a href='https://disscrounts.rw/reset-password?token=$token'>http://disscrounts.rw/reset-password?token=$token</a><br><br>After resetting your password, you'll be able to log in with your new credentials.<br><br>If you have any questions or need further assistance, feel free to contact our support team.<br><br>Best regards,<br>Discrounts Ltd Support Team");
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

            ?>
            <script type="text/javascript">
                setTimeout(function () {
                    window.location = "login";
                }, 3000);
            </script>
            <?php

        }
    } else {
        $alert = "danger";
        $msg = "Passwords do not match!";
        require("templates/alert.php");
    }
}

