<?php
include_once 'helpers/helpers.php';

function route($method, $urlList, $requestData)
{
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $database = "backend";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        setHTTPStatus(500, "Connection failed");
        return;
    }
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $size = isset($_GET['size']) ? intval($_GET['size']) : 5;

    // Calculate the offset based on the page and size
    $offset = ($page - 1) * $size;

    switch ($method) {
        case 'GET':
            if (isValidInt($urlList[1])) {
                $patient_id = $urlList[1];
                if ($urlList[2] == "inspections") {
                    $result = $conn->query("SELECT * FROM inspection WHERE patient_id='$patient_id' LIMIT $size OFFSET $offset");
                    if ($result) {
                        // Fetch associative array
                        while ($row = $result->fetch_assoc()) {
                            $inspection_id = $row['id'];
                            $diagnoseResult = $conn->query("SELECT * FROM diagnosis WHERE inspection_id='$inspection_id'");

                            if ($diagnoseResult) {
                                $diagnoseArray = [];

                                while ($diagnoseRow = $diagnoseResult->fetch_assoc()) {
                                    $diagnoseArray[] = [
                                        "id" => $diagnoseRow['id'],
                                        "createTime" => $diagnoseRow['createTime'],
                                        "code" => $diagnoseRow['code'],
                                        "name" => $diagnoseRow['name'],
                                        "description" => $diagnoseRow['description'],
                                        "type" => $diagnoseRow['type'],
                                        "inspection_id" => $diagnoseRow['inspection_id']
                                    ];
                                }

                                // Add the diagnosis array to the original $row
                                $row["diagnosis"] = $diagnoseArray;

                                // Append the modified $row to $rowData
                                $rowData[] = $row;
                            } else {
                                setHTTPStatus(500, $conn->error);
                            }
                        }


                        // Free the result set
                        $result->free();
                        $conn->close();
                        //$doctor_name;
                        //$patient_name;
                        //$diagnosis;

                        // Create the JSON structure
                        $jsonData = array(
                            "inspections" => $rowData,
                            "pagination" => array(
                                "size" => count($rowData),
                                "count" => count($rowData),
                                "current" => 1
                            )
                        );

                        // Encode the data into JSON format
                        $jsonOutput = json_encode($jsonData);

                        // Output the JSON
                        echo $jsonOutput;
                    } else {
                        // Handle query error
                        setHTTPStatus(500, $conn->error);
                    }
                } else {
                    $result = $conn->query("SELECT * FROM patient WHERE id='$patient_id' LIMIT $size OFFSET $offset");
                    if ($result) {
                        $row = $result->fetch_assoc();
                        $result->free();
                    } else {
                        // Handle query error
                        setHTTPStatus(500, $conn->error);
                    }

                    // Close the connection
                    $conn->close();
                    echo json_encode($row);
                }
            } else {
                $result = $conn->query("SELECT * FROM patient LIMIT $size OFFSET $offset");
                if ($result) {
                    // Fetch associative array
                    while ($row = $result->fetch_assoc()) {
                        // $row contains the data for each row
                        $rowData[] = $row;
                    }

                    // Free the result set
                    $result->free();
                } else {
                    // Handle query error
                    setHTTPStatus(500, $conn->error);
                }

                // Close the connection
                $conn->close();

                // Create the JSON structure
                $jsonData = array(
                    "patients" => $rowData,
                    "pagination" => array(
                        "size" => count($rowData),
                        "count" => count($rowData),
                        "current" => 1
                    )
                );

                // Encode the data into JSON format
                $jsonOutput = json_encode($jsonData);

                // Output the JSON
                echo $jsonOutput;
            }
            break;
        case 'POST':
            $token = getTokenFromHeaders();
            $result = $conn->query("SELECT user_id FROM tokens WHERE tokenValue='$token'");

            if (!$result) {
                die("Error in SQL query: " . $conn->error);
            }

            $user_id = $result->fetch_assoc();
            $id_user = $user_id['user_id'];
            if (!is_null($user_id)) {
                if (isValidInt($urlList[1]) && $urlList[2] = "inspections") {
                    $patient_id = $urlList[1];
                    $date = isset($requestData->body->date) ? $requestData->body->date : null;
                    $anamnesis = isset($requestData->body->anamnesis) ? $requestData->body->anamnesis : null;
                    $complaints = isset($requestData->body->complaints) ? $requestData->body->complaints : null;
                    $treatment = isset($requestData->body->treatment) ? $requestData->body->treatment : null;
                    $conclusion = isset($requestData->body->conclusion) ? $requestData->body->conclusion : null;
                    $nextVisitDate = isset($requestData->body->nextVisitDate) ? $requestData->body->nextVisitDate : null;
                    $deathDate = isset($requestData->body->deathDate) ? $requestData->body->deathDate : "NULL";
                    $previousInspectionId = isset($requestData->body->previousInspectionId) ? $requestData->body->previousInspectionId : "NULL";
                    $doctor_id = $id_user;
                    $hasChain = isset($requestData->body->hasChain) ? $requestData->body->hasChain : "0";
                    $hasNested = isset($requestData->body->hasChain) ? $requestData->body->hasChain : "0";
                    $nextInspectionId = isset($requestData->body->hasChain) ? $requestData->body->hasChain : "NULL";

                    $inspectionInsertResults = $conn->query("INSERT INTO inspection (patient_id, date, anamnesis, complaints, treatment, conclusion, nextVisitDate, deathDate, previousInspectionId, nextInspectionId, doctor_id, hasChain, hasNested) VALUES ('$patient_id', '$date', '$anamnesis', '$complaints', '$treatment', '$conclusion', '$nextVisitDate', $deathDate, $previousInspectionId, $nextInspectionId, '$doctor_id', $hasChain, $hasNested)");

                    if (!$inspectionInsertResults) {
                        setHTTPStatus(500, $conn->error);
                    } else {
                        $lastInsertedId = $conn->insert_id;
                        $inspection_id = $lastInsertedId;
                        echo "Inspection is added successfully\n";
                    }

                    if (!empty($requestData->body->diagnoses)) {
                        $diagnosis = $requestData->body->diagnoses[0];
                        $diagnosis_code = $diagnosis->diagnosis_code;
                        $description = $diagnosis->description;
                        $type = $diagnosis->type;
                    }

                    $name = getDiagnose($diagnosis_code);
                    $diagnoseInsertResults = $conn->query("INSERT INTO diagnosis (code, name, description, type, inspection_id) VALUES ('$diagnosis_code', '$name', '$description', '$type', '$inspection_id')");
                    if (!$diagnoseInsertResults) {
                        setHTTPStatus(500, $conn->error);
                    } else {
                        echo "diagnose is added successfully\n";
                    }
                    if (!empty($requestData->body->consultations)) {
                        $consultation = $requestData->body->consultations[0];
                        $speciality_id = $consultation->speciality_id;
                        $comments = $consultation->comment;
                    }
                    $checkSpecialityQuery = "SELECT id FROM speciality WHERE id = '$speciality_id'";
                    $checkSpecialityResult =  $conn->query($checkSpecialityQuery);
                    if ($checkSpecialityResult) {
                        $consultationInsertResults = $conn->query("INSERT INTO consultation (inspection_id, speciality_id, comments) VALUES ('$inspection_id', '$speciality_id', '$comments')");
                        if (!$consultationInsertResults) {
                            setHTTPStatus(500, $conn->error);
                        } else {
                            echo "consultation is added successfully\n";
                        }
                    } else {
                        setHTTPStatus(500, "Speciality id is not valid.");
                        break;
                    }
                } else {
                    $name = $requestData->body->name;
                    $birthday = new DateTime();
                    $gender = $requestData->body->gender;
                    $birthday = $requestData->body->birthday;

                    if (!isValidName($name)) {
                        setHTTPStatus(500, "name is not valid.");
                        break;
                    }
                    if (!isValidGender($gender)) {
                        setHTTPStatus(500, "gender is not valid.");
                        break;
                    }
                    if (!isValidBirthday($birthday)) {
                        setHTTPStatus(500, "birthdate is not valid.");
                        break;
                    }
                    $userInsertResults = $conn->query("INSERT INTO patient (name, birthday, gender) VALUES('$name', '$birthday', '$gender')");

                    if (!$userInsertResults) {
                        setHTTPStatus(500, $conn->error);
                    } else {
                        echo "Patient is added successfully";
                    }
                }
            } else {
                setHTTPStatus('401', "Unauthorized");
            }
            break;
        default:
            echo "bad request";
            break;
    }
}
