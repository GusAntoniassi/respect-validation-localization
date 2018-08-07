<?php

$outFile = __DIR__ . DIRECTORY_SEPARATOR . 'api.txt';
fclose(fopen($outFile,'w'));

$recursiveDirectoryIterator = new \RecursiveDirectoryIterator(__DIR__ . DIRECTORY_SEPARATOR . 'Exceptions' . DIRECTORY_SEPARATOR);

$objects = new \RecursiveIteratorIterator($recursiveDirectoryIterator, RecursiveIteratorIterator::SELF_FIRST);

foreach ($objects as $name => $object) {
    if (is_file($name) && substr($name, -3) === 'php') {

        $matches = [];
        preg_match('/\$defaultTemplates = \[([\S\s]+?)];/m', file_get_contents($name), $matches);

        if (empty($matches[1])) {
            continue;
        }

        $defaultTemplates = $matches[1];
        $matches = [];
        preg_match_all('/self::.*?=> \'(.*?)\'/', $defaultTemplates, $matches);

        if (empty($matches[1])) {
            continue;
        }

        foreach ($matches[1] as $match) {
            file_put_contents($outFile, $match . PHP_EOL, FILE_APPEND);
        }
    }
}
