<?php
session_start();
include 'db.php';

if (!$_SESSION['logged_in']) {
    header("Location: login.php");
    exit();
}

$aboutResult = $conn->query("SELECT * FROM about_page");
$about = $aboutResult ? $aboutResult->fetch_assoc() : null;

$skillsResult = $conn->query("SELECT * FROM skills_page ORDER BY id");
$skills = $skillsResult ? $skillsResult->fetch_all(MYSQLI_ASSOC) : [];

$projectsResult = $conn->query("SELECT * FROM projects_page ORDER BY id");
$projects = $projectsResult ? $projectsResult->fetch_all(MYSQLI_ASSOC) : [];

$contactResult = $conn->query("SELECT * FROM contact_page ORDER BY id LIMIT 1");
$contact = $contactResult ? $contactResult->fetch_assoc() : null;



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage</title>
    <link rel="icon" type="image/svg+xml" href="assets/images/logo-icon.svg">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header>
    <div class="container">
        <nav class="navbar navbar-expand-lg" data-bs-theme="dark">
            <div class="container">
                <a class="navbar-brand border-bottom border-secondary" href="index.php">
                    <img src="assets/images/logo-icon.svg" alt="Logo">
                </a>
                <div class="navbar-nav fs-5 gap-lg-4 ms-auto border-bottom border-secondary">
                    <a class="nav-link text-light" href="index.php">← Back to Site</a>
                    <a class="nav-link" href="logout.php">Logout</a>
                </div>
            </div>
        </nav>
    </div>
</header>

