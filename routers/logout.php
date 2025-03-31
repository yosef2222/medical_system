<?php
function route($method, $urlList, $requestData)
{
    $servername = "127.0.0.1";
    $user_idname = "yusuf";
    $password = "password";
    $database = "Back-end_DB";
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
                $login = $requestData->body->login;
                $password = hash("sha1", $requestData->body->password);

                $user_id = $conn->query("SELECT id FROM users WHERE login='$login' AND password = '$password'")->fetch_assoc();
                if (!is_null($user_id)) {
                    $token = $conn->query("SELECT value FROM tokens WHERE id ='$user_id'")->fetch_assoc();
                    if (is_null($token)) {
                        $token = bin2hex(random_bytes(16));
                        $conn->query("INSERT INTO tokens (value) VALUES('$token')");

                    } else {
                        $conn->query("UPDATE tokens SET value = '$token' WHERE id = '$user_id'");
                    }
                    echo json_encode($token);
                } else {
                    setHTTPStatus('401', "Incorrect credentials.");
                }
                break;
            case 'logout':
                //TODO
                break;
            default:
                setHTTPStatus('404', "there is no path as 'user/$urlList[1]'");
                break;
        }
    } else {
        echo "bad request";
    }
}