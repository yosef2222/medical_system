<?php

function getDiagnose($searchCode)
{
    // Read the JSON file content
    $jsonPath = __DIR__ . '\..\routers\icd10\icd10.json';
    $jsonContent = file_get_contents($jsonPath);

    // Decode the JSON content into a PHP array
    $data = json_decode($jsonContent, true);

    // Check if decoding was successful
    if ($data === null) {
        die('Error decoding JSON');
    }

    // Specify the code you want to search for
    $matchingRecords = [];
    // Iterate through the records
    foreach ($data['records'] as $record) {
        // Check if the MKB_CODE matches the search code
        if ($record['MKB_CODE'] === $searchCode) {
            // Append relevant data to the array
            return $record['MKB_NAME'];
            break;
        }
    }
}

function isValidInt($var)
{
    // Check if the variable is set and is a numeric value
    if (isset($var) && is_numeric($var)) {
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

function isValidGender($gender)
{
    if ($gender == 'Male' || $gender == 'Female') {
        return true;
    } else {
        return false;
    }
}

function isValidBirthday($birthday)
{
    // Create a DateTime object from the input date string
    $birthdayDate = DateTime::createFromFormat('Y-m-d', $birthday);

    // Check if the date is a valid date
    if ($birthdayDate === false) {
        return false; // Invalid date format
    }

    // Get today's date
    $today = new DateTime();

    // Compare the birthday date with today's date
    if ($birthdayDate < $today) {
        return true; // Valid birthday
    } else {
        return false; // Birthday is in the future
    }
}

function getTokenFromHeaders()
{
    $headers = getallheaders();

    if (isset($headers['Authorization'])) {
        $authorizationHeader = $headers['Authorization'];

        // Check if the header starts with 'Bearer '
        if (strpos($authorizationHeader, 'Bearer ') === 0) {
            // Remove the 'Bearer ' prefix and return the token
            return substr($authorizationHeader, 7);
        }
    }

    // Return null if the Authorization header or token is not found
    return null;
}
function setHTTPStatus($status = 200, $message = null)
{
    switch ($status) {
        case 200:
            $httpMessage = "HTTP/1.0 200 OK";
            break;
        case 400:
            $httpMessage = "HTTP/1.0 400 Bad Request";
            break;
        case 401:
            $httpMessage = "HTTP/1.0 401 Unauthorized";
            break;
        case 404:
            $httpMessage = "HTTP/1.0 404 Not Found";
            break;
        case 500:
            $httpMessage = "HTTP/1.0 500 Internal Server Error";
            break;
        default:
            $httpMessage = "HTTP/1.0 $status";
            break;
    }

    header($httpMessage);

    if (!is_null($message)) {
        echo json_encode(['message' => $message, 'httpMessage' => $httpMessage]);
    }
}
