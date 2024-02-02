<?php

namespace Donyahmd\DssLib\Tests;

use Donyahmd\DssLib\SAW;
use PHPUnit\Framework\TestCase;

class SAWTest extends TestCase
{
    public function testHitungSAW()
    {
        // Data contoh untuk pengujian
        $data = [
            'kriteria' => [
                'kriteria1' => [3, 4, 5],
                'kriteria2' => [8, 7, 6],
            ],
            'subkriteria' => [
                'kriteria1' => [
                    'alternatif1' => 2,
                    'alternatif2' => 4,
                    'alternatif3' => 3,
                ],
                'kriteria2' => [
                    'alternatif1' => 7,
                    'alternatif2' => 5,
                    'alternatif3' => 6,
                ],
            ],
            'bobot' => [
                'kriteria1' => 0.4,
                'kriteria2' => 0.6,
            ],
            'jenis' => [
                'kriteria1' => 'benefit',
                'kriteria2' => 'cost',
            ],
        ];

        // Objek SAW untuk pengujian
        $saw = new SAW($data, true);

        // Hasil yang diharapkan
        $expectedResult = [
            'alternatif1' => 4.3,  // Contoh hasil skor akhir untuk alternatif1
            'alternatif2' => 4.8,
            'alternatif3' => 4.1,
        ];

        // Menghitung SAW
        $result = $saw->hitungSAW();

        // Memeriksa apakah hasil sesuai dengan yang diharapkan
        $this->assertEquals($expectedResult, $result);
    }
}
