<?php 
include 'db.php';
function getContactInfo($conn) {
    $sql = "SELECT * FROM contact_page";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}
$contactInfo = getContactInfo($conn); 
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="icon" type="image/svg+xml" href="assets/images/logo-icon.svg">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
                            <a class="nav-link" href="projects.php">Projects</a>
                            <a class="nav-link active" aria-current="page" href="contact.php">Contact</a>
                            <a class="nav-link" href="manage.php">Manage</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <main class="d-flex flex-column">
        <section class="container-fluid section my-4">
            <h2 class="text-center text-light mb-4 hero-heading"><span>Contact Information</span></h2>
            <div class="container panel py-5 px-4 px-md-5 mt-5">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                    <div class="col">
                        <div class="card skill-card h-100 border-0">
                            <div class="card-body text-light">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <i class="bi bi-envelope text-primary fs-4"></i>
                                    <h5 class="card-title mb-0 text-primary">Email</h5>
                                </div>
                                <p class="card-text text-light mb-1 text-break"><?php echo $contactInfo ? $contactInfo['email'] : 'N/A';?></p>
                                <p class="card-text text-light mb-0 text-break"><?php echo $contactInfo ? $contactInfo['email_personal'] : 'N/A';?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card skill-card h-100 border-0">
                            <div class="card-body text-light">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <i class="bi bi-telephone text-primary fs-4"></i>
                                    <h5 class="card-title mb-0 text-primary">Phone</h5>
                                </div>
                                <p class="card-text text-light mb-0 text-break"><?php echo $contactInfo ? $contactInfo['phone'] : 'N/A';?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card skill-card h-100 border-0">
                            <div class="card-body text-light">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <i class="bi bi-github text-primary fs-4"></i>
                                    <h5 class="card-title mb-0 text-primary">GitHub</h5>
                                </div>
                                <p class="card-text text-light mb-0 text-break"><?php echo $contactInfo ? $contactInfo['github'] : 'N/A';?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-4 text-secondary small">Contact details are updated as of March 2026.</div>
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
