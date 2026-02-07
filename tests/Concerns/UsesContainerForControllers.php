<?php

namespace Tests\Concerns;

trait UsesContainerForControllers
{
    protected function setUp(): void
    {
        parent::setUp();

        // Заставляем Laravel использовать контейнер для создания контроллеров в тестах
        $this->app->bind(\Illuminate\Routing\Controller::class, function ($app) {
            return $app->makeWith(\Illuminate\Routing\Controller::class, []);
        });
    }
}
