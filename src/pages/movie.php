<?php
if (!isset($_GET["id"])) {
    redirectUrl("/");
    exit();
}

$movie = $db->getMovie($_GET["id"]);

if (!$movie) {
    redirectUrl("/");
    exit();
}

$reviews = $db->getReviewsByMovie($movie["id"]);
?>

<style>
    .center {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 10px;
        flex-direction: column;
        gap: 25px;
    }

    .movie-body {
        display: flex;
        gap: 2rem;
        justify-content: center;
        width: 48rem;
    }

    .add-review-button {
        margin-inline: 10px;
        margin-bottom: 10px;
    }
</style>

<div class="center">
    <div class="movie-body">
        <img src="../images/<?= $movie["picture"] ?>" alt="" style="width: 24rem; object-fit: cover; border-radius: 12px !important;" class="card-img-top">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title"><?= $movie["title"] ?></h3>
                <p><?= $movie["synopsis"] ?></p>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"></li>
                    <li class="list-group-item">
                        <b>Genre</b>
                        <span style="float: right">
                            <?= $movie["genre"] ?>
                        </span>
                    </li>
                    <li class="list-group-item">
                        <b>Running Time</b>
                        <span style="float: right">
                            <?= $movie["running_time"] ?> minutes
                        </span>
                    </li>
                    <li class="list-group-item">
                        <b>Language</b>
                        <span style="float: right">
                            <?= $movie["language"] ?>
                        </span>
                    </li>
                    <li class="list-group-item">
                        <b>Director</b>
                        <span style="float: right">
                            <?= $movie["director"] ?>
                        </span>
                    </li>
                    <li class="list-group-item">
                        <b>Casts</b>
                        <div>
                            <?= $movie["cast"] ?>
                        </div>
                    </li>
                    <li class="list-group-item"></li>
                </ul>
            </div>
            <a class="btn btn-success add-review-button">Add Review</a>
        </div>
    </div>
    <div>
        <h3 style="text-align: center">Reviews</h3>
        <div class="container-fluid">
            <?php foreach ($reviews as $review) { ?>
                <div class="col mx-auto text-center pb-3">
                    <div class="card" style="padding: 0 5px">
                        <h5 class="card-title pt-1"><?= $review["name"] . " (@" . $review["username"] . ") - " . $review["rating"] . "/5" ?></h5>
                                <p><?= $review["review"]; ?></p>
                            </div>
                        </div>
            <?php } ?>
        </div>
    </div>
</div>