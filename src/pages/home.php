<?php
if (isset($_GET["q"])) {
    $movies = $db->getMoviesBySearch('%' . $_GET["q"] . '%');
} else {
    $movies = $db->getMovies();
}

?>

<style>
    .see-more-button {
        margin-inline: 10px;
        margin-bottom: 10px;
    }

    .truncate {
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<h2 class="text-center pt-2">Movies</h2>
<div class="pt-2 pb-5 container-fluid d-flex align-items-center justify-content-center">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3" style="width: 48rem">
            <?php foreach ($movies as $movie) { ?>
            <div class="col h-100">
                <div class="card ">
                    <img src="../images/<?= $movie["picture"] ?>" alt="" class="card-img-top" style="object-fit: cover">
                    <div class="card-body">
                        <h5 class="card-title"><?= $movie["title"] ?></h5>
                        <p class="truncate"><?= $movie["synopsis"] ?></p>
                        
                    </div>
                    <a class="btn btn-success see-more-button" href="movie.php?id=<?= $movie["id"] ?>">See More</a>
                </div>
            </div>
            <?php } ?>
    </div>
</div>