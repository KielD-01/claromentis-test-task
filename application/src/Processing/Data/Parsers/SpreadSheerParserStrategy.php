<?php

namespace KielD01\ClaromentisTestTask\Processing\Data\Parsers;

use KielD01\ClaromentisTestTask\Processing\Data\Parsers\Interfaces\ParserStrategyInterface;

abstract class SpreadSheerParserStrategy implements ParserStrategyInterface
{
    private array $parserTypesMap = [
        'string' => 'parseString',
        'array' => 'parseArray'
    ];

    public function parse($mixedData): array
    {
        $type = gettype($mixedData);
        $method = $this->parserTypesMap[$type] ?: false;

        return [
            'success' => $method !== false,
            'data' => $method ? $this->{$method}($mixedData) : null
        ];
    }

    abstract protected function parseString(string $stringData): array;

    abstract protected function parseArray(array $arrayData): array;
}