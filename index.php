<?php
// index.php

// simple dummy data (normally this comes from db)
$manga_title = "My First Manga";

// total chapters
$chapters = [
    1 => "Chapter 1 - Beginning",
    2 => "Chapter 2 - Mystery Guy",
    3 => "Chapter 3 - Big Fight"
];

// assume har chapter me 3 pages
$pages_per_chapter = 3;

// get current chapter from URL (default 1)
if (isset($_GET['chapter'])) {
    $current_chapter = (int) $_GET['chapter'];
} else {
    $current_chapter = 1;
}

// validate chapter
if (!isset($chapters[$current_chapter])) {
    $current_chapter = 1;
}

// get current page from URL (default 1)
if (isset($_GET['page'])) {
    $current_page = (int) $_GET['page'];
} else {
    $current_page = 1;
}

// validate page number
if ($current_page < 1) {
    $current_page = 1;
}
if ($current_page > $pages_per_chapter) {
    $current_page = $pages_per_chapter;
}

// helper function to build URL
function build_url($chapter, $page)
{
    return "index.php?chapter=" . $chapter . "&page=" . $page;
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
                        <a href="<?php echo build_url($num, 1); ?>">
                            <?php echo $name; ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>

        <!-- Main reading area -->
        <div class="reader">
            <h2>
                <?php echo $chapters[$current_chapter]; ?>
                - Page <?php echo $current_page; ?> / <?php echo $pages_per_chapter; ?>
            </h2>

            <div class="page-area">
                <!-- Abhi bhi placeholder image hi use kar rahe -->
                <img src="https://via.placeholder.com/600x800?text=Chapter+<?php echo $current_chapter; ?>+Page+<?php echo $current_page; ?>" alt="Manga Page">
            </div>

            <div class="navigation">

                <!-- Previous button -->
                <?php
                // previous page in same chapter
                if ($current_page > 1) {
                    $prev_chapter = $current_chapter;
                    $prev_page = $current_page - 1;
                } else {
                    // agar first page hai aur pehle chapter hai, to koi previous nahi
                    if ($current_chapter > 1) {
                        $prev_chapter = $current_chapter - 1;
                        $prev_page = $pages_per_chapter;
                    } else {
                        $prev_chapter = null;
                        $prev_page = null;
                    }
                }

                if ($prev_chapter !== null) {
                    ?>
                    <a class="btn" href="<?php echo build_url($prev_chapter, $prev_page); ?>">Previous</a>
                <?php } ?>

                <!-- Next button -->
                <?php
                // next page in same chapter
                if ($current_page < $pages_per_chapter) {
                    $next_chapter = $current_chapter;
                    $next_page = $current_page + 1;
                } else {
                    // last page of chapter → next chapter ka first page
                    if ($current_chapter < count($chapters)) {
                        $next_chapter = $current_chapter + 1;
                        $next_page = 1;
                    } else {
                        $next_chapter = null;
                        $next_page = null;
                    }
                }

                if ($next_chapter !== null) {
                    ?>
                    <a class="btn" href="<?php echo build_url($next_chapter, $next_page); ?>">Next</a>
                <?php } ?>

            </div>
        </div>

    </div>

</div>

<script src="script.js"></script>
</body>
</html>
