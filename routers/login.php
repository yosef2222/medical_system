<?php
include_once 'helpers/helpers.php';

function excute($method, $urlList, $requestData)
{
    $servername = "127.0.0.1";
    $user_idname = "root";
    $password = "";
    $database = "backend";
    if ($method == "POST") {
        header('Content-type: application/json');
        // Create connection
        $conn = new mysqli($servername, $user_idname, $password, $database);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        switch ($urlList[1]) {
            case 'login':
                $email = $requestData->body->email;
                $password = hash("sha1", $requestData->body->password);

                $result = $conn->query("SELECT id FROM doctor WHERE email='$email' AND password = '$password'");
                if (!$result) {
                    die("Error executing query: " . $conn->error);
                }
                $user_id = $result->fetch_assoc();

                $id_user = $user_id['id'];
                if (!is_null($user_id)) {
                    $token = $conn->query("SELECT tokenValue FROM tokens WHERE user_id ='$id_user'");
                    if (is_null($token)) {
                        $token = bin2hex(random_bytes(16));
                        $conn->query("INSERT INTO tokens (tokenValue) VALUES('$token') WHERE user_id ='$id_user'");
                    } else {
                        $token = bin2hex(random_bytes(16));
                        $conn->query("UPDATE tokens SET tokenValue = '$token' WHERE user_id = '$id_user'");
                    }
                    echo json_encode(['token' => $token]);
                } else {
                    setHTTPStatus('401', "Incorrect credentials.");
                }
                break;
            case 'logout':
                $token = getTokenFromHeaders();
                $user_id = $conn->query("SELECT user_id FROM tokens WHERE tokenValue ='$token'")->fetch_assoc();
                $id_user = $user_id['user_id'];
                if (!is_null($user_id)) {
                    $newToken = bin2hex(random_bytes(16));
                    $conn->query("UPDATE tokens SET tokenValue = '$newToken' WHERE user_id = '$id_user'");
                    echo "logged out successfully";
                } else {
                    echo "you are not logged in";
                }
                break;
            default:
                setHTTPStatus('404', "there is no path as '$urlList[1]'");
                break;
        }
    } else {
        echo "bad request";
    }
}
