<?php
include 'db.php';

function getProjects($conn) {
    $sql = "SELECT project_image, title, description FROM projects_page ORDER BY id";
    $result = $conn->query($sql);

    if (!$result || $result->num_rows === 0) {
        return [];
    }

    return $result->fetch_all(MYSQLI_ASSOC);
}

$projects = getProjects($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects</title>
    <link rel="icon" type="image/svg+xml" href="assets/images/logo-icon.svg">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <header>
        <div class="container">
            <nav class="navbar navbar-expand-lg" data-bs-theme="dark">
                <div class="container">
                    <a class="navbar-brand border-bottom border-secondary" href="index.php"><img
                            src="assets/images/logo-icon.svg" alt="Logo"></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                        <div class="navbar-nav fs-5 gap-lg-4 gap-sm-0 ms-auto border-bottom border-secondary">
                            <a class="nav-link" href="index.php">About</a>
                            <a class="nav-link" href="skills.php">Skills</a>
                            <a class="nav-link active" aria-current="page" href="projects.php">Projects</a>
                            <a class="nav-link" href="contact.php">Contact</a>
                            <a class="nav-link" href="manage.php">Manage</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <main class="d-flex flex-column">
        <section class="container-fluid section my-4">
            <h2 class="text-center text-light mb-4 hero-heading"><span>Projects</span></h2>
            <div class="container panel py-4 px-3 px-md-4 px-lg-5 mt-5">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                    <?php foreach ($projects as $project): ?>
                        <?php
                        $rawImage = trim((string)$project['project_image']);
                        $imageSrc = $rawImage;
                        ?>
                        <div class="col">
                            <div class="card skill-card h-100 border-0 overflow-hidden">
                                <?php if ($rawImage !== ''): ?>
                                    <img src="data:image/png;base64,<?php echo base64_encode($rawImage); ?>" alt="<?php echo htmlspecialchars($project['title']); ?>" class="card-img-top project-thumb">
                                <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title text-primary mb-2"><?php echo htmlspecialchars($project['title']); ?></h5>
                                    <p class="card-text text-light mb-0"><?php echo htmlspecialchars($project['description']); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if (count($projects) === 0): ?>
                    <p class="text-light mb-0">No projects displayed.</p>
                <?php endif; ?>
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
