<?php
if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Data to send in the request
    $postdata = array(
        "api_key" => "kZKfO8T7vZgfNjpkdqCRDA",
        "email" => $email,
        "first_name" => $name,
        "fields" => [
            "phone" => $phone,
        ]
    );

    $newdata = json_encode($postdata);

    // Initialize CURL
    $url = curl_init("https://api.convertkit.com/v3/forms/7195844/subscribe");

    // Set the HTTP headers, including Authorization with Bearer token
    curl_setopt($url, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    curl_setopt($url, CURLOPT_POSTFIELDS, $newdata);
    curl_setopt($url, CURLOPT_RETURNTRANSFER, true); // Ensure that the response is returned

    $res = curl_exec($url);

    // Check for cURL errors or validate the response status (optional)
    if($res === false) {
        // Handle cURL error
        echo "cURL Error: " . curl_error($url);
    } else {
        // Decode the response if needed (depending on API response format)
        $response = json_decode($res, true);
        
        // Check for success (example based on common API response structure)
        if (isset($response['subscription']) && $response['subscription']['state'] == 'active') {
            // Redirect if the subscription is successful
            header("Location: thankyou.php");
            exit(); // Always exit after header redirect
        } else {
            // Redirect to an error page if subscription is not successful
            header("Location: error-page.php");
            exit();
        }
    }

    // Close CURL session
    curl_close($url);
}
?>