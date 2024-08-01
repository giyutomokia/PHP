<?php

namespace App\Controllers;

use App\Models\RecipeModel;
use App\Models\RatingModel;

class RecipeController
{
    private $recipeModel;
    private $ratingModel;

    public function __construct()
    {
        $this->recipeModel = new RecipeModel();
        $this->ratingModel = new RatingModel();
    }

    public function listRecipes()
    {
        $recipes = $this->recipeModel->getAll();
        echo json_encode($recipes);
    }

    public function createRecipe()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->recipeModel->create($data);
        http_response_code(201);
    }

    public function getRecipe($id)
    {
        $recipe = $this->recipeModel->get($id);
        echo json_encode($recipe);
    }

    public function updateRecipe($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->recipeModel->update($id, $data);
        http_response_code(204);
    }

    public function deleteRecipe($id)
    {
        $this->recipeModel->delete($id);
        http_response_code(204);
    }

    public function rateRecipe($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->ratingModel->create($id, $data['rating']);
        http_response_code(201);
    }

    public function searchRecipes()
    {
        $query = $_GET['query'] ?? '';
        $recipes = $this->recipeModel->search($query);
        echo json_encode($recipes);
    }
}
