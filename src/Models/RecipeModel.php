<?php
namespace Models;

class RecipeModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllRecipes() {
        $stmt = $this->pdo->query("SELECT * FROM recipes");
        return $stmt->fetchAll();
    }
}
