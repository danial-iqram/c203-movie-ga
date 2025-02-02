<?php
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (!isset($_GET["action"])) {
        redirectUrl("/");
        exit();
    } else {
        $action = $_GET["action"];
    }
    
    if (!isset($_GET["id"])) {
        redirectUrl("/");
        exit();
    } else {
        $id = $_GET["id"];
    }
    
    if ($action === "add") {
        $movie = $db->getMovie($id);
        $movieTitle = $movie["title"];
    } else if ($action === "edit") {
        $review = $db->getReview($id);

        if ($review["user_id"] !== $_SESSION["user"]["id"]) {
            redirectUrl("/");
            exit();
        }
    } else if ($action === "delete") {
        $review = $db->getReview($id);

        if ($review["user_id"] !== $_SESSION["user"]["id"]) {
            redirectUrl("/");
            exit();
        }

        $db->deleteReview($id);
        
        redirectUrl("movie.php?id=" . $review["movie_id"]);
        exit();
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["action"]) && isset($_POST["id"])) {
        $action = $_POST["action"];
        $id = $_POST["id"];

        if ($action === "addReview") {
            $review = $_POST["review"];
            $rating = $_POST["rating"];
            $db->addReview([
                "movie_id" => $id, 
                "user_id" => $_SESSION["user"]["id"], 
                "review" => $review, 
                "rating" => $rating, 
                "date_posted" => date("Y-m-d")
            ]);
            redirectUrl("movie.php?id=$id");
            exit();
        } else if ($action === "editReview") {
            $currentReview = $db->getReview($id);

            if ($currentReview["user_id"] !== $_SESSION["user"]["id"]) {
                redirectUrl("/");
                exit();
            }

            $updatedReview = $_POST["review"];
            $updatedRating = $_POST["rating"];

            $db->updateReview($id, $updatedReview, $updatedRating);

            redirectUrl("movie.php?id=" . $currentReview["movie_id"]);
            exit();
        }
    }
}

?>

<?php if ($_SERVER["REQUEST_METHOD"] === "GET") { 
    if ($action == "add") { ?> 
    <h2 class="text-center pt-3">Add Review - <?= $movieTitle; ?></h2> 
    <form action="review.php" method="POST"> 
        <input type="hidden" name="id" value="<?= $id ?>"/>
        <input type="hidden" name="action" value="addReview"/>
        
        <div style="margin: 30px auto;width:350px">
            <label for="review" class="form-label required">Review:</label>
            <textarea class="form-control" style="min-height:250px" id="review" name="review" required></textarea>
        </div>
        <div style="margin: 30px auto;width:350px">
            <label for="rating" class="form-label required">Rating:</label>
            <select class="form-select" id="rating" name="rating" required>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
            </select>
        </div>

        <div class="text-center" style="padding-bottom:30px">
            <input type="submit" class="btn btn-success" value="Add">
        </div>
    </form>
<?php } elseif ($action === 'edit') { ?>
    <h2 class="text-center pt-3">Edit Review</h2>
    <form action="review.php" method="POST">
        <input type="hidden" name="id" value="<?= $id ?>"/>
        <input type="hidden" name="action" value="editReview"/>
            
        <div style="margin: 30px auto;width:350px">
            <label for="review" class="form-label required">Review:</label>
            <textarea class="form-control" style="min-height:250px" id="review" name="review" required><?= $review["review"] ?></textarea>
        </div>
        <div style="margin: 30px auto;width:350px">
            <label for="rating" class="form-label required">Rating:</label>
            <select class="form-select" id="rating" name="rating" required>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
            </select>
        </div>

        <div class="text-center" style="padding-bottom:30px">
            <input type="submit" class="btn btn-success" value="Update">
        </div>
    </form>
<?php } } ?>