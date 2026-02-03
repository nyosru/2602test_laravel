<?php

namespace App\Repositories;

// app/Repositories/BaseRepository.php
abstract class BaseRepository
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    // ... остальные общие методы
}
