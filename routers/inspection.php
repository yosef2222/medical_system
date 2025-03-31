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
                $patient_id = $urlList[1];
                if ($urlList[2] == "chain") {
                    //TODO the chain of inspections
                } else {
                    //TODO
                }
            } else {
                setHTTPStatus(500, $conn->error);
            }
            break;
        case 'PUT':
            $token = getTokenFromHeaders();
            $result = $conn->query("SELECT user_id FROM tokens WHERE tokenValue='$token'");

            if (!$result) {
                die("Error in SQL query: " . $conn->error);
            }

            $user_id = $result->fetch_assoc();
            $id_user = $user_id['user_id'];
            $doctor_id = $id_user;
            if (isValidInt($urlList[1])) {
                $inspection_id = $urlList[1];
                $result = $conn->query("SELECT * FROM inspection WHERE id='$inspection_id' LIMIT $size OFFSET $offset");
                $inspectionsArray = $result->fetch_assoc();

                if ($inspectionsArray['doctor_id'] == $doctor_id) {
                    $anamnesis = isset($requestData->body->anamnesis) ? $requestData->body->anamnesis : null;
                    $complaints = isset($requestData->body->complaints) ? $requestData->body->complaints : null;
                    $treatment = isset($requestData->body->treatment) ? $requestData->body->treatment : null;
                    $conclusion = isset($requestData->body->conclusion) ? $requestData->body->conclusion : null;
                    $updateQuery = "UPDATE inspection SET 
                    complaints = '$complaints', 
                    anamnesis = '$anamnesis', 
                    treatment = '$treatment', 
                    conclusion = '$conclusion' 
                WHERE id = $inspection_id";

                    $updateResult = $conn->query($updateQuery);

                    if (!$updateResult) {
                        setHTTPStatus(500, $conn->error);
                    } else {
                        echo "Inspection was updated successfully\n";
                    }

                    if (!empty($requestData->body->diagnoses)) {
                        $diagnosis = $requestData->body->diagnoses[0];
                        $diagnosis_code = $diagnosis->diagnosis_code;
                        $description = $diagnosis->description;
                        $type = $diagnosis->type;
                    }

                    $name = getDiagnose($diagnosis_code);
                    $updateQuery = "UPDATE diagnosis SET 
                    code = '$diagnosis_code', 
                    name = '$name', 
                    description = '$description', 
                    type = '$type'
                    WHERE inspection_id = $inspection_id";

                    $updateResult = $conn->query($updateQuery);
                    if (!$updateResult) {
                        setHTTPStatus(500, $conn->error);
                    } else {
                        echo "diagnose was updated successfully\n";
                    }
                } else {
                    setHTTPStatus(401, "Unauthorized");
                }
            } else {
                setHTTPStatus(500, $conn->error);
            }
            break;
        default:
            break;
    }
}
