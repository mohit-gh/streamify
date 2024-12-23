<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class DataStreamService
{
    /**
     * Analyze the data stream and cache the results.
     *
     * @param string $stream
     * @param int $k
     * @param int $top
     * @param array $exclude
     * @return array
     */
    public function analyze(string $stream, int $k, int $top, array $exclude = []): array
    {
        // Generate a unique cache key
        $cacheKey = $this->generateCacheKey($stream, $k, $top, $exclude);

        // Check if the result is cached
        return Cache::remember($cacheKey, 3600, function () use ($stream, $k, $top, $exclude) {
            return $this->performAnalysis($stream, $k, $top, $exclude);
        });
    }

    /**
     * Perform the actual analysis (non-cached).
     *
     * @param string $stream
     * @param int $k
     * @param int $top
     * @param array $exclude
     * @return array
     */
    private function performAnalysis(string $stream, int $k, int $top, array $exclude): array
    {
        $subsequences = [];
        $length = strlen($stream);

        for ($i = 0; $i <= $length - $k; $i++) {
            $subsequence = substr($stream, $i, $k);

            if (!in_array($subsequence, $exclude)) {
                $subsequences[$subsequence] = ($subsequences[$subsequence] ?? 0) + 1;
            }
        }

        // Sort subsequences by frequency, descending
        arsort($subsequences);

        // Limit to top N subsequences
        return array_slice(
            array_map(fn($subsequence, $count) => ['subsequence' => $subsequence, 'count' => $count], array_keys($subsequences), $subsequences),
            0,
            $top
        );
    }

    /**
     * Generate a unique cache key for the given parameters.
     *
     * @param string $stream
     * @param int $k
     * @param int $top
     * @param array $exclude
     * @return string
     */
    private function generateCacheKey(string $stream, int $k, int $top, array $exclude): string
    {
        return 'analyze:' . md5(json_encode(compact('stream', 'k', 'top', 'exclude')));
    }
}
