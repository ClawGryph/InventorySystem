// loadDashboardOnStart.js

window.addEventListener('DOMContentLoaded', function () {
    const mainContent = document.getElementById('mainContent');
    const dashboardLink = document.querySelector('a[data-content="dashboard.php"]');

    // Only trigger auto-load if #mainContent is empty
    if (mainContent && dashboardLink && mainContent.innerHTML.trim() === "") {
        dashboardLink.click();
    }
});
