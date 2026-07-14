<?php

namespace EcomPHP\Shopee\Tests;

use PHPUnit\Framework\TestCase;

class McpServerEntrypointTest extends TestCase
{
    private $temporaryDirectory;

    protected function tearDown(): void
    {
        if ($this->temporaryDirectory !== null) {
            $this->removeDirectory($this->temporaryDirectory);
        }
    }

    public function testLoadsAutoloaderFromConsumerProject()
    {
        $this->temporaryDirectory = sys_get_temp_dir().'/shopee-php-'.uniqid('', true);
        $packageBin = $this->temporaryDirectory.'/vendor/ecomphp/shopee-php/bin';
        mkdir($packageBin, 0777, true);
        file_put_contents($this->temporaryDirectory.'/vendor/autoload.php', "<?php\n");
        copy(dirname(__DIR__).'/bin/shopee-mcp-server', $packageBin.'/shopee-mcp-server');

        $process = proc_open(
            escapeshellarg(PHP_BINARY).' '.escapeshellarg($packageBin.'/shopee-mcp-server'),
            [['pipe', 'r'], ['pipe', 'w'], ['pipe', 'w']],
            $pipes
        );
        fclose($pipes[0]);
        $output = stream_get_contents($pipes[1]).stream_get_contents($pipes[2]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        $exitCode = proc_close($process);

        $this->assertSame(0, $exitCode, $output);
    }

    private function removeDirectory($directory)
    {
        $items = array_diff(scandir($directory), ['.', '..']);
        foreach ($items as $item) {
            $path = $directory.'/'.$item;
            is_dir($path) ? $this->removeDirectory($path) : unlink($path);
        }

        rmdir($directory);
    }
}