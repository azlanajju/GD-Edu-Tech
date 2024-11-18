<?php
session_start();

// Check if user is logged in and is admin
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
//     header('Location: login.php');
//     exit();
// }

// Get admin details from session
$admin_name = $_SESSION['first_name'] ?? 'Admin';
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
                        <span class="fs-5 fw-bolder">GD Edu Tech</span>
                    </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start w-100" id="menu">
                        <li class="w-100">
                            <a href="admin_dashboard.php" class="nav-link active">
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
                            <p class="text-muted">Here's what's happening with your platform today.</p>
                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-3">
                            <div class="card stats-card">
                                <div class="card-body">
                                    <h6 class="card-title">Total Users</h6>
                                    <h2>2,543</h2>
                                    <p class="mb-0"><i class="bi bi-arrow-up"></i> 12% this month</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card stats-card">
                                <div class="card-body">
                                    <h6 class="card-title">Active Courses</h6>
                                    <h2>48</h2>
                                    <p class="mb-0"><i class="bi bi-arrow-up"></i> 3 new this week</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card stats-card">
                                <div class="card-body">
                                    <h6 class="card-title">Total Revenue</h6>
                                    <h2>$12,845</h2>
                                    <p class="mb-0"><i class="bi bi-arrow-up"></i> 8% this month</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card stats-card">
                                <div class="card-body">
                                    <h6 class="card-title">Course Completion</h6>
                                    <h2>76%</h2>
                                    <p class="mb-0"><i class="bi bi-arrow-up"></i> 5% increase</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activities & Quick Actions -->
                    <div class="row mb-4">
                        <!-- Recent Activities -->
                        <div class="col-md-8">
                            <div class="card table-card">
                                <div class="card-header bg-white">
                                    <h5 class="card-title mb-0">Recent Activities</h5>
                                </div>
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
                                            <tr>
                                                <td>John Doe</td>
                                                <td>Enrolled in Web Development</td>
                                                <td>Today, 10:30 AM</td>
                                                <td><span class="badge bg-success">Completed</span></td>
                                            </tr>
                                            <tr>
                                                <td>Jane Smith</td>
                                                <td>Submitted Assignment</td>
                                                <td>Today, 09:15 AM</td>
                                                <td><span class="badge bg-warning">Pending</span></td>
                                            </tr>
                                            <tr>
                                                <td>Mike Johnson</td>
                                                <td>Completed Python Course</td>
                                                <td>Yesterday</td>
                                                <td><span class="badge bg-info">Verified</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
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
                                        <div class="progress">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 50%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Users & Course Status -->
                    <div class="row">
                        <!-- Recent Users -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Recent Users</h5>
                                    <button class="btn btn-sm btn-outline-primary">View All</button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>User</th>
                                                <th>Role</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Sarah Wilson</td>
                                                <td>Student</td>
                                                <td>
                                                    <i class="bi bi-pencil action-icon"></i>
                                                    <i class="bi bi-trash action-icon text-danger"></i>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Mark Davis</td>
                                                <td>Instructor</td>
                                                <td>
                                                    <i class="bi bi-pencil action-icon"></i>
                                                    <i class="bi bi-trash action-icon text-danger"></i>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Popular Courses -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Popular Courses</h5>
                                    <button class="btn btn-sm btn-outline-primary">View All</button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Course</th>
                                                <th>Students</th>
                                                <th>Rating</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Web Development</td>
                                                <td>234</td>
                                                <td>
                                                    <i class="bi bi-star-fill text-warning"></i> 4.8
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Python Programming</td>
                                                <td>186</td>
                                                <td>
                                                    <i class="bi bi-star-fill text-warning"></i> 4.6
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>