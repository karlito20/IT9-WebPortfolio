<?php
include 'db.php';
function getAboutInfo($conn) {
    $sql = "SELECT * FROM about_page";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello</title>
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
                            <a class="nav-link active" aria-current="page" href="index.php">About</a>
                            <a class="nav-link" href="skills.php">Skills</a>
                            <a class="nav-link" href="projects.php">Projects</a>
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
            <div class="container panel py-4 px-sm-0 px-md-3 px-lg-5 mt-5">
                <div class="row">
                    <div class="col-12 col-md-5">
                        <div class="container p-5">
                            <img src="assets/images/profile-picture.png" alt="Profile Picture"
                                class="img-fluid rounded-circle border border-secondary">
                        </div>
                    </div>
                    <div class="col-12 col-md-7">
                        <div class="container d-flex flex-column justify-content-center h-100 text-center text-md-end text-light">
                            <h1 class="hero-heading">Hello, I'm <span class="text-primary fw-bold"><?php $aboutInfo = getAboutInfo($conn); echo $aboutInfo['name'];?></span></h1>
                            <p class="lead" style="text-align: justify;"><?php echo $aboutInfo['description'];?></p>
                            <div class="container d-flex justify-content-center justify-content-md-end p-0">
                                <a href="contact.php"><button class="btn btn-primary btn-lg text-light">Contact Info</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="container-fluid section stretch-section my-5 px-5">
            <div class="d-flex flex-wrap justify-content-center align-items-center gap-4 py-4">
                <img src="assets/images/java-icon.png" alt="Java" class="skill-icon">
                <img src="assets/images/python-icon.png" alt="Python" class="skill-icon">
                <img src="assets/images/bootstrap-icon.png" alt="Bootstrap" class="skill-icon">
                <img src="assets/images/javascript-icon.png" alt="JavaScript" class="skill-icon">
                <img src="assets/images/arch-icon.png" alt="Arch Linux" class="skill-icon">
                <img src="assets/images/html-icon.png" alt="HTML" class="skill-icon">
                <img src="assets/images/git-icon.png" alt="Git" class="skill-icon">
            </div>
        </section>
    </main>

    <footer>
        <section class="container-fluid section stretch-section d-flex  justify-content-between align-items-center mt-5 gap-2">
            <code class="text-light">@2026</code>
            <code class="text-light">Made with PHP, MySQL, and Bootstrap</code>
        </section>
    </footer>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>