<?php

namespace App\Services\Surat;

class LetterBodyParser
{
    /**
     * Parse a rendered letter body into structured sections.
     *
     * Blocks of consecutive "Label: value" lines are detected as tables so they
     * can be rendered with proper layout instead of a wall of plain text.
     *
     * @return array<int, array{type: string, text?: string, rows?: array<int, array{label: string, value: string}>}>
     */
    public function parse(string $body): array
    {
        $blocks = $this->splitBlocks($body);

        $sections = [];
        foreach ($blocks as $lines) {
            $rows = [];
            $headings = [];
            foreach ($lines as $line) {
                if (preg_match('/^(.{1,60}?):\s+(.+)$/u', $line, $m)) {
                    $rows[] = ['label' => trim($m[1]), 'value' => trim($m[2])];
                } else {
                    $headings[] = $line;
                }
            }

            if (count($rows) >= 2) {
                if ($headings !== []) {
                    $sections[] = ['type' => 'paragraph', 'text' => implode(' ', $headings)];
                }
                $sections[] = ['type' => 'table', 'rows' => $rows];

                continue;
            }

            $text = implode(' ', array_merge($headings, array_map(
                fn (array $row): string => $row['label'].': '.$row['value'],
                $rows
            )));

            if (trim($text) !== '') {
                $sections[] = ['type' => 'paragraph', 'text' => trim($text)];
            }
        }

        return $sections;
    }

    /**
     * @return array<int, array<int, string>>
     */
    private function splitBlocks(string $body): array
    {
        $rawLines = preg_split('/\r\n|\r|\n/', $body);

        $blocks = [];
        $current = [];
        foreach ($rawLines as $line) {
            $line = trim($line);
            if ($line === '') {
                if ($current !== []) {
                    $blocks[] = $current;
                    $current = [];
                }

                continue;
            }
            $current[] = $line;
        }
        if ($current !== []) {
            $blocks[] = $current;
        }

        return $blocks;
    }
}
