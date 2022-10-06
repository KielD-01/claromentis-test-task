<?php

if (!function_exists('mix')) {
    /**
     * @param string $type
     * @param string $name
     * @return mixed
     * @throws Exception
     */
    function mix(string $type = 'js', string $name = 'app'): string
    {
        $mixFile = PUBLIC_PATH . 'public/mix-manifest.json';

        if (is_file($mixFile)) {
            $fileKey = sprintf('/%s/%s.%s', $type, $name, $type);
            $mix = json_decode(file_get_contents($mixFile), true);

            $path = $mix[$fileKey] ?? null;

            if ($path) {
                return $path;
            }

            throw new Exception(sprintf('Key `%s` has not been found in Mix manifest', $fileKey));
        }

        throw new Exception('Mix manifest does not exist');
    }
}

if (!function_exists('bcsum')) {
    function bcsum(array $digits = []) {
        $total = 0;

        foreach ($digits as $digit) {
            $total = bcadd($total, $digit, 2);
        }

        return $total;
    }
}