<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProspectController extends Controller
{
    public function store(StoreProspectRequest $request): JsonRespose
    {
        $prospect = Prospect::create($request->validated());

        return response()->json([
            'message' => 'Prospect created successfully',
            'prospect' => $prospect,
        ], 201);
    }
}
