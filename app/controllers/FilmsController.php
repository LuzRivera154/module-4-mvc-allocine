<?php

require_once(__DIR__ . "/../models/FilmsModel.php");
require_once(__DIR__ . "/../models/DiffusionModel.php");

class FilmsController
{
    public function view(string $method, array $params = [])
    {
        $isSuccess = call_user_func([$this, $method], $params);
        if (!$isSuccess) {
            require_once(__DIR__ . '/../views/404.php');
        }
    }

    public function all($params = [])
    {
        try {
            $filmsModel = new Films();

            $films = $filmsModel->getAll();
        } catch (\Throwable $th) {
            console($th->getMessage());
        } finally {
            require_once(__DIR__ . '/../views/films.php');
        }
    }
}
