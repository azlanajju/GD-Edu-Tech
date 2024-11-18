<?php
session_start();

// Database connection
require_once '../config.php';

// Handle user deletion
if (isset($_GET['delete']) && isset($_GET['id'])) {
    $user_id = intval($_GET['id']);
    
    $query = "DELETE FROM Users WHERE user_id = $user_id";
    if (mysqli_query($conn, $query)) {
        $_SESSION['message'] = "User deleted successfully.";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Error deleting user: " . mysqli_error($conn);
        $_SESSION['message_type'] = "danger";
    }
    
    header("Location: users.php");
    exit();
}

// Pagination
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Fetch total number of users
$total_users_query = mysqli_query($conn, "SELECT COUNT(*) as count FROM Users");
$total_users_row = mysqli_fetch_assoc($total_users_query);
$total_users = $total_users_row['count'];
$total_pages = ceil($total_users / $limit);

// Fetch users with pagination
$query = "SELECT * FROM Users ORDER BY date_joined DESC LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);

// Get admin details from session
$admin_name = $_SESSION['first_name'] ?? 'Admin';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Management - GD Edu Tech</title>
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
                        <span class="fs-5 fw-bolder">GD Edu Tech</span>
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
                            <a href="users.php" class="nav-link active">
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
                            <h2>User Management</h2>
                            <p class="text-muted">Manage and monitor platform users</p>
                        </div>
                        <div class="col-auto">
                            <a href="add_user.php" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-2"></i>Add New User
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

                    <!-- Users Table -->
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Date Joined</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($user = mysqli_fetch_assoc($result)): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                                            <td><?php echo htmlspecialchars($user['first_name']); ?></td>
                                            <td><?php echo htmlspecialchars($user['last_name']); ?></td>
                                            <td><?php echo htmlspecialchars($user['role']); ?></td>
                                            <td>
                                                <span class="badge 
                                                <?php 
                                                echo $user['status'] == 'active' ? 'bg-success' : 
                                                     ($user['status'] == 'inactive' ? 'bg-warning' : 'bg-danger'); 
                                                ?>">
                                                    <?php echo htmlspecialchars($user['status']); ?>
                                                </span>
                                            </td>
                                            <td><?php echo date('Y-m-d', strtotime($user['date_joined'])); ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="edit_user.php?id=<?php echo $user['user_id']; ?>" class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <a href="users.php?delete=1&id=<?php echo $user['user_id']; ?>" 
                                                       class="btn btn-sm btn-outline-danger"
                                                       onclick="return confirm('Are you sure you want to delete this user?');">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <nav aria-label="User list pagination">
                                <ul class="pagination justify-content-center">
                                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                        <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                                            <a class="page-link" href="users.php?page=<?php echo $i; ?>">
                                                <?php echo $i; ?>
                                            </a>
                                        </li>
                                    <?php endfor; ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>