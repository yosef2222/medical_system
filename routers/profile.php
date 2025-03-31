<?php
include_once 'helpers/helpers.php';

function excute($method, $urlList, $requestData)
{
    if ($method == "PUT") {
        $servername = "127.0.0.1";
        $username = "root";
        $password = "";
        $database = "backend";
        $token = getTokenFromHeaders();
        // Create connection
        $conn = new mysqli($servername, $username, $password, $database);

        // Check connection
        if ($conn->connect_error) {
            setHTTPStatus(500, "Connection failed");
            return;
        }
        $user_id = $conn->query("SELECT user_id FROM tokens WHERE tokenValue='$token'")->fetch_assoc();
        $id_user = $user_id['userID'];
        //echo json_encode($user_id);
        if (!is_null($user_id)) {
            $name = $requestData->body->name;
            $birthday = $requestData->body->birthDate;
            $gender = $requestData->body->gender;
            $email = $requestData->body->email;
            $phoneNumber = $requestData->body->phoneNumbe;
            $conn->query("UPDATE `doctor` SET `name` = '$name', `birthday` = '$birthday', `gender` = '$gender', `email` = '$email', `phoneNumber` = '$phoneNumber'  WHERE `id` = '$id_user'");
        } else {
            setHTTPStatus('401', "method == PUT");
        }
    } else if ($method == "GET") {
        $servername = "127.0.0.1";
        $username = "root";
        $password = "";
        $database = "backend";
        $token = getTokenFromHeaders();

        // Create connection
        $conn = new mysqli($servername, $username, $password, $database);

        // Check connection
        if ($conn->connect_error) {
            setHTTPStatus(500, "Connection failed");
            return;
        }
        $user_id = $conn->query("SELECT user_id FROM tokens WHERE tokenValue='$token'")->fetch_assoc();
        $id_user = $user_id['user_id'];
        if (!is_null($user_id)) {
            $name = $conn->query("SELECT name FROM doctor WHERE id='$id_user'")->fetch_assoc();
            $birthday = $conn->query("SELECT birthday FROM doctor WHERE id='$id_user'")->fetch_assoc();
            $gender = $conn->query("SELECT gender FROM doctor WHERE id='$id_user'")->fetch_assoc();
            $email = $conn->query("SELECT email FROM doctor WHERE id='$id_user'")->fetch_assoc();
            $phoneNumber = $conn->query("SELECT phoneNumber FROM doctor WHERE id='$id_user'")->fetch_assoc();
            $createTime = $conn->query("SELECT createTime FROM doctor WHERE id='$id_user'")->fetch_assoc();
            echo json_encode(['name' => $name, 'birthday' => $birthday, 'gender' => $gender, 'email' => $email, 'phoneNumber' => $phoneNumber,'id' => $id_user, 'createTime' => $createTime]);
        } else {
            setHTTPStatus('401', "Unauthorized");
        }
    } else {
        setHTTPStatus('400', "Bad request");
    }
}
