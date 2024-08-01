<?php

use PHPUnit\Framework\TestCase;
use Models\RecipeModel;

class RecipeTest extends TestCase {
    private $pdo;
    private $model;

    protected function setUp(): void {
        $this->pdo = new PDO('pgsql:host=postgres;dbname=hellofresh', 'hellofresh', 'hellofresh');
        $this->model = new RecipeModel($this->pdo);
    }

    public function testGetAllRecipes() {
        $recipes = $this->model->getAllRecipes();
        $this->assertIsArray($recipes);
    }
}
