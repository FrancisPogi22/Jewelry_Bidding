<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'jewelry_db') or die("Could not connect to MySQL: " . mysqli_error($conn));

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['productId']) && isset($_POST['bidAmount']) && isset($_POST['userId'])) {
    $productId = $_POST['productId'];
    $bidAmount = $_POST['bidAmount'];
    $userId = $_POST['userId'];
    $stmt = $conn->prepare("SELECT MAX(bid_amount) AS highest_bid FROM bids WHERE product_id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $highestBid = $row['highest_bid'];

        if ($bidAmount > $highestBid) {
            $insertStmt = $conn->prepare("INSERT INTO bids (product_id, bid_amount, user_id) VALUES (?, ?, ?)");
            $insertStmt->bind_param("idi", $productId, $bidAmount, $userId);
            if ($insertStmt->execute()) {
                echo "Bid submitted successfully.";
            } else {
                echo "Error placing bid: " . $conn->error;
            }
        } else {
            echo "Error: Your bid must be higher than the current highest bid of $" . $highestBid;
        }
    } else {
        $insertStmt = $conn->prepare("INSERT INTO bids (product_id, bid_amount, user_id) VALUES (?, ?, ?)");
        $insertStmt->bind_param("idi", $productId, $bidAmount, $userId);
        if ($insertStmt->execute()) {
            echo "Bid placed successfully!";
        } else {
            echo "Error placing bid: " . $conn->error;
        }
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
