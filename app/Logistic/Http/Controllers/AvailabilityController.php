<?php

namespace App\Logistic\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Logistic\Services\SlotService;

class AvailabilityController extends Controller
{
    public function __construct(
        private readonly SlotService $slotService,
    ) {
    }

    public function availability()
    {
        return response()->json(
            $this->slotService->getAvailability()->values(),
            200
        );
    }
}
