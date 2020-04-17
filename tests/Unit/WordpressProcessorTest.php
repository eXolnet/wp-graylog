<?php

namespace Exolnet\Wordpress\Graylog\Tests\Unit;

use Exolnet\Wordpress\Graylog\Processors\WordpressProcessor;
use PHPUnit\Framework\TestCase;

class WordpressProcessorTest extends TestCase
{
    /**
     * @return void
     */
    public function testExtraDataAreCorrectlyDefined(): void
    {
        $emptyRecord = [
            'extra' => [],
        ];

        $record = (new WordpressProcessor)($emptyRecord);

        $this->assertIsArray($record);
    }
}
