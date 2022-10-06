<?php

namespace KielD01\ClaromentisTestTask\Processing\Data\Parsers;

class CsvParserStrategy extends SpreadSheerParserStrategy
{

    protected function parseString(string $stringData): array
    {
        $array = explode("\n", $stringData);

        return $this->parseArray(array_filter($array));
    }

    protected function parseArray(array $arrayData): array
    {
        $items = [];
        try {
            array_map(function ($item) use (&$items) {
                $result = explode(',', $item);

                if (count($result) === 3) {
                    [$title, $price, $amount] = $result;

                    $items[$title]['items'][] = [
                        'amount' => $amount,
                        'price' => $price,
                        'total' => bcmul($amount, $price, 2)
                    ];
                }
            }, $arrayData);
        } catch (\Exception $exception) {
        }

        return $this->calculateTotal($items);
    }

    private function calculateTotal(array $items): array
    {
        array_filter($items, function (array $data, string $key) use (&$items) {
            $dataItems = $data['items'];

            $items[$key]['total'] = bcsum(array_column($dataItems, 'total'));
            $items[$key]['amount'] = bcsum(array_column($dataItems, 'amount'));
            $items[$key]['price'] = bcsum(array_column($dataItems, 'price'));

        }, ARRAY_FILTER_USE_BOTH);

        return $items;
    }
}