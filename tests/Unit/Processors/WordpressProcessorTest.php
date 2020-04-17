<?php

namespace Exolnet\Wordpress\Graylog\Tests\Unit\Processors;

use Exolnet\Wordpress\Graylog\Processors\WordpressProcessor;
use PHPUnit\Framework\TestCase;

class WordpressProcessorTest extends TestCase
{
    /**
     * @var \Exolnet\Wordpress\Graylog\Processors\WordpressProcessor
     */
    protected $wordpressProcessor;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->wordpressProcessor = new WordpressProcessor();
    }

    /**
     * @return void
     */
    public function testItCanBeInitialized(): void
    {
        $this->assertInstanceOf(WordpressProcessor::class, $this->wordpressProcessor);
    }

    /**
     * @return void
     */
    public function testExtraDataAreCorrectlyDefined(): void
    {
        $emptyRecord = [
            'extra' => [],
        ];

        $record = ($this->wordpressProcessor)($emptyRecord);

        $this->assertIsArray($record);
    }
}
