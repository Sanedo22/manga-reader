<?php
// index.php

// session for bookmark
session_start();

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

// SAVE BOOKMARK (if user clicked bookmark button)
if (isset($_GET['bookmark']) && $_GET['bookmark'] == 1) {
    $_SESSION['bookmark'] = [
        'chapter' => $current_chapter,
        'page' => $current_page
    ];
}

// helper function to build URL
function build_url($chapter, $page)
{
    return "index.php?chapter=" . $chapter . "&page=" . $page;
}

// image path banayenge chapter/page ke hisaab se
$image_file = "pages/chapter" . $current_chapter . "-page" . $current_page . ".jpg";

// check kar lein file exist karti hai ya nahi
if (!file_exists($image_file)) {
    // agar nahi hai to ek fallback image ya placeholder text use kar sakte hain
    $image_file = "https://via.placeholder.com/600x800?text=Missing+Image";
    $is_remote_image = true;
} else {
    $is_remote_image = false;
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

            <!-- Bookmark section (if available) -->
            <?php if (isset($_SESSION['bookmark'])) {
                $bm = $_SESSION['bookmark'];
            ?>
                <h2>Bookmark</h2>
                <p>
                    <a class="btn" href="<?php echo build_url($bm['chapter'], $bm['page']); ?>">
                        Go to Bookmark (Ch <?php echo $bm['chapter']; ?>, Pg <?php echo $bm['page']; ?>)
                    </a>
                </p>
            <?php } ?>
        </div>

        <!-- Main reading area -->
        <div class="reader">
            <h2>
                <?php echo $chapters[$current_chapter]; ?>
                - Page <?php echo $current_page; ?> / <?php echo $pages_per_chapter; ?>
            </h2>

            <div class="page-area">
                <?php if ($is_remote_image) { ?>
                    <img src="<?php echo $image_file; ?>" alt="Manga Page (placeholder)">
                <?php } else { ?>
                    <img src="<?php echo $image_file; ?>" alt="Manga Page">
                <?php } ?>
            </div>

            <div class="navigation">

                <?php
                // Previous logic
                if ($current_page > 1) {
                    $prev_chapter = $current_chapter;
                    $prev_page = $current_page - 1;
                } else {
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

                <?php
                // Next logic
                if ($current_page < $pages_per_chapter) {
                    $next_chapter = $current_chapter;
                    $next_page = $current_page + 1;
                } else {
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

                <!-- Bookmark this page button -->
                <a class="btn" href="<?php echo build_url($current_chapter, $current_page); ?>&bookmark=1">
                    Bookmark This Page
                </a>

            </div>
        </div>

    </div>

</div>

<script src="script.js"></script>
</body>
</html>
