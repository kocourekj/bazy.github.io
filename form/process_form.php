<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);
    
    $errors = [];

    // Backend validace
    if (empty($name)) $errors[] = "Jméno je povinné.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Neplatný email.";
    if (empty($message)) $errors[] = "Zpráva je povinná.";

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<script>alert('$error');</script>";
        }
    } else {
        // Debug výstup
        echo "Jméno: $name<br>Email: $email<br>Zpráva: $message";
    }
}
?>