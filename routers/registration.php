<?php
include_once 'helpers/helpers.php';
function isValidPhoneNumber($phoneNumber)
{
    // Remove non-numeric characters
    $phoneNumber = preg_replace('/\D/', '', $phoneNumber);

    // Check if the phone number has a valid format
    // This example assumes a 10-digit phone number
    if (preg_match('/^\d{10}$/', $phoneNumber)) {
        return true;
    } else {
        return false;
    }
}
function isValidName($name)
{
    if (strlen($name) > 1 && strlen($name) < 1000) {
        return true;
    } else {
        return false;
    }
}
function isValidEmail($email)
{
    if (strlen($email) > 5) {
        return true;
    } else {
        return false;
    }
}
function isValidPassword($password)
{
    return preg_match('/[0-9]/', $password) && strlen($password) > 5;
}

function isValidGender($gender)
{
    if ($gender == 'Male' || $gender == 'Female') {
        return true;
    } else {
        return false;
    }
}
function route($method, $urlList, $requestData)
{
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $database = "backend";

    switch ($method) {
        case 'GET':
            setHTTPStatus(405, "This is a get request");
            break;
        case 'POST':
            header('Content-type: application/json');

            // Create connection
            $conn = new mysqli($servername, $username, $password, $database);

            // Check connection
            if ($conn->connect_error) {
                setHTTPStatus(500, "Connection failed");
                return;
            }
            $email = $requestData->body->email;
            $result = $conn->query("SELECT id FROM doctor WHERE email='$email'");

            if (!$result) {
                die("Error in SQL query: " . $conn->error);
            }

            $user_id = $result->fetch_assoc();
            if (is_null($user_id)) {
                $password = $requestData->body->password;
                $name = $requestData->body->name;
                $birthday = new DateTime();
                $gender = $requestData->body->gender;
                $birthday = $requestData->body->birthday;
                $phoneNumber = $requestData->body->phoneNumber;
                $email = $requestData->body->email;
                $speciality = $requestData->body->speciality;
                if (!isValidName($name)) {
                    setHTTPStatus(500, "name is not valid.");
                    break;
                }
                if (!isValidPassword($password)) {
                    setHTTPStatus(500, "Password is not valid, it should contain at least 1 digit and be of a min length 6.");
                    return;
                }
                if (!isValidGender($gender)) {
                    setHTTPStatus(500, "Gender is not valid, expected value ['Male', 'Female'].");
                    return;
                }
                if (!isValidPhoneNumber($phoneNumber)) {
                    setHTTPStatus(500, "PhoneNumber is not valid, expected length is 10 digits.");
                    return;
                }
                $password = hash("sha1", $requestData->body->password);
                $userInsertResults = $conn->query("INSERT INTO doctor (name, email, password, birthday, gender, phoneNumber) VALUES('$name', '$email', '$password', '$birthday', '$gender', '$phoneNumber')");

                if (!$userInsertResults) {
                    setHTTPStatus(500, $conn->error);
                } else {
                    $user_id = $conn->query("SELECT id FROM doctor WHERE email='$email'")->fetch_assoc();
                    $id_user = $user_id['id'];

                    $token = $conn->query("SELECT tokenValue FROM tokens WHERE user_id ='$id_user'")->fetch_assoc();
                    if (is_null($token)) {
                        $token = bin2hex(random_bytes(16));
                        $conn->query("INSERT INTO tokens (`tokenValue`, `user_id`) VALUES ('$token','$id_user')");
                    } else {
                        $token = bin2hex(random_bytes(16));
                        $conn->query("UPDATE tokens SET tokenValue = '$token' WHERE user_id = '$id_user'");
                    }
                    echo json_encode(['token' => $token]);
                    return;
                }
            } else {
                setHTTPStatus(500, "Email is already taken.");
                return;
            }
            break;
        default:
            # code...
            break;
    }
}
