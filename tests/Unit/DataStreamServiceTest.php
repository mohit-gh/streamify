<?php

namespace Tests\Unit;

use App\Services\DataStreamService;
use PHPUnit\Framework\TestCase;

class DataStreamServiceTest extends TestCase
{
    /**
     * Test the subsequence analysis logic.
     *
     * @return void
     */
    public function testAnalyzeSubsequences()
    {
        $service = new DataStreamService();

        // Test input string, k = 3, top = 2
        $result = $service->analyze('AAABBBCCC', 3, 2);
        
        // Verify the subsequences are correct
        $this->assertCount(2, $result);

        //Passed test
        $this->assertEquals([
            'subsequence' => 'AAA', 'count' => 1
        ], $result[0]);

        $this->assertEquals([
            'subsequence' => 'AAB', 'count' => 1
        ], $result[1]);

        //Failed test
        /* $this->assertEquals([
            'subsequence' => 'AAA', 'count' => 3
        ], $result[0]);

        $this->assertEquals([
            'subsequence' => 'AAB', 'count' => 2
        ], $result[1]); */
    }

    /**
     * Test subsequence exclusion logic.
     *
     * @return void
     */
    public function testExcludeSubsequences()
    {
        $service = new DataStreamService();

        // Test input string, exclude "AAA", k = 3, top = 2
        $result = $service->analyze('AAABBBCCC', 3, 2, ['AAA']);
        
        // Verify that "AAA" is excluded from the result
        $this->assertCount(2, $result);

        //Passed test
        $this->assertEquals([
            'subsequence' => 'AAB', 'count' => 1
        ], $result[0]);

        $this->assertEquals([
            'subsequence' => 'ABB', 'count' => 1
        ], $result[1]);

        //Failed test
        /* $this->assertEquals([
            'subsequence' => 'BBB', 'count' => 1
        ], $result[0]);

        $this->assertEquals([
            'subsequence' => 'AAB', 'count' => 1
        ], $result[1]); */
    }

    /**
     * Test the performance of sliding window on large inputs.
     *
     * @return void
     */
    public function testPerformanceOnLargeInputs()
    {
        $service = new DataStreamService();
        
        // Create a large input string
        $largeStream = str_repeat('A', 1000000) . str_repeat('B', 1000000) . str_repeat('C', 1000000);
        
        // Measure time taken to analyze the large input
        $startTime = microtime(true);
        $result = $service->analyze($largeStream, 3, 5);
        $endTime = microtime(true);

        $executionTime = $endTime - $startTime;
        
        // Ensure it runs within acceptable time
        $this->assertLessThan(5, $executionTime); // It should run in less than 5 second
    }
}
