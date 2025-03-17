<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;


class UserException extends Exception
{
    public function report(): void
    {
        Log::error("UserException: " . $this->getMessage());
    }
    public function render($request): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'error' => 'User Exception',
            'message' => $this->getMessage()
        ], 400);
    }

}
