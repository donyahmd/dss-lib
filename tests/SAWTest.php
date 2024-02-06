<?php

namespace Donyahmd\DssLib\Tests;

use Donyahmd\DssLib\SAW;

class SAWTest
{
    private $kriteria;
    private $dataAlternatif;

    public function __construct()
    {
        $this->kriteria = $this->kriteria();
        $this->dataAlternatif = $this->dataAlternatif();

        $this->klasifikasi($this->kriteria, $this->dataAlternatif);
    }

    private function kriteria()
    {
        return [
            [
                'kode' => 'C1',
                'nama' => 'Penghasilan Orang Tua',
                'atribut' => 'cost',
                'bobot' => 25,
                'is_range' => true,
                'crips' => [
                    [
                        'nilai' => null,
                        'nilai_min' => null,
                        'nilai_max' => 1000000,
                        'bobot' => 20,
                    ],
                    [
                        'nilai' => null,
                        'nilai_min' => 1000001,
                        'nilai_max' => 1500000,
                        'bobot' => 40,
                    ],
                    [
                        'nilai' => null,
                        'nilai_min' => 1500001,
                        'nilai_max' => 3000000,
                        'bobot' => 60,
                    ],
                    [
                        'nilai' => null,
                        'nilai_min' => 30000001,
                        'nilai_max' => 4500000,
                        'bobot' => 80,
                    ],
                    [
                        'nilai' => null,
                        'nilai_min' => 4500001,
                        'nilai_max' => null,
                        'bobot' => 100,
                    ],
                ],
            ],
            [
                'kode' => 'C2',
                'nama' => 'Semester',
                'atribut' => 'benefit',
                'is_range' => false,
                'bobot' => 20,
                'crips' => [
                    [
                        'nilai' => 4,
                        'nilai_min' => null,
                        'nilai_max' => null,
                        'bobot' => 20,
                    ],
                    [
                        'nilai' => 5,
                        'nilai_min' => null,
                        'nilai_max' => null,
                        'bobot' => 40,
                    ],
                    [
                        'nilai' => 6,
                        'nilai_min' => null,
                        'nilai_max' => null,
                        'bobot' => 60,
                    ],
                    [
                        'nilai' => 7,
                        'nilai_min' => null,
                        'nilai_max' => null,
                        'bobot' => 80,
                    ],
                    [
                        'nilai' => 8,
                        'nilai_min' => null,
                        'nilai_max' => null,
                        'bobot' => 100,
                    ],
                ],
            ],
            [
                'kode' => 'C3',
                'nama' => 'Tanggungan Orang Tua',
                'atribut' => 'benefit',
                'is_range' => false,
                'bobot' => 15,
                'crips' => [
                    [
                        'nilai' => 1,
                        'nilai_min' => null,
                        'nilai_max' => null,
                        'bobot' => 20,
                    ],
                    [
                        'nilai' => 2,
                        'nilai_min' => null,
                        'nilai_max' => null,
                        'bobot' => 40,
                    ],
                    [
                        'nilai' => 3,
                        'nilai_min' => null,
                        'nilai_max' => null,
                        'bobot' => 60,
                    ],
                    [
                        'nilai' => 4,
                        'nilai_min' => null,
                        'nilai_max' => null,
                        'bobot' => 80,
                    ],
                    [
                        'nilai' => null,
                        'nilai_min' => null,
                        'nilai_max' => null,
                        'bobot' => 100,
                    ],
                ],
            ],
            [
                'kode' => 'C4',
                'nama' => 'Saudara Kandung',
                'atribut' => 'benefit',
                'is_range' => false,
                'bobot' => 10,
                'crips' => [
                    [
                        'nilai' => 1,
                        'nilai_min' => null,
                        'nilai_max' => null,
                        'bobot' => 20,
                    ],
                    [
                        'nilai' => 2,
                        'nilai_min' => null,
                        'nilai_max' => null,
                        'bobot' => 40,
                    ],
                    [
                        'nilai' => 3,
                        'nilai_min' => null,
                        'nilai_max' => null,
                        'bobot' => 60,
                    ],
                    [
                        'nilai' => 4,
                        'nilai_min' => null,
                        'nilai_max' => null,
                        'bobot' => 80,
                    ],
                    [
                        'nilai' => null,
                        'nilai_min' => null,
                        'nilai_max' => null,
                        'bobot' => 100,
                    ],
                ],
            ],
            [
                'kode' => 'C5',
                'nama' => 'Nilai',
                'atribut' => 'benefit',
                'is_range' => true,
                'bobot' => 30,
                'crips' => [
                    [
                        'nilai_min' => null,
                        'nilai_max' => 2.75,
                        'bobot' => 20,
                    ],
                    [
                        'nilai_min' => 2.76,
                        'nilai_max' => 3.00,
                        'bobot' => 40,
                    ],
                    [
                        'nilai_min' => 3.01,
                        'nilai_max' => 3.25,
                        'bobot' => 60,
                    ],
                    [
                        'nilai_min' => 3.26,
                        'nilai_max' => 3.50,
                        'bobot' => 80,
                    ],
                    [
                        'nilai' => null,
                        'nilai_min' => 3.51,
                        'nilai_max' => null,
                        'bobot' => 100,
                    ],
                ],
            ],
        ];
    }

    private function dataAlternatif()
    {
        return [
            [
                'kode' => 'A1',
                'nama' => 'Davolio',
                'alternatif' => [
                    'C1' => 44000000,
                    'C2' => 4,
                    'C3' => 1,
                    'C4' => 2.3,
                ],
            ],
            [
                'kode' => 'A2',
                'nama' => 'Fuller',
                'alternatif' => [
                    'C1' => 900000,
                    'C2' => 5,
                    'C3' => 2,
                    'C4' => 2.95,
                ],
            ],
        ];
    }

    public function klasifikasi($dataKriteria, $dataAlternatif)
    {
        $klasifikasi = [];
        foreach ($dataAlternatif as $data) {
            $klasifikasi[$data['kode']] = null;
            foreach ($dataKriteria as $kriteria) {
                $klasifikasi[$data['kode']] = [
                    $kriteria['kode'] => $kriteria['bobot']
                ];
            }
        }

        print_r($klasifikasi);
    }
}

$test = new SAWTest;