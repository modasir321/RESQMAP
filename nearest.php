<?php
if (isset($_GET['latitude']) && isset($_GET['longitude']) && isset($_GET['place_type'])) {
    $user_latitude = doubleval($_GET['latitude']);
    $user_longitude = doubleval($_GET['longitude']);
    $place_type = $_GET['place_type'];

    $host = 'localhost';
    $user = 'root';
    $password = '';
    $database = 'user';

    $conn = new mysqli($host, $user, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Use a switch statement to dynamically set the table name based on place_type
    switch ($place_type) {
        case 'petrol_pump':
        case 'hospitals':
        case 'police_station':
            // Adjust the SQL query to match your table names and column names
            $query = "SELECT *, 
              (6371 * acos(cos(radians($user_latitude)) * cos(radians(Latitude)) * cos(radians(Longitude) - radians($user_longitude)) + sin(radians($user_latitude)) * sin(radians(Latitude))))
              AS distance
              FROM $place_type
              ORDER BY distance ASC
              LIMIT 1";

            $result = $conn->query($query);

            if ($result) {
                $row = $result->fetch_assoc();
                if ($row) {
                    // Check if the expected columns exist in the result
                    $name = isset($row['Name']) ? $row['Name'] : 'N/A';
                    $address = isset($row['Address']) ? $row['Address'] : 'N/A';
                    $phone_number = isset($row['Phone']) ? $row['Phone'] : 'N/A';

                    // Return the result as JSON
                    $response = array(
                        'name' => $name,
                        'address' => $address,
                        'phone_number' => $phone_number,
                        'distance' => $row['distance']
                    );
                    header('Content-Type: application/json');
                    echo json_encode($response);
                } else {
                    echo json_encode(array('error' => "No places found in the database for $place_type."));
                }
            } else {
                echo json_encode(array('error' => "Error executing the query: " . $conn->error));
            }
            break;

        default:
            echo json_encode(array('error' => "Invalid place_type specified."));
            break;
    }
    $conn->close();
} else {
    echo json_encode(array('error' => "Latitude, longitude, and place_type parameters are required."));
}
