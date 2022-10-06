<?php

namespace KielD01\ClaromentisTestTask\Actions\Api;

use Exception;
use Illuminate\Http\UploadedFile;
use KielD01\ClaromentisTestTask\Processing\Data\Parsers\CsvParserStrategy;
use KielD01\Core\Action;

class ProcessCsvAction extends Action
{

    /**
     * @throws Exception
     */
    public function handle(): void
    {
        $csvParser = new CsvParserStrategy();

        json($csvParser->parse($this->getContent()));
    }

    private function getContent(): ?string
    {
        $content = request()->post('csv');
        /** @var UploadedFile $file */
        $file = request()->file('csv');

        if ($file instanceof UploadedFile) {
            $content = $file->getContent();
        }

        return $content;
    }
}