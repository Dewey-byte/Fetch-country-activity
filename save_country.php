<?php
header('Content-Type: application/json');

// 1. Get JSON input
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// 2. Check if data is valid
if (!$data || !isset($data['name'], $data['capital'], $data['region'], $data['flags'])) {
    echo json_encode(['error' => 'Invalid or incomplete data.']);
    exit;
}

// 3. Extract values
$name = $data['name'];
$capital = $data['capital'];
$region = $data['region'];
$flag = $data['flags'];

// 4. Connect to MySQL (update with your actual DB credentials)
$conn = new mysqli("localhost", "root", "", "lenterna");

if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

// 5. Insert into DB (make sure you have a table named `countries`)
$stmt = $conn->prepare("INSERT INTO countries (name, capital, region, flag) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $capital, $region, $flag);

if ($stmt->execute()) {
    echo json_encode(['message' => 'Country saved successfully!']);
} else {
    echo json_encode(['error' => 'Insert failed: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
