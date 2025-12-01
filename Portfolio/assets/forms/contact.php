<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    //GET FORM FIELDS
    $name = strip_tags(trim($_POST["name"])); 
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = trim($_POST["message"]); 

    //validate
    if(empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Please complete the form correctly.";
        exit; 
    }

    $recipient = "latreil.wimberly@gmail.com"; 

    //email headers
    $headers = "From: $name <$email>"; 

    //send the email
    if(mail($recipient, $subject, $message, $headers)) {
        echo "OK"; 
    } else {
        echo "Oops! Something went wrong, please try again.";
    }
} else {
    echo "There was a problem with your submission, please try again.";
}

?> 