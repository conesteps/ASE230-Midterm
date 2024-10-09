<?php
$content = [];
$file = file('content.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($file as $line) {
    list($key, $value) = explode('=', $line, 2);
    $content[$key] = $value;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="A platform to manage and showcase your projects" />
    <meta name="author" content="" />
    <title>Home - Project Management Portfolio</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@100;200;300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
</head>
<body class="d-flex flex-column h-100 bg-light">
    <main class="flex-shrink-0">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
            <div class="container px-5">
                <a class="navbar-brand" href="index.php"><span class="fw-bolder text-primary">Project Portfolio</span></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 small fw-bolder">
                        <li class="nav-item"><a class="nav-link" href="projects.php">Projects</a></li>
                        <li class="nav-item"><a class="nav-link" href="users.php">Users</a></li>
                        <li class="nav-item"><a class="nav-link" href="auth.php">Sign Up / Sign In</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <!-- Main Content Section -->
        <section class="py-5">
            <div class="container px-5 my-5">
                <div class="text-center mb-5">
                    <h1 class="display-5 fw-bolder"><span class="text-gradient d-inline"><?= htmlspecialchars($content['homepage_title']); ?></span></h1>
                    <p class="lead"><?= htmlspecialchars($content['homepage_intro']); ?></p>
                </div>
                <div class="row gx-5 justify-content-center">
                    <div class="col-lg-8">
                        <h3 class="fw-bolder mb-4">What You Can Do Here:</h3>
                        <ul class="list-unstyled">
                            <li class="mb-3"><i class="bi bi-plus-circle-fill text-primary"></i> <strong>Add New Projects</strong> - Store details of your projects with titles, descriptions, and more.</li>
                            <li class="mb-3"><i class="bi bi-pencil-fill text-primary"></i> <strong>Modify Existing Projects</strong> - Update your projects to keep them current as you make progress.</li>
                            <li class="mb-3"><i class="bi bi-trash-fill text-primary"></i> <strong>Delete Projects</strong> - Remove outdated projects with ease.</li>
                        </ul>
                        <div class="text-center mt-5">
                            <a href="projects.php" class="btn btn-primary btn-lg">View Your Projects</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Call to Action -->
        <section class="py-5 bg-gradient-primary-to-secondary text-white">
            <div class="container px-5 my-5">
                <div class="text-center">
                    <h4 class="display-4 fw-bolder mb-4"><?= htmlspecialchars($content['homepage_cta']); ?></h4>
                    <a class="btn btn-outline-light btn-lg px-5 py-3 fs-6 fw-bolder" href="add_project.php">Add a New Project</a>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-white py-4 mt-auto">
        <div class="container px-5">
            <div class="row align-items-center justify-content-between flex-column flex-sm-row">
                <div class="small m-0"><?= htmlspecialchars_decode($content['footer_text']); ?></div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>
