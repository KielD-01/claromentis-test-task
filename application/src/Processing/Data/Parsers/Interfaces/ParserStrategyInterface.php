<?php

namespace KielD01\ClaromentisTestTask\Processing\Data\Parsers\Interfaces;

interface ParserStrategyInterface
{
    public function parse($mixedData): array;
}