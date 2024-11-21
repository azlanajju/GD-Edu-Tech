<?php
session_start();
require_once '../config.php';

// Function to safely delete a file
function safeDeleteFile($filepath) {
    if (file_exists($filepath) && is_file($filepath)) {
        return unlink($filepath);
    }
    return false;
}

if (isset($_GET['id'])) {
    // Sanitize the input
    $course_id = intval($_GET['id']);

    // First, fetch the course details to get the thumbnail
    $fetch_query = "SELECT thumbnail FROM Courses WHERE course_id = $course_id";
    $result = mysqli_query($conn, $fetch_query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $course = mysqli_fetch_assoc($result);
        $thumbnail = $course['thumbnail'];

        // Delete the thumbnail image if it exists
        if (!empty($thumbnail)) {
            $thumbnail_path = "./thumbnails/" . $thumbnail;
            if (safeDeleteFile($thumbnail_path)) {
                error_log("Thumbnail deleted: $thumbnail_path");
            } else {
                error_log("Failed to delete thumbnail: $thumbnail_path");
            }
        }

        // Delete the course from the database
        $delete_query = "DELETE FROM Courses WHERE course_id = $course_id";
        
        if (mysqli_query($conn, $delete_query)) {
            // Success message
            $_SESSION['message'] = "Course and associated thumbnail deleted successfully.";
            $_SESSION['message_type'] = "success";
        } else {
            // Error message if database deletion fails
            $_SESSION['message'] = "Error deleting course: " . mysqli_error($conn);
            $_SESSION['message_type'] = "danger";
        }
    } else {
        // Course not found
        $_SESSION['message'] = "Course not found.";
        $_SESSION['message_type'] = "warning";
    }

    // Redirect back to courses page
    header("Location: courses.php");
    exit();
} else {
    // No course ID provided
    $_SESSION['message'] = "No course ID provided.";
    $_SESSION['message_type'] = "danger";
    header("Location: courses.php");
    exit();
}
?>