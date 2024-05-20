<?php include('db_connect.php') ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Image Upload and Delete</title>
</head>
<body>

<?php

// Check if image ID is provided for deletion
if (isset($_GET['id'])) {
    $image_id = $_GET['id'];
    
    // Use prepared statement to avoid SQL injection
    $stmt = $conn->prepare("SELECT path FROM images WHERE id = ?");
    $stmt->bind_param("i", $image_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $image_path = $row['path'];
        
        // Delete image file from upload folder
        if (unlink($image_path)) {
            // Delete image record from the database
            $delete_stmt = $conn->prepare("DELETE FROM images WHERE id = ?");
            $delete_stmt->bind_param("i", $image_id);
            
            if ($delete_stmt->execute()) {
                echo "Image deleted successfully from both database and folder.";
            } else {
                echo "Error deleting record: " . $delete_stmt->error;
            }
        } else {
            echo "Error deleting image file.";
        }
    } else {
        echo "Image not found in the database.";
    }
}

// Handle image deletion via POST request
if (isset($_POST['delete_image'])) {
    $image_id = $_POST['image_id'];
    
    // Use prepared statement to avoid SQL injection
    $stmt = $conn->prepare("SELECT image_url FROM images WHERE id = ?");
    $stmt->bind_param("i", $image_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $image_url = $row['image_url'];
        
        // Delete the image file from the folder
        $file_path = "../uploads/" . $image_url;
        if (file_exists($file_path)) {
            if (unlink($file_path)) {
                // Delete the image record from the database
                $delete_stmt = $conn->prepare("DELETE FROM images WHERE id = ?");
                $delete_stmt->bind_param("i", $image_id);
                if ($delete_stmt->execute()) {
                    echo "Image deleted successfully!";
                } else {
                    echo "Error deleting image: " . $delete_stmt->error;
                }
            } else {
                echo "Error deleting image file.";
            }
        } else {
            echo "Image file not found.";
        }
    } else {
        echo "Image not found in the database.";
    }
}

// Populate dropdown with image IDs and URLs
echo '<form method="post">';
echo '<h2>Delete Image</h2>';
echo '<select name="image_id">';

// Fetch image IDs and URLs from the database to populate the dropdown
$sql_select_images = "SELECT id, image_url FROM images";
$result_images = $conn->query($sql_select_images);

if ($result_images->num_rows > 0) {
    while ($row = $result_images->fetch_assoc()) {
        $image_id = $row['id'];
        $image_url = $row['image_url'];
        echo '<option value="' . $image_id . '">' . $image_url . '</option>';
    }
}

echo '</select>';
echo '<input type="submit" value="Delete Image" name="delete_image">';
echo '</form>';

$conn->close();
?>
</body>
</html>
