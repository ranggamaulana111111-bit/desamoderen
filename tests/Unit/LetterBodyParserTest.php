<?php

namespace Tests\Unit;

use App\Services\Surat\LetterBodyParser;
use PHPUnit\Framework\TestCase;

class LetterBodyParserTest extends TestCase
{
    private function parse(string $body): array
    {
        return (new LetterBodyParser)->parse($body);
    }

    public function test_detects_identity_table_between_paragraphs(): void
    {
        $body = "Yang bertanda tangan di bawah ini, Kepala Desa Kumpay, menerangkan bahwa:\n\nNama: Budi Santoso\nNIK: 3204120000000001\nTempat, Tgl Lahir: Subang, 1 Januari 2000\nAlamat: Kp. Kumpay\n\nBahwa yang bersangkutan benar warga Desa Kumpay.";

        $sections = $this->parse($body);

        $this->assertSame('paragraph', $sections[0]['type']);
        $this->assertSame('Yang bertanda tangan di bawah ini, Kepala Desa Kumpay, menerangkan bahwa:', $sections[0]['text']);

        $this->assertSame('table', $sections[1]['type']);
        $this->assertCount(4, $sections[1]['rows']);
        $this->assertSame(['label' => 'NIK', 'value' => '3204120000000001'], $sections[1]['rows'][1]);

        $this->assertSame('paragraph', $sections[2]['type']);
    }

    public function test_heading_line_before_table_becomes_paragraph(): void
    {
        $body = "Benar berdomisili di:\n\nAlamat: Jl. Merdeka No. 1\nRT / RW: 03 / 02\nKecamatan: Ciasem";

        $sections = $this->parse($body);

        $this->assertSame('paragraph', $sections[0]['type']);
        $this->assertSame('Benar berdomisili di:', $sections[0]['text']);
        $this->assertSame('table', $sections[1]['type']);
        $this->assertCount(3, $sections[1]['rows']);
        $this->assertSame('03 / 02', $sections[1]['rows'][1]['value']);
    }

    public function test_single_row_block_is_rendered_as_paragraph(): void
    {
        $sections = $this->parse('Alasan pindah: pekerjaan.');

        $this->assertCount(1, $sections);
        $this->assertSame('paragraph', $sections[0]['type']);
        $this->assertSame('Alasan pindah: pekerjaan.', $sections[0]['text']);
    }

    public function test_value_containing_colon_is_kept_whole(): void
    {
        $sections = $this->parse("Nama: Budi\nAlamat: RT 01: Jl. Merdeka");

        $this->assertSame('table', $sections[0]['type']);
        $this->assertSame('RT 01: Jl. Merdeka', $sections[0]['rows'][1]['value']);
    }

    public function test_empty_body_returns_no_sections(): void
    {
        $this->assertSame([], $this->parse(''));
        $this->assertSame([], $this->parse("   \n\n  "));
    }
}
