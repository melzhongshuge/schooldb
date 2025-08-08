<?php
require 'config.php';

// Deletes a student record based on the provided ID.

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
        $sql = "DELETE FROM students WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            header("Location: display.php");
            exit();
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        echo "<script>
            if (confirm('Are you sure you want to delete this record?')) {
                window.location.href = 'delete.php?id=$id&confirm=yes';
            } else {
                window.location.href = 'display.php';
            }
            </script>";
    }
} else {
    echo "No ID provided for deletion.";
}
?>
