<?php
$usersFile = 'users.txt';
$projectsFile = 'projects.txt';
$contentFile = 'content.txt';

$users = file_exists($usersFile) ? file($usersFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];
$projects = file_exists($projectsFile) ? file($projectsFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];

$content = file_exists($contentFile) ? file_get_contents($contentFile) : '';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Plain text password

    $newUser = [
        'first_name' => $firstName,
        'last_name' => $lastName,
        'username' => $username,
        'email' => $email,
        'password' => $password
    ];

    if (isset($_POST['id']) && is_numeric($_POST['id'])) {
        $id = $_POST['id'];
        $users[$id] = json_encode($newUser);
    } else {
        $users[] = json_encode($newUser) . PHP_EOL;
    }

    file_put_contents($usersFile, implode(PHP_EOL, $users));
    header("Location: admin.php?section=users");
    exit;
}

// Handle delete request for users
if (isset($_GET['delete_user'])) {
    $idToDelete = $_GET['delete_user'];
    unset($users[$idToDelete]);
    file_put_contents($usersFile, implode(PHP_EOL, $users));
    header("Location: admin.php?section=users");
    exit;
}

// Handle delete request for users
if (isset($_GET['delete_user'])) {
    $idToDelete = $_GET['delete_user'];
    unset($users[$idToDelete]);
    file_put_contents($usersFile, implode(PHP_EOL, $users));
    header("Location: admin.php?section=users");
    exit;
}

// Handle form submission for adding/editing projects
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];

    $newProject = [
        'title' => $title,
        'description' => $description
    ];

    if (isset($_POST['project_id']) && is_numeric($_POST['project_id'])) {
        // Edit existing project
        $id = $_POST['project_id'];
        $projects[$id] = json_encode($newProject);
    } else {
        // Add new project and ensure a newline is appended
        $projects[] = json_encode($newProject) . PHP_EOL;
    }

    // Save the projects back to the file
    file_put_contents($projectsFile, implode(PHP_EOL, $projects));
    header("Location: admin.php?section=projects");
    exit;
}


// Handle delete request for projects
if (isset($_GET['delete_project'])) {
    $idToDelete = $_GET['delete_project'];
    unset($projects[$idToDelete]);
    file_put_contents($projectsFile, implode(PHP_EOL, $projects));
    header("Location: admin.php?section=projects");
    exit;
}

// Handle content editing
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['content'])) {
    file_put_contents($contentFile, $_POST['content']);
    header("Location: admin.php?section=content");
    exit;
}

// Determine which section to display (projects, users, or content)
$section = isset($_GET['section']) ? $_GET['section'] : 'projects';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Admin - Manage Projects, Users & Content</title>
    <link href="css/styles.css" rel="stylesheet" />
</head>
<body>
    <h1>Admin Dashboard</h1>
    <nav>
        <ul>
            <li><a href="admin.php?section=projects">Manage Projects</a></li>
            <li><a href="admin.php?section=users">Manage Users</a></li>
            <li><a href="admin.php?section=content">Edit Content</a></li>
        </ul>
    </nav>

    <!-- Manage Projects Section -->
    <?php if ($section === 'projects'): ?>
    <h2>Manage Projects</h2>
    <form action="admin.php?section=projects" method="POST">
        <input type="hidden" name="project_id" value="<?= isset($_GET['edit_project']) ? $_GET['edit_project'] : ''; ?>">
        <label for="title">Project Title:</label>
        <input type="text" name="title" value="<?= isset($_GET['edit_project']) ? json_decode($projects[$_GET['edit_project']], true)['title'] : ''; ?>" required><br>
        <label for="description">Project Description:</label>
        <textarea name="description" required><?= isset($_GET['edit_project']) ? json_decode($projects[$_GET['edit_project']], true)['description'] : ''; ?></textarea><br>
        <button type="submit">Save Project</button>
    </form>

    <h3>Current Projects</h3>
    <ul>
        <?php foreach ($projects as $index => $projectData): ?>
        <?php $project = json_decode($projectData, true); ?>
        <li>
            <strong><?= htmlspecialchars($project['title']) ?></strong><br>
            <?= htmlspecialchars($project['description']) ?><br>
            <a href="admin.php?section=projects&edit_project=<?= $index ?>">Edit</a>
            <a href="admin.php?section=projects&delete_project=<?= $index ?>">Delete</a>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>

    <!-- Manage Users Section -->
    <?php if ($section === 'users'): ?>
    <h2>Manage Users</h2>
    <form action="admin.php?section=users" method="POST">
        <input type="hidden" name="id" value="<?= isset($_GET['edit_user']) ? $_GET['edit_user'] : ''; ?>">
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" value="<?= isset($_GET['edit_user']) ? json_decode($users[$_GET['edit_user']], true)['first_name'] : ''; ?>" required><br>
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" value="<?= isset($_GET['edit_user']) ? json_decode($users[$_GET['edit_user']], true)['last_name'] : ''; ?>" required><br>
        <label for="username">Username:</label>
        <input type="text" name="username" value="<?= isset($_GET['edit_user']) ? json_decode($users[$_GET['edit_user']], true)['username'] : ''; ?>" required><br>
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?= isset($_GET['edit_user']) ? json_decode($users[$_GET['edit_user']], true)['email'] : ''; ?>" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" value="<?= isset($_GET['edit_user']) ? json_decode($users[$_GET['edit_user']], true)['password'] : ''; ?>" required><br>
        <button type="submit">Save User</button>
    </form>

    <h3>Current Users</h3>
    <ul>
        <?php foreach ($users as $index => $userData): ?>
        <?php $user = json_decode($userData, true); ?>
        <li>
            <?= htmlspecialchars($user['first_name']) ?> <?= htmlspecialchars($user['last_name']) ?> (<?= htmlspecialchars($user['username']) ?> - <?= htmlspecialchars($user['email']) ?>)
            <a href="admin.php?section=users&edit_user=<?= $index ?>">Edit</a>
            <a href="admin.php?section=users&delete_user=<?= $index ?>">Delete</a>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>

    <!-- Edit Content Section -->
    <?php if ($section === 'content'): ?>
    <h2>Edit Content</h2>
    <form action="admin.php?section=content" method="POST">
        <label for="content">Edit Site Content:</label><br>
        <textarea name="content" id="content" rows="10" cols="50"><?= htmlspecialchars($content); ?></textarea><br>
        <button type="submit">Save Content</button>
    </form>
    <?php endif; ?>
</body>
</html>
