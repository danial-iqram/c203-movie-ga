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
?>

<style>
    .center {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 10px;
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
</div>

<!-- <div class="pt-3 pb-3">
    <div class="mx-auto text-center" style="width: 50%">
        <div class="card-body">
            <h3 class="card-title"><?= $movie["title"] ?></h3>
            <img src="../images/<?= $movie["picture"] ?>" alt="" style="width: 60%" class="card-img-top" style="object-fit: cover">

            <br/><br/><b>Synopsis:</b>
            <br/><p><?= $movie["synopsis"] ?></p>

            <br/><b>Genre: </b><?= $movie["genre"] ?>
            <br/><b>Running Time: </b><?= $movie["running_time"] ?> minutes
            <br/><b>Language: </b><?= $movie["language"] ?>
            <br/><b>Director: </b><?= $movie["director"] ?>
            <br/><b>Casts: </b><?= $movie["cast"] ?>
        </div>
    </div>
</div> -->