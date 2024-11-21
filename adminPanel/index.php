<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$jwtSecretKey = "your_secret_key_here";

// Check if JWT token exists in cookies
if (!isset($_COOKIE['auth_token'])) {
    header("Location: admin_login.php");
    exit();
}

try {
    // Get JWT token from cookies
    $jwt = $_COOKIE['auth_token'];
    // Decode the JWT token
    $decoded = JWT::decode($jwt, new Key($jwtSecretKey, 'HS256'));

    // Access admin details from the decoded token
    $admin_name = $decoded->first_name ?? 'Admin';
    $user_role = $decoded->role;

    // Ensure user is an admin
    if ($user_role !== 'admin') {
        header('Location: admin_login.php');
        exit();
    }

} catch (Exception $e) {
    // Handle any JWT decoding errors
    echo "Unauthorized: " . $e->getMessage();
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - GD Edu Tech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 sidebar">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 min-vh-100">
                    <a href="#" class="d-flex align-items-center pb-3 mb-md-1 mt-md-3 me-md-auto text-white text-decoration-none">
                        <span class="fs-5 fw-bolder" style="display: flex;align-items:center;color:black;"><img height="35px" src="./images/edutechLogo.png" alt="">&nbsp; GD Edu Tech</span>
                    </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start w-100" id="menu">
                        <li class="w-100">
                            <a href="admin_dashboard.php" class="nav-link active">
                                <i class="bi bi-speedometer2 me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="w-100">
                            <a href="./Categories/categories.php" class="nav-link">
                                <i class="bi bi-grid me-2"></i> Categories
                            </a>
                        </li>
                        <li class="w-100">
                            <a href="./Courses/Courses.php" class="nav-link ">
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
                            <a href="./Users/users.php" class="nav-link">
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
                <!-- Header -->
                <div class="container-fluid">
                    <div class="row mb-4">
                        <div class="col">
                            <h2>Welcome, <?php echo htmlspecialchars($admin_name); ?>!</h2>
                            <p class="text-muted ">Here's what's happening with your platform today.</p>
                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="row g-4 mb-4">
                        <!-- Add your stats card sections here -->
                    </div>

                    <!-- Recent Activities & Quick Actions -->
                    <div class="row mb-4">
                        <!-- Recent Activities -->
                        <div class="col-md-8">
                            <div class="card table-card">
                                <div class="card-header bg-white">
                                    <h5 class="card-title mb-0 color-primary">Recent Activities</h5>
                                </div>
                                <?php
                                // config.php (Database Connection)
                                require_once 'config.php';

                                // Retrieve latest 8 activities
                                $query = "SELECT 
            user_name, 
            activity_type, 
            activity_description, 
            activity_status, 
            activity_timestamp 
          FROM recent_activities 
          ORDER BY activity_timestamp DESC 
          LIMIT 8";

                                $result = $conn->query($query);
                                ?>

                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>User</th>
                                                <th>Activity</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($result->num_rows === 0): ?>
                                                <tr>
                                                    <td colspan="4" class="text-center">No recent activities found.</td>
                                                </tr>
                                            <?php else: ?>
                                                <?php while ($activity = $result->fetch_assoc()): ?>
                                                    <tr>
                                                        <td><?php echo $activity['user_name']; ?></td>
                                                        <td><?php echo $activity['activity_description']; ?></td>
                                                        <td><?php echo $activity['activity_timestamp']; ?></td>
                                                        <td><?php echo $activity['activity_status']; ?></td>
                                                    </tr>
                                                <?php endwhile; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <?php
                                // Close the connection
                                // $conn->close();
                                ?>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header bg-white">
                                    <h5 class="card-title mb-0">Quick Actions</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-primary">
                                            <i class="bi bi-plus-circle me-2"></i>Add New Course
                                        </button>
                                        <button class="btn btn-outline-primary">
                                            <i class="bi bi-person-plus me-2"></i>Create User
                                        </button>
                                        <button class="btn btn-outline-primary">
                                            <i class="bi bi-file-text me-2"></i>Generate Report
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- System Status -->
                            <div class="card mt-4">
                                <div class="card-header bg-white">
                                    <h5 class="card-title mb-0">System Status</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>Storage</span>
                                            <span>75%</span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: 75%"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>Bandwidth</span>
                                            <span>50%</span>
                                        </div>
                                        <div class="progress...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include necessary JS files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
