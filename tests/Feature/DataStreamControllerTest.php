<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DataStreamControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the data stream analysis API returns correct response.
     *
     * @return void
     */
    public function testAnalyzeSubsequences()
    {
        $data = [
            'stream' => 'AAABBBCCC',
            'k' => 3,
            'top' => 2,
            'exclude' => ['AAA']
        ];

        $response = $this->json('POST', '/api/data-stream/analyze', $data);

        //dd($response->getContent());

        // Assert correct structure in response
        $response->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        '*' => ['subsequence', 'count']
                    ]
                ])
                ->assertJson([
                    'data' => [
                        ['subsequence' => 'AAB', 'count' => 1],
                        ['subsequence' => 'ABB', 'count' => 1]
                    ]
                ]);
    }

    /**
     * Test validation on missing fields.
     *
     * @return void
     */
    public function testValidateMissingFields()
    {
        $data = [
            // Missing 'stream' and 'k'
            'top' => 2,
            'exclude' => ['AAA']
        ];

        $response = $this->json('POST', '/api/data-stream/analyze', $data);

        // Assert validation errors
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['stream', 'k']);
    }

    /**
     * Test the performance of the API on large inputs.
     *
     * @return void
     */
    public function testApiPerformanceOnLargeInputs()
    {
        $largeStream = str_repeat('A', 1000000) . str_repeat('B', 1000000) . str_repeat('C', 1000000);

        $data = [
            'stream' => $largeStream,
            'k' => 3,
            'top' => 5,
            'exclude' => []
        ];

        $startTime = microtime(true);
        $response = $this->json('POST', '/api/data-stream/analyze', $data);
        $endTime = microtime(true);

        $executionTime = $endTime - $startTime;
        
        // Assert that the response time is within acceptable limits
        $response->assertStatus(200);
        $this->assertLessThan(5, $executionTime); // Less than 5 second
    }
}
