<?php

declare(strict_types=1);

namespace LogTea\Tools;

interface ToolInterface
{
    /**
     * @param string[] $files stored file paths (already validated & saved by Uploads)
     * @param array<string,mixed> $options sanitized form options posted alongside the files
     * @return array{path:string, filename:string, mime:string} the output file to serve for download
     */
    public function run(array $files, array $options): array;
}
