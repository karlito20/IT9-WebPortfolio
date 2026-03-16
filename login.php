<?php 
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $err = '';
    if (isset($_POST['login-btn'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM user_credentials WHERE username='$username'";
        $result = $conn->query($sql);

        if (password_verify($password, $result->fetch_assoc()['password_hashed'])) {
            $_SESSION['logged_in'] = true;
            header("Location: manage.php");
            exit();
        } else {
            $err = "Invalid username or password.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="image/svg+xml" href="assets/images/logo-icon.svg">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <main class="d-flex flex-column justify-content-center align-items-center" style="min-height:100vh;">
        <div class="col-12 col-md-8 col-lg-5 px-3">
            <div class="card skill-card border-0">
                <div class="card-body p-4 p-md-5">
                    <h2 class="text-primary mb-3">Sign in to continue.</h2>
                    <form method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label text-light">Username</label>
                            <input type="text" class="form-control bg-dark text-light border-secondary" name="username"required >
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label text-light">Password</label>
                            <input type="password" class="form-control bg-dark text-light border-secondary" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mb-2" name="login-btn">Continue</button>
                        <a href="index.php" class="btn btn-outline-secondary w-100">Back to Home</a>
                    </form>
                    <?php if ($err): ?>
                        <div class="alert alert-danger mt-3" role="alert">
                            <?php echo "<code>$err</code>"; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
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
