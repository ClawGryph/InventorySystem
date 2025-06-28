<?php
    session_start();
    $fullname = isset($_SESSION["fullname"]) ? $_SESSION["fullname"] : "User";
?>

<div class="section">
    <div class="box-area">
        <div class="header header-bg">
            <h2>Dashboard</h2>
            <a href="../index.php" class="btn-header">Logout</a>
        </div>
        <div class="table-container">
            <h2>Welcome back, <?php echo htmlspecialchars($fullname); ?>!</h2>
        </div>
    </div>
</div>