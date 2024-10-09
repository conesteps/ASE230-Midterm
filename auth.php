<?php
session_start();

// File to store user data
$usersFile = 'users.txt';

// Handle form submission for sign-up and sign-in
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['signup'])) {
        // Sign Up logic
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password']; // Store password as plain text

        // Create a new user with first name, last name, username, email, and plain-text password
        $newUser = [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'username' => $username,
            'email' => $email,
            'password' => $password
        ];

        // Append user to file
        file_put_contents($usersFile, json_encode($newUser) . PHP_EOL, FILE_APPEND);
        header("Location: auth.php?signup_success=1");
        exit;
    } elseif (isset($_POST['signin'])) {
        // Sign In logic
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Check user credentials
        $users = file($usersFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($users as $userData) {
            $user = json_decode($userData, true);
            if ($user['email'] === $email && $user['password'] === $password) { // Check plain-text password
                // User authenticated, start session
                $_SESSION['username'] = $user['username'];
                header("Location: auth.php?login_success=1");
                exit;
            }
        }
        header("Location: auth.php?login_failed=1");
        exit;
    }
}

// Sign out
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: auth.php?logged_out=1");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="User Authentication" />
    <meta name="author" content="" />
    <title>Authentication</title>

    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@100;200;300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
</head>
<body class="d-flex flex-column h-100">
    <main class="flex-shrink-0">
        <!-- Navigation (Matching contact.html style) -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
            <div class="container px-5">
                <a class="navbar-brand" href="index.php"><span class="fw-bolder text-primary">Project Portfolio</span></a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 small fw-bolder">
                        <?php if (isset($_SESSION['username'])): ?>
                        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="projects.php">Projects</a></li>
						<li class="nav-item"><a class="nav-link" href="users.php">Users</a></li>
                        <li class="nav-item"><a class="nav-link" href="auth.php?logout=1">Sign Out</a></li>
                        <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="auth.php">Sign In</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Page content -->
        <section class="py-5">
            <div class="container px-5 my-5">
                <?php if (isset($_SESSION['username'])): ?>
                <!-- Display Welcome Message if signed in -->
                <div class="text-center mb-5">
                    <h1 class="fw-bolder">Welcome, <?= htmlspecialchars($_SESSION['username']); ?>!</h1>
                    <p class="lead fw-normal text-muted mb-0">You are signed in.</p>
                </div>
                <?php else: ?>
                <div class="row gx-5 justify-content-center">
                    <div class="col-lg-8 col-xl-6">
                        <div class="card shadow border-0 rounded-4">
                            <div class="card-body p-5">
                                <div class="text-center mb-5">
                                    <h1 class="fw-bolder">Sign In or Sign Up</h1>
                                </div>

                                <form method="POST" action="auth.php">
                                    <h2 class="h4 mb-3">Sign Up</h2>
                                    <div class="form-floating mb-3">
                                        <input class="form-control" type="text" name="first_name" placeholder="First Name" required>
                                        <label for="first_name">First Name</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input class="form-control" type="text" name="last_name" placeholder="Last Name" required>
                                        <label for="last_name">Last Name</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input class="form-control" type="text" name="username" placeholder="Username" required>
                                        <label for="username">Username</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input class="form-control" type="email" name="email" placeholder="Email" required>
                                        <label for="email">Email</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input class="form-control" type="password" name="password" placeholder="Password" required>
                                        <label for="password">Password</label>
                                    </div>
                                    <div class="d-grid">
                                        <button type="submit" name="signup" class="btn btn-primary">Sign Up</button>
                                    </div>
                                </form>

                                <hr class="my-4">

                                <!-- Sign In Form -->
                                <form method="POST" action="auth.php">
                                    <h2 class="h4 mb-3">Sign In</h2>
                                    <div class="form-floating mb-3">
                                        <input class="form-control" type="email" name="email" placeholder="Email" required>
                                        <label for="email">Email</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input class="form-control" type="password" name="password" placeholder="Password" required>
                                        <label for="password">Password</label>
                                    </div>
                                    <div class="d-grid">
                                        <button type="submit" name="signin" class="btn btn-primary">Sign In</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <footer class="bg-white py-4 mt-auto">
        <div class="container px-5">
            <div class="row align-items-center justify-content-between flex-column flex-sm-row">
                <div class="col-auto"><div class="small m-0">&copy; Project Portfolio 2024</div></div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap core JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>