<main class="d-flex flex-column">
    <section class="container-fluid section my-4">
        <div class="container panel py-4 px-3 px-md-4 px-lg-5 mt-5">
            <h2 class="text-primary mb-1">Manage Content</h2>
            <p class="text-light mb-0">Change contents of the portfolion here. Make sure to review changes before saving and log out after you are done.</p>
        </div>
    </section>

    <section class="container-fluid section my-4">
        <div class="container panel py-4 px-3 px-md-4 px-lg-5">
            <h3 class="text-primary mb-4">About</h3>

            <div class="card skill-card border-0 p-4 mb-4">
                <h5 class="text-light mb-3">Overview</h5>
                <?php
                if (isset($_POST['save-about'])) {
                    $name = $conn->real_escape_string($_POST['name']);
                    $description = $conn->real_escape_string($_POST['description']);

                    $sql = "UPDATE about_page SET name='$name', description='$description' WHERE id={$about['id']}";

                    if ($conn->query($sql) === TRUE) {
                        echo '<script>alert("Overview updated.");</script>';
                        header("Location: manage.php");
                    } else {
                        echo '<div class="alert alert-danger">Error saving about section: ' . $conn->error . '</div>';
                    }
                }
                ?>
                <form method="post">
                    <div class="row g-3">
                        <div class="col-12 col-md-4">
                            <label for="about-name" class="form-label text-light">Name</label>
                            <input type="text" name="name" class="form-control bg-dark text-light border-secondary" value="<?= htmlspecialchars($about['name'] ?? '') ?>" required>
                        </div>
                        <div class="col-12 col-md-8">
                            <label for="about-description" class="form-label text-light">Description</label>
                            <textarea name="description" rows="4" class="form-control bg-dark text-light border-secondary"><?= htmlspecialchars($about['description'] ?? '') ?></textarea>
                        </div>
                        <div class="col-12 d-flex flex-row-reverse gap-2">
                            <button type="submit" class="btn btn-primary" name="save-about">Save</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </section>

    <section class="container-fluid section my-4">
        <div class="container panel py-4 px-3 px-md-4 px-lg-5">
            <h3 class="text-primary mb-4">Skills</h3>

            <div class="card skill-card border-0 p-4 mb-4">
                <h5 class="text-light mb-3">Details</h5>
                <?php 
                if (isset($_POST['save-skill'])) {
                    $skill = $conn->real_escape_string($_POST['skill']);
                    $description = $conn->real_escape_string($_POST['description']);

                    if (!empty($_POST['skill-edit-id'])) {
                        $editId = (int)$_POST['skill-edit-id'];
                        $sql = "UPDATE skills_page SET skill='$skill', description='$description' WHERE id=$editId";
                    } else {
                        $sql = "INSERT INTO skills_page (skill, description) VALUES ('$skill', '$description')";
                    }

                    if ($conn->query($sql) === TRUE) {
                        echo '<script>alert("Changes saved.");</script>';
                        header("Location: manage.php");
                    } else {
                        echo '<div class="alert alert-danger">Error adding skill: ' . $conn->error . '</div>';
                    }
                }
                ?>
                <form method="post">
                    <input type="hidden" name="skill-edit-id" id="skill-edit-id" value="">
                    <div class="row g-3">
                        <div class="col-12 col-md-4">
                            <label for="skill-name" class="form-label text-light">Skill</label>
                            <input type="text" id="skill-name" name="skill" class="form-control bg-dark text-light border-secondary" required>
                        </div>
                        <div class="col-12 col-md-8">
                            <label for="skill-description" class="form-label text-light">Description</label>
                            <input type="text" id="skill-description" name="description" class="form-control bg-dark text-light border-secondary">
                        </div>
                        <div class="col-12 d-flex flex-row-reverse gap-2">
                            <button type="submit" class="btn btn-primary" name="save-skill">Save</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card skill-card border-0 p-4">
                <h5 class="text-light mb-3">Current List</h5>
                <?php if ($skills): ?>
                    <div class="table-responsive">
                        <table class="table table-dark table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Skill</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($skills as $skill): ?>
                                    <tr>
                                        <td class="text-light"><?= htmlspecialchars($skill['skill']) ?></td>
                                        <td class="text-light"><?= htmlspecialchars($skill['description']) ?></td>
                                        <td>
                                            <?php
                                            if (isset($_POST['delete-skill'])) {
                                                $deleteId = $_POST['skill-id'];
                                                $deleteSql = "DELETE FROM skills_page WHERE id=$deleteId";
                                                if ($conn->query($deleteSql) === TRUE) {
                                                    echo '<script>alert("Changes saved.");</script>';
                                                    header("Location: manage.php");
                                                } else {
                                                    echo '<div class="alert alert-danger">Error deleting skill: ' . $conn->error . '</div>';
                                                }
                                            }
                                            ?>
                                            <form method="post">
                                                <input type="hidden" name="skill-id" value="<?= $skill['id'] ?>">
                                                <button type="button" class="btn btn-sm btn-outline-primary me-1 edit-skill-btn"
                                                    data-id="<?= $skill['id'] ?>"
                                                    data-skill="<?= htmlspecialchars($skill['skill'], ENT_QUOTES) ?>"
                                                    data-description="<?= htmlspecialchars($skill['description'], ENT_QUOTES) ?>">Edit</button>
                                                <button type="submit" class="btn btn-sm btn-outline-danger" name="delete-skill">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-light mb-0">No skills found.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="container-fluid section my-4">
        <div class="container panel py-4 px-3 px-md-4 px-lg-5">
            <h3 class="text-primary mb-4">Projects</h3>

            <div class="card skill-card border-0 p-4 mb-4">
                <h5 class="text-light mb-3">Details</h5>
                <?php 
                if (isset($_POST['save-project'])) {
                    $title = $conn->real_escape_string($_POST['title']);
                    $description = $conn->real_escape_string($_POST['description']);
                    $imageData = isset($_FILES['project_image']) && !empty($_FILES['project_image']['tmp_name'])
                        ? addslashes(file_get_contents($_FILES['project_image']['tmp_name']))
                        : null;

                    if (!empty($_POST['project-edit-id'])) {
                        $editId = (int)$_POST['project-edit-id'];
                        if ($imageData !== null) {
                            $sql = "UPDATE projects_page SET title='$title', description='$description', project_image='$imageData' WHERE id=$editId";
                        } else {
                            $sql = "UPDATE projects_page SET title='$title', description='$description' WHERE id=$editId";
                        }
                    } else {
                        $sql = "INSERT INTO projects_page (title, description, project_image) VALUES ('$title', '$description', '$imageData')";
                    }

                    if ($conn->query($sql) === TRUE) {
                        header("Location: manage.php");
                    } else {
                        echo '<div class="alert alert-danger">Error adding project: ' . $conn->error . '</div>';
                    }
                }
                ?>
                <form method="post" enctype="multipart/form-data">
                    <input type="hidden" name="project-edit-id" id="project-edit-id" value="">
                    <div class="row g-3">
                        <div class="col-12 col-md-4">
                            <label for="project-title" class="form-label text-light">Title</label>
                            <input type="text" id="project-title" name="title" class="form-control bg-dark text-light border-secondary" required>
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="project-description" class="form-label text-light">Description</label>
                            <input type="text" id="project-description" name="description" class="form-control bg-dark text-light border-secondary">
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="project-image" class="form-label text-light">Project Image</label>
                            <input type="file" id="project-image" name="project_image" class="form-control bg-dark text-light border-secondary">
                        </div>
                        <div class="col-12 d-flex flex-row-reverse gap-2">
                            <button type="submit" class="btn btn-primary" name="save-project">Save</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card skill-card border-0 p-4">
                <h5 class="text-light mb-3">Current List</h5>
                <?php if ($projects): ?>
                    <div class="table-responsive">
                        <table class="table table-dark table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($projects as $project): ?>
                                    <tr>
                                        <td class="text-light"><img src="data:image/png;base64,<?=base64_encode($project['project_image'])?>" alt="<?= htmlspecialchars($project['title']) ?>"></td>
                                        <td class="text-light"><?= htmlspecialchars($project['title']) ?></td>
                                        <td class="text-light"><?= htmlspecialchars($project['description']) ?></td>
                                        <td>
                                            <?php
                                            if (isset($_POST['delete-project'])) {
                                                $deleteId = $_POST['project-id'];
                                                $deleteSql = "DELETE FROM projects_page WHERE id=$deleteId";
                                                if ($conn->query($deleteSql) === TRUE) {
                                                    header("Location: manage.php");
                                                } else {
                                                    echo '<div class="alert alert-danger">Error deleting project: ' . $conn->error . '</div>';
                                                }
                                            }
                                            ?>
                                            <form method="post">
                                                <input type="hidden" name="project-id" value="<?= $project['id'] ?>">
                                                <button type="button" class="btn btn-sm btn-outline-primary me-1 edit-project-btn"
                                                    data-id="<?= $project['id'] ?>"
                                                    data-title="<?= htmlspecialchars($project['title'], ENT_QUOTES) ?>"
                                                    data-description="<?= htmlspecialchars($project['description'], ENT_QUOTES) ?>">Edit</button>
                                                <button type="submit" class="btn btn-sm btn-outline-danger" name="delete-project">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-light mb-0">No projects found.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="container-fluid section my-4">
        <div class="container panel py-4 px-3 px-md-4 px-lg-5">
            <h3 class="text-primary mb-4">Contact Section</h3>
            <div class="card skill-card border-0 p-4 mb-4">
                <h5 class="text-light mb-3">Input Form</h5>
                <?php 
                if (isset($_POST['save-contact'])) {
                    $email = $conn->real_escape_string($_POST['email']);
                    $email_personal = $conn->real_escape_string($_POST['email_personal']);
                    $phone = $conn->real_escape_string($_POST['phone']);
                    $github = $conn->real_escape_string($_POST['github']);

                    $sql = "UPDATE contact_page SET email='$email', email_personal='$email_personal', phone='$phone', github='$github' WHERE id={$contact['id']}";

                    if ($conn->query($sql) === TRUE) {
                        header("Location: manage.php");
                    } else {
                        echo '<div class="alert alert-danger">Error saving contact information: ' . $conn->error . '</div>';
                    }
                }
                ?>
                <form method="post">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label for="contact-email" class="form-label text-light">School Email</label>
                            <input type="email" id="contact-email" name="email" class="form-control bg-dark text-light border-secondary" value="<?= htmlspecialchars($contact['email'] ?? '') ?>">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="contact-email-personal" class="form-label text-light">Personal Email</label>
                            <input type="email" id="contact-email-personal" name="email_personal" class="form-control bg-dark text-light border-secondary" value="<?= htmlspecialchars($contact['email_personal'] ?? '') ?>">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="contact-phone" class="form-label text-light">Phone</label>
                            <input type="text" id="contact-phone" name="phone" class="form-control bg-dark text-light border-secondary" value="<?= htmlspecialchars($contact['phone'] ?? '') ?>">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="contact-github" class="form-label text-light">GitHub</label>
                            <input type="text" id="contact-github" name="github" class="form-control bg-dark text-light border-secondary" value="<?= htmlspecialchars($contact['github'] ?? '') ?>">
                        </div>
                        <div class="col-12 d-flex flex-row-reverse gap-2">
                            <button type="submit" class="btn btn-primary" name="save-contact">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section class="container-fluid section my-4">
        <div class="container panel py-4 px-3 px-md-4 px-lg-5">
            <h3 class="text-primary mb-4">User Credentials</h3>
            <div class="card skill-card border-0 p-4 mb-4">
                <?php
                if (isset($_POST['password-save'])) {
                    $newPassword = $_POST['new_password'];
                    $newPasswordConfirm = $_POST['new_password_confirm'];

                    if ($newPassword !== $newPasswordConfirm) {
                        echo '<code class="alert alert-danger">Passwords do not match.</code>';
                    } else {
                        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                        $username = $_SESSION['username'];
                        $sql = "UPDATE user_credentials SET password_hashed='$hashedPassword' WHERE username='$username'";

                        if ($conn->query($sql) === TRUE) {
                            echo '<script>alert("Password updated successfully.");</script>';
                            header("Location: manage.php");
                        } else {
                            echo '<code class="alert alert-danger">Error updating password: ' . $conn->error . '</code>';
                        }
                    }
                }
                ?>
                <form method="post">
                    <div class="row g-3">
                        <div class="col-lg-4 col-sm-12">
                            <label for="username" class="form-label text-light">Username</label>
                            <input type="text" name="username" class="form-control bg-dark text-light border-secondary" value="<?= htmlspecialchars($_SESSION['username']) ?>" disabled>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <label for="new-password" class="form-label text-light">New Password</label>
                            <input type="password" name="new_password" class="form-control bg-dark text-light border-secondary">
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <label for="new-password-confirm" class="form-label text-light">Confirm New Password</label>
                            <input type="password" name="new_password_confirm" class="form-control bg-dark text-light border-secondary">
                        </div>
                        <div class="col-12 d-flex flex-row-reverse gap-2 mt-3">
                            <button type="submit" class="btn btn-primary" name="password-save">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>

<footer>
    <section class="container-fluid section stretch-section mt-5">
        <code class="text-light">@2026</code>
            <code class="text-light">Made with PHP, MySQL, and Bootstrap</code>
    </section>
</footer>

<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>

