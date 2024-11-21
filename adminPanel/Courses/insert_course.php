<?php
session_start();
require_once '../config.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = floatval($_POST['price']);
    $language = mysqli_real_escape_string($conn, $_POST['language']);
    $level = mysqli_real_escape_string($conn, $_POST['level']);
    $category_id = intval($_POST['category_id']);
    $course_type = mysqli_real_escape_string($conn, $_POST['course_type']);
    $isPopular = mysqli_real_escape_string($conn, $_POST['isPopular']);

    // Image upload handling
    $thumbnail = null;
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == 0) {
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $file_extension = pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION);

        if (in_array(strtolower($file_extension), $allowed_extensions)) {
            $thumbnail_dir = './thumbnails/';
            $thumbnail_name = uniqid('course_', true) . '.' . $file_extension;
            $thumbnail_path = $thumbnail_dir . $thumbnail_name;

            // Ensure the directory exists
            if (!is_dir($thumbnail_dir)) {
                mkdir($thumbnail_dir, 0777, true);
            }

            // Move uploaded file to the designated directory
            if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $thumbnail_path)) {
                $thumbnail = $thumbnail_name;
            } else {
                $_SESSION['message'] = "Failed to upload thumbnail.";
                $_SESSION['message_type'] = "danger";
            }
        } else {
            $_SESSION['message'] = "Invalid file type for thumbnail. Only JPG, JPEG, PNG, GIF are allowed.";
            $_SESSION['message_type'] = "danger";
        }
    }

    // Insert course into the database
    if ($title && $description && $price >= 0 && $level && $category_id) {
        $created_by = $_SESSION['user_id']; // assuming user_id is stored in session
        $query = "INSERT INTO Courses (title, description, price, language, level, created_by, category_id, course_type, status, isPopular, thumbnail) 
                  VALUES ('$title', '$description', '$price', '$language', '$level', '$created_by', '$category_id', '$course_type', 'draft', '$isPopular', '$thumbnail')";
        
        if (mysqli_query($conn, $query)) {
            $_SESSION['message'] = "Course added successfully!";
            $_SESSION['message_type'] = "success";
            header("Location: courses.php");
            exit();
        } else {
            $_SESSION['message'] = "Error adding course: " . mysqli_error($conn);
            $_SESSION['message_type'] = "danger";
        }
    } else {
        $_SESSION['message'] = "Please fill in all required fields.";
        $_SESSION['message_type'] = "danger";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Course - GD Edu Tech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 sidebar">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 min-vh-100">
                    <a href="#" class="d-flex align-items-center pb-3 mb-md-1 mt-md-3 me-md-auto text-white text-decoration-none">
                        <span class="fs-5 fw-bolder" style="display: flex; align-items:center;color:black;"><img height="35px" src="../images/edutechLogo.png" alt="">&nbsp; GD Edu Tech</span>
                    </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start w-100" id="menu">
                        <li class="w-100">
                            <a href="../index.php" class="nav-link">
                                <i class="bi bi-speedometer2 me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="w-100">
                            <a href="categories.php" class="nav-link">
                                <i class="bi bi-grid me-2"></i> Categories
                            </a>
                        </li>
                        <li class="w-100">
                            <a href="courses.php" class="nav-link">
                                <i class="bi bi-book me-2"></i> Courses
                            </a>
                        </li>
                        <li class="w-100">
                            <a href="lessons.php" class="nav-link">
                                <i class="bi bi-journal-text me-2"></i> Lessons
                            </a>
                        </li>
                        <li class="w-100">
                            <a href="videos.php" class="nav-link">
                                <i class="bi bi-play-circle me-2"></i> Videos
                            </a>
                        </li>
                        <li class="w-100">
                            <a href="faq.php" class="nav-link">
                                <i class="bi bi-question-circle me-2"></i> FAQ
                            </a>
                        </li>
                        <li class="w-100">
                            <a href="users.php" class="nav-link">
                                <i class="bi bi-people me-2"></i> Users
                            </a>
                        </li>
                        <li class="w-100 mt-auto">
                            <a href="logout.php" class="nav-link text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col py-3">
                <div class="container-fluid">
                    <!-- Header -->
                    <div class="row mb-4">
                        <div class="col">
                            <h2>Add New Course</h2>
                            <p class="text-muted">Fill the form below to add a new course</p>
                        </div>
                    </div>

                    <!-- Alert Messages -->
                    <?php if (isset($_SESSION['message'])): ?>
                        <div class="alert alert-<?php echo $_SESSION['message_type']; ?> alert-dismissible fade show" role="alert">
                            <?php
                            echo htmlspecialchars($_SESSION['message']);
                            unset($_SESSION['message']);
                            unset($_SESSION['message_type']);
                            ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Course Form -->
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="title" class="form-label">Course Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="price" name="price" min="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="language" class="form-label">Language</label>
                            <input type="text" class="form-control" id="language" name="language">
                        </div>
                        <div class="mb-3">
                            <label for="level" class="form-label">Level</label>
                            <select class="form-select" id="level" name="level" required>
                                <option value="beginner">Beginner</option>
                                <option value="intermediate">Intermediate</option>
                                <option value="advanced">Advanced</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <option value="">Select Category</option>
                                <?php
                                // Fetch categories for the dropdown
                                $categories_query = mysqli_query($conn, "SELECT * FROM Categories");
                                while ($category = mysqli_fetch_assoc($categories_query)): ?>
                                    <option value="<?php echo $category['category_id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="course_type" class="form-label">Course Type</label>
                            <input type="text" class="form-control" id="course_type" name="course_type">
                        </div>
                        <div class="mb-3">
                            <label for="isPopular" class="form-label">Is Popular?</label>
                            <select class="form-select" id="isPopular" name="isPopular">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="thumbnail" class="form-label">Thumbnail</label>
                            <input type="file" class="form-control" id="thumbnail" name="thumbnail">
                        </div>
                        <button type="submit" class="btn btn-primary">Add Course</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
