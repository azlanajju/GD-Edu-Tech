<?php
session_start();
require_once '../config.php';

// Handle course deletion
if (isset($_GET['delete']) && isset($_GET['id'])) {
    $course_id = intval($_GET['id']);
    $query = "DELETE FROM Courses WHERE course_id = $course_id";
    if (mysqli_query($conn, $query)) {
        $_SESSION['message'] = "Course deleted successfully.";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Error deleting course: " . mysqli_error($conn);
        $_SESSION['message_type'] = "danger";
    }
    header("Location: courses.php");
    exit();
}

// Pagination
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Fetch total number of courses
$total_courses_query = mysqli_query($conn, "SELECT COUNT(*) as count FROM Courses");
$total_courses_row = mysqli_fetch_assoc($total_courses_query);
$total_courses = $total_courses_row['count'];
$total_pages = ceil($total_courses / $limit);

// Fetch courses with pagination
$query = "SELECT * FROM Courses ORDER BY date_created DESC LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);

// Get admin details from session
$admin_name = $_SESSION['first_name'] ?? 'Admin';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Management - GD Edu Tech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 sidebar">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 min-vh-100">
                    <a href="#" class="d-flex align-items-center pb-3 mb-md-1 mt-md-3 me-md-auto text-white text-decoration-none">
                    <span class="fs-5 fw-bolder" style="display: flex;align-items:center;color:black;"><img height="35px" src="../images/edutechLogo.png" alt="">&nbsp; GD Edu Tech</span>
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
                            <a href="courses.php" class="nav-link active">
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
                            <h2>Course Management</h2>
                            <p class="text-muted">Manage and organize courses</p>
                        </div>
                        <div class="col-auto">
                            <a href="insert_course.php" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-2"></i>Add New Course
                            </a>
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

                    <!-- Courses Table -->
                    <div class="card shadow-sm">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                            <table class="table table-hover mb-0">
    <thead class="bg-primary text-white">
        <tr>
            <th class="py-3 px-4 fw-bold">ID</th>
            <th class="py-3 px-4 fw-bold">Title</th>
            <th class="py-3 px-4 fw-bold">Category</th>
            <th class="py-3 px-4 fw-bold">Price</th>
            <th class="py-3 px-4 fw-bold">Level</th>
            <th class="py-3 px-4 fw-bold">Status</th>
            <th class="py-3 px-4 fw-bold">Created By</th>
            <th class="py-3 px-4 fw-bold">Date Created</th>
            <th class="py-3 px-4 fw-bold">Thumbnail</th>
            <th class="py-3 px-4 fw-bold text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($course = mysqli_fetch_assoc($result)): ?>
            <tr class="align-middle">
                <td class="px-4"><?php echo htmlspecialchars($course['course_id']); ?></td>
                <td class="px-4"><?php echo htmlspecialchars($course['title']); ?></td>
                <td class="px-4"><?php echo htmlspecialchars($course['category_id']); ?></td>
                <td class="px-4"><?php echo htmlspecialchars($course['price']); ?></td>
                <td class="px-4"><?php echo htmlspecialchars($course['level']); ?></td>
                <td class="px-4"><?php echo htmlspecialchars($course['status']); ?></td>
                <td class="px-4"><?php echo htmlspecialchars($course['created_by']); ?></td>
                <td class="px-4"><?php echo date('Y-m-d H:i', strtotime($course['date_created'])); ?></td>
                <td class="px-4">
                    <?php if ($course['thumbnail']): ?>
                        <img src="./thumbnails/<?php echo htmlspecialchars($course['thumbnail']); ?>" alt="Course Thumbnail" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                    <?php else: ?>
                        <span>No Thumbnail</span>
                    <?php endif; ?>
                </td>
                <td class="px-4 text-center">
                    <div class="btn-group" role="group">
                        <a href="edit_course.php?id=<?php echo $course['course_id']; ?>"
                            class="btn btn-sm btn-outline-primary rounded me-1"
                            title="Edit Course">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="courses.php?delete=1&id=<?php echo $course['course_id']; ?>"
                            class="btn btn-sm btn-outline-danger rounded"
                            onclick="return confirm('Are you sure you want to delete this course?');"
                            title="Delete Course">
                            <i class="bi bi-trash"></i>
                        </a>
                    </div>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <nav aria-label="Page navigation" class="mt-3">
                        <ul class="pagination justify-content-center">
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                    <a class="page-link" href="courses.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
