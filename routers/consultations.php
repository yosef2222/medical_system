<?php
function route($method, $urlList, $requestData)
{
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $database = "backend";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $size = isset($_GET['size']) ? intval($_GET['size']) : 5;

    // Calculate the offset based on the page and size
    $offset = ($page - 1) * $size;
    switch ($method) {
        case 'GET':
            if (isValidInt($urlList[1])) {
                $consultation_id = $urlList[1];
                $result = $conn->query("SELECT * FROM consultation WHERE id='$consultation_id' LIMIT $size OFFSET $offset");
                if (!$result) {
                    // Handle query error
                    setHTTPStatus(500, $conn->error);
                } else {
                    // Fetch associative array
                    while ($row = $result->fetch_assoc()) {
                        // $row contains the data for each row
                        $rowData[] = $row;
                    }

                    // Free the result set
                    $result->free();
                }

                $jsonData = array(
                    "consultations" => $rowData,
                    "pagination" => array(
                        "size" => count($rowData),
                        "count" => count($rowData),
                        "current" => 1
                    )
                );

                $jsonOutput = json_encode($jsonData);

                // Output the JSON
                echo $jsonOutput;
            } else {
                $token = getTokenFromHeaders();
                $result = $conn->query("SELECT user_id FROM tokens WHERE tokenValue='$token'");

                if (!$result) {
                    die("Error in SQL query: " . $conn->error);
                }

                $user_id = $result->fetch_assoc();
                $id_user = $user_id['user_id'];
                $doctor_id = $id_user;
                $result = $conn->query("SELECT speciality_id FROM doctor WHERE id='$doctor_id'")->fetch_assoc();
                if (!$result) {
                    setHTTPStatus(500, $conn->error);
                } else {
                    $speciality_id = $result['speciality_id'];
                    $result = $conn->query("SELECT * FROM inspection WHERE doctor_id IN (SELECT id FROM doctor WHERE speciality_id = '$speciality_id') LIMIT $size OFFSET $offset");
                    if (!$result) {
                        // Handle query error
                        setHTTPStatus(500, $conn->error);
                    } else {
                        // Fetch associative array
                        while ($row = $result->fetch_assoc()) {
                            // $row contains the data for each row
                            $rowData[] = $row;
                        }

                        // Free the result set
                        $result->free();
                    }

                    $jsonData = array(
                        "consultations" => $rowData,
                        "pagination" => array(
                            "size" => count($rowData),
                            "count" => count($rowData),
                            "current" => 1
                        )
                    );

                    $jsonOutput = json_encode($jsonData);

                    // Output the JSON
                    echo $jsonOutput;
                }
            }
            break;
        default:
            break;
    }
}
