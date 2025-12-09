<?php
// index.php

$manga_title = "My First Manga";
$chapters = [
    1 => "Chapter 1 - Beginning",
    2 => "Chapter 2 - Mystery Guy",
    3 => "Chapter 3 - Big Fight"
];

$current_chapter = isset($_GET['chapter']) ? (int)$_GET['chapter'] : 1;
if (!isset($chapters[$current_chapter])) {
    $current_chapter = 1; // fallback
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $manga_title; ?> - Simple Manga Reader</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<div class="container">

    <h1><?php echo $manga_title; ?></h1>

    <div class="layout">

        <!-- Sidebar for chapter list -->
        <div class="sidebar">
            <h2>Chapters</h2>
            <ul>
                <?php foreach ($chapters as $num => $name) { ?>
                    <li>
                        <a href="index.php?chapter=<?php echo $num; ?>">
                            <?php echo $name; ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>

        <!-- Main reading area -->
        <div class="reader">
            <h2><?php echo $chapters[$current_chapter]; ?></h2>

            <div class="page-area">
                <img src="https://via.placeholder.com/600x800?text=Manga+Page+<?php echo $current_chapter; ?>" alt="Manga Page">
            </div>

            <div class="navigation">
                <?php if ($current_chapter > 1) { ?>
                    <a class="btn" href="index.php?chapter=<?php echo $current_chapter - 1; ?>">Previous</a>
                <?php } ?>

                <?php if ($current_chapter < count($chapters)) { ?>
                    <a class="btn" href="index.php?chapter=<?php echo $current_chapter + 1; ?>">Next</a>
                <?php } ?>
            </div>
        </div>

    </div>

</div>

<script src="script.js"></script>
</body>
</html>
