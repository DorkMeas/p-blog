<?php
require_once __DIR__ . '/../database.php';
$categories = getCategories($pdo);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>.MEAS Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <script>
        const savedTheme = localStorage.getItem("theme");
        if (savedTheme) {
            document.documentElement.setAttribute(
                "data-bs-theme",
                savedTheme
            );
        }
    </script>
</head>

<body class="d-flex flex-column min-vh-100 bg-body">

    <nav class="navbar navbar-expand-lg bg-body border-bottom">
        <div class="container">

            <a class="navbar-brand" href="index.php">.MEAS</a>

            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="posts.php">All Posts</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown">
                            Categories
                        </a>
                        <ul class="dropdown-menu">
                            <?php foreach ($categories as $category): ?>
                                <li>
                                    <a class="dropdown-item"
                                        href="index.php?category=<?= urlencode($category) ?>">
                                        <?= htmlspecialchars($category) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                </ul>
            </div>

            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-outline-secondary"
                    onclick="toggleDarkMode()">
                    <i id="themeIcon" class="bi bi-moon-stars-fill"></i>
                </button>
                <a href="admin.php" class="btn btn-success">
                    Admin Panel
                </a>
            </div>

        </div>
    </nav>

    <main class="flex-grow-1">

        <script>
            function toggleDarkMode() {
                const html = document.documentElement;
                const icon = document.getElementById("themeIcon");
                const theme = html.getAttribute("data-bs-theme");

                if (theme === "dark") {
                    html.setAttribute("data-bs-theme", "light");
                    icon.className = "bi bi-moon-stars-fill";
                    localStorage.setItem("theme", "light");

                } else {
                    html.setAttribute("data-bs-theme", "dark");
                    icon.className = "bi bi-sun-fill";
                    localStorage.setItem("theme", "dark");

                }
            }
        </script>