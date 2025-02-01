<?php
require "db.php";

$DB_FILE_PATH = __DIR__ . "/../data/database.db";

// Start PHP Session
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        "cookie_secure" => true,
        "cookie_httponly" => true,
        "use_strict_mode" => true,
    ]);
}

// Database Configuration
$db = new DB($DB_FILE_PATH);

// Create default users if no users exist
if ($db->getUserCount() === 0) {
    $db->addUser([ "username" => "peter", "password" => password_hash("peterlim", PASSWORD_DEFAULT), "name" => "Peter Lim", "dob" => "2008-08-13", "email" => "peter.lim@example.com" ]);
    $db->addUser([ "username" => "mary", "password" => password_hash("marytan", PASSWORD_DEFAULT), "name" => "Mary Tan", "dob" => "1977-12-08", "email" => "mary.tan@example.com" ]);
    $db->addUser([ "username" => "david", "password" => password_hash("davidlee", PASSWORD_DEFAULT), "name" => "David Lee", "dob" => "1999-08-26", "email" => "david.lee@example.com" ]);
}

// Create default movies if no movies exist
if (count($db->getMovies()) === 0) {
    $db->addMovie([ "title" => "John Wick: Chapter 4", "genre" => "Action/Thriller", "running_time" => "170", "language" => "English (Sub: Chinese, Malay)", "picture" => "JohnWick.png", "director" => "Chad Stahelski", "cast" => "Keanu Reeves, Donnie Yen, Bill Skarsgard, Laurence Fishburne, Hiroyuki Sanada, Lance Reddick, Scott Adkins", "synopsis" => "John Wick (Keanu Reeves) uncovers a path to defeating The High Table. But before he can earn his freedom, Wick must face off against a new enemy with powerful alliances across the globe and forces that turn old friends into foes." ]);
    $db->addMovie([ "title" => "My Puppy", "genre" => "Drama", "running_time" => "113", "language" => "Korean (Sub: English, Chinese)", "picture" => "mypuppy.png", "director" => "Jason Kim", "cast" => "Yoo Yeon-seok, Cha Tae-hyun", "synopsis" => "Min-soo (Yoo Yeon-seok) is an ordinary office worker who dreams of a perfect family. He has a dog, Rooney, whom he treats as a younger brother. Unexpected circumstances arise when he can no longer live with Rooney due to his fiancée’s allergy." ]);
    $db->addMovie([ "title" => "Suzume", "genre" => "Animation", "running_time" => "122", "language" => "Japanese (Sub: English, Chinese)", "picture" => "suzume.png", "director" => "Makoto Shinkai", "cast" => "Nanoka Hara, Hokuto Matsumura, Eri Fukatsu", "synopsis" => "A 17-year-old girl named Suzume embarks on a journey across Japan to close mysterious doors that bring disasters." ]);
}

// Create default reviews if no reviews exist
if (count($db->getReviews()) === 0) {
    $db->addReview([ "movie_id" => 1, "user_id" => 3, "review" => "Joined in the Avatar bandwagon late but what a spectacle. stunning visual effects", "rating" => 5, "date_posted" => "2023-03-29" ]);
    $db->addReview([ "movie_id" => 2, "user_id" => 1, "review" => "Heartwarming show, definitely worth a watch", "rating" => 5, "date_posted" => "2023-04-04" ]);
    $db->addReview([ "movie_id" => 2, "user_id" => 3, "review" => "Quite boring.", "rating" => 2, "date_posted" => "2023-04-19" ]);
}

// CSRF Configuration
if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

function validateCSRFToken($token) {
    return isset($_SESSION["csrf_token"]) && hash_equals($_SESSION["csrf_token"], $token);
}

// Util functions
function redirectUrl($url) {
    echo '<meta http-equiv="refresh" content="0; URL=' . $url . '">';
}