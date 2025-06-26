<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
    <link rel="stylesheet" href="./cssFiles/normalize.css">
    <link rel="stylesheet" href="./cssFiles/styles.css">
</head>
<body>
    <main class="container">
        <div class="login-container">
            <span style="--clr:#001845;"></span>
            <span style="--clr:#3d5a80;"></span>
            <span style="--clr:#31572c;"></span>
            <div class="form-container">
                <h2>Sign in</h2>
                <?php if (isset($_GET['error'])): ?>
                    <div class="error-message">Invalid username or password.</div>
                <?php endif; ?>
                <form action="signinHandler.php" method="POST">
                    <div class="input-container">
                        <input type="text" id="username" name="username" placeholder="Username" required>
                    </div>
                    <div class="input-container">
                        <input type="password" id="password" name="password" placeholder="Password" required>
                    </div>

                    <button type="submit" class="login-btn">Sign in</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>