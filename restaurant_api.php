<?php

require_once "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $description = $_POST["description"];

    $sql = "INSERT INTO restaurants (name, description) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $name, $description);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Restaurant created successfully"]);
    } else {
        echo json_encode(["error" => "Failed to create restaurant"]);
    }
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_GET["id"])) {
        $restaurant_id = $_GET["id"];

        $sql = "SELECT * FROM restaurants WHERE id = ? AND deleted_at IS NULL";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $restaurant_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            echo json_encode($row);
        } else {
            echo json_encode(["error" => "Restaurant not found or soft-deleted."]);
        }
    } else {
        echo json_encode(["error" => "Restaurant ID not provided"]);
    }
}

if ($_SERVER["REQUEST_METHOD"] === "PUT") {
    parse_str(file_get_contents("php://input"), $_PUT);
    $restaurant_id = $_PUT["id"];
    $name = $_PUT["name"];
    $description = $_PUT["description"];

    $sql = "UPDATE restaurants SET name = ?, description = ? WHERE id = ? AND deleted_at IS NULL";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $name, $description, $restaurant_id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Restaurant updated successfully"]);
    } else {
        echo json_encode(["error" => "Failed to update restaurant"]);
    }
}

if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    parse_str(file_get_contents("php://input"), $_DELETE);
    $restaurant_id = $_DELETE["id"];

    $sql = "UPDATE restaurants SET deleted_at = NOW() WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $restaurant_id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Restaurant deleted (soft delete) successfully"]);
    } else {
        echo json_encode(["error" => "Failed to delete restaurant"]);
    }
}

$conn->close();
