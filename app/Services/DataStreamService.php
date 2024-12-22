<?php

namespace App\Services;

class DataStreamService
{
    /**
     * Analyze the data stream.
     *
     * @param string $stream
     * @param int $k
     * @param int $top
     * @param array $exclude
     * @return array
     */
    public function analyze(string $stream, int $k, int $top, array $exclude = []): array
    {
        // Initialize subsequence count
        $subsequences = [];

        // Extract all subsequences of length k
        for ($i = 0; $i <= strlen($stream) - $k; $i++) {
            $subsequence = substr($stream, $i, $k);
            if (!in_array($subsequence, $exclude)) {
                if (!isset($subsequences[$subsequence])) {
                    $subsequences[$subsequence] = 0;
                }
                $subsequences[$subsequence]++;
            }
        }

        // Sort subsequences by count in descending order
        arsort($subsequences);

        // Take the top N subsequences
        $result = array_slice($subsequences, 0, $top, true);

        // Format the response
        $response = [];
        foreach ($result as $subsequence => $count) {
            $response[] = [
                'subsequence' => $subsequence,
                'count' => $count,
            ];
        }

        return $response;
    }
}
