<?php 

// Function to check if the username conforms to the guidelines
// using regular expression
function checkUsername($username) {
    $regex = '/^[a-zA-Z0-9]{6,20}$/';
    if (preg_match($regex, $username)) {
        return true;
    } else {
        return false;
    }
}

// Function to check if the full name conforms to the guidelines
// using regular expression
function checkFullname($fullname) {
    $regex = '/^[a-zA-Z ]{5,100}$/';
    if (preg_match($regex, $fullname)) {
        return true;
    } else {
        return false;
    }
}

// Function to check if the email conforms to the guidelines
// using regular expression
function checkEmail($email) {
    $regex = '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD';
    if (preg_match($regex, $email)) {
        return true;
    } else {
        return false;
    }
}

// Function to check if the password conforms to the guidelines
// using regular expression
// At least one capital letter, one lowercase letter and one number, min 8 characters
// max 30 characters.
function checkPassword($password) {
    $regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,30}$/';
    if (preg_match($regex, $password)) {
        return true;
    } else {
        return false;
    }
}

// Function to check if the entered service title conforms to the guidelines
function checkServiceTitle($title) {
    $regex = '/^[a-zA-Z0-9 ]{5,100}$/';
    if (preg_match($regex, $title)) {
        return true;
    } else {
        return false;
    }
}

// Function to check if the entered service price conforms to the guidelines
function checkServicePrice($price) {
    $regex = '/^[0-9]{1,6}$/';
    if (preg_match($regex, $price)) {
        return true;
    } else {
        return false;
    }
}

// Function to check if the entered service image name conforms to the guidelines
function checkServiceImage($image) {
    $regex = '/^static\/images\/[a-zA-Z0-9]{1,82}.jpg$/';
    if (preg_match($regex, $image)) {
        return true;
    } else {
        return false;
    }
}

// Function to check if the entered service description conforms to the guidelines
function checkServiceDescription($description) {
    $regex = '/^[a-zA-Z0-9_.+, \-]{10,1000}$/';
    if (preg_match($regex, $description)) {
        return true;
    } else {
        return false;
    }
}
?>