<?php

namespace App\Http\Controllers;

use App\Http\Requests\DataStreamRequest;
use App\Services\DataStreamService;

class DataStreamController extends Controller
{
    
    protected $dataStreamService;

    /**
     * DataStreamController constructor.
     *
     * @param DataStreamService $dataStreamService
     */
    public function __construct(DataStreamService $dataStreamService) {
        $this->dataStreamService = $dataStreamService;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function analyze(DataStreamRequest $request)
    {
        // Retrieve validated input
        $validated = $request->validated();

        // Call the service class
        $result = $this->dataStreamService->analyze(
            $validated['stream'],
            $validated['k'],
            $validated['top'],
            $validated['exclude'] ?? []
        );

        return response()->json(['data' => $result]);

    }
    
}
