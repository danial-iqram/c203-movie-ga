<?php
class DB {
    private $pdo;

    public function __construct($dbPath) {
        if (file_exists($dbPath)) {
            try {
                $this->pdo = new PDO("sqlite:$dbPath");
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                // Create default DB
                $this->pdo->exec("
                    PRAGMA foreign_keys = ON;
            
                    -- Movies Table
                    CREATE TABLE IF NOT EXISTS movies (
                        id INTEGER PRIMARY KEY AUTOINCREMENT,
                        title TEXT NOT NULL,
                        genre TEXT NOT NULL,
                        running_time INTEGER NOT NULL,
                        language TEXT NOT NULL,
                        picture TEXT NOT NULL,
                        director TEXT NOT NULL,
                        cast TEXT NOT NULL,
                        synopsis TEXT NOT NULL
                    );
            
                    -- Reviews Table
                    CREATE TABLE IF NOT EXISTS reviews (
                        id INTEGER PRIMARY KEY AUTOINCREMENT,
                        movie_id INTEGER NOT NULL,
                        user_id INTEGER NOT NULL,
                        review TEXT NOT NULL,
                        rating INTEGER NOT NULL,
                        date_posted DATE NOT NULL,
                        FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE ON UPDATE CASCADE, 
                        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
                    );
            
                    -- Users Table
                    CREATE TABLE IF NOT EXISTS users (
                        id INTEGER PRIMARY KEY AUTOINCREMENT,
                        username TEXT UNIQUE NOT NULL,
                        password TEXT NOT NULL,
                        name TEXT NOT NULL,
                        dob DATE NOT NULL,
                        email TEXT NOT NULL
                    );
                ");
            } catch(PDOException $ex) {
                die("Database connection failed: " . $ex->getMessage());
            }
        }
    }

    // User Helpers
    public function getUserCount() {
        return $this->pdo
            ->query("SELECT COUNT(name) FROM users")
            ->fetch()[0];
    }

    public function getUserByEmailOrUsername($input) {
        $statement = $this->pdo->prepare("
            SELECT id, username, name, dob, email
            FROM users
            WHERE lower(email) = lower(:input) OR lower(username) = lower(:input)
        ");
        
        $statement->execute(["input" => $input]);

        return $statement->fetch();
    }

    public function isValidUserCredentials($id, $password) {
        $statement = $this->pdo->prepare("SELECT password FROM users WHERE id = :id");

        $statement->execute(["id" => $id]);
        $dbPassword = $statement->fetch()["password"];

        return password_verify($password, $dbPassword);
    }

    public function addUser($props) {
        $statement = $this->pdo->prepare("
            INSERT INTO users (username, password, name, dob, email)
            VALUES (:username, :password, :name, :dob, :email)
        ");

        $statement->execute($props);
    }

    // Movie Helpers
    public function getMovies() {
        return $this->pdo->query("SELECT * FROM movies")->fetchAll();
    }

    public function getMovie($id) {
        $statement = $this->pdo->prepare("SELECT * FROM movies WHERE id = :id");
        $statement->execute(["id" => $id]);

        return $statement->fetch();
    }

    // Review Helpers
    public function getReviews() {
        return $this->pdo->query("SELECT * FROM reviews")->fetchAll();
    }

    public function addReview($props) {
        $statement = $this->pdo->prepare("
            INSERT INTO reviews (movie_id, user_id, review, rating, date_posted)
            VALUES (:movie_id, :user_id, :review, :rating, :date_posted)
        ");

        $statement->execute($props);
    }

    public function getReviewsByMovie($movie) {
        $statement = $this->pdo->prepare("SELECT * FROM reviews WHERE movie_id = :movie_id");
        $statement->execute(["movie_id" => $movie]);

        return $statement->fetch();
    }
}