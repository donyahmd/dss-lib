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

        $dataKlasifikasi = $this->klasifikasi($this->kriteria, $this->dataAlternatif);
        $dataNormalisasi = $this->normalisasi($this->kriteria, $dataKlasifikasi);
        $pembobotanKriteria = $this->pembobotanKriteria($this->kriteria, $dataNormalisasi);
        $jumlahPembobotanPerAlternatif = $this->jumlahPembobotanPerAlternatif($pembobotanKriteria);
        print_r($this->peringkat($jumlahPembobotanPerAlternatif));
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
                        'nilai_min' => 3000001,
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
                        'nilai_max' => 3.49,
                        'bobot' => 80,
                    ],
                    [
                        'nilai' => null,
                        'nilai_min' => 3.50,
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
                    'C1' => 4400000,
                    'C2' => 4,
                    'C3' => 1,
                    'C4' => 1,
                    'C5' => 2.3,
                ],
            ],
            [
                'kode' => 'A2',
                'nama' => 'Fuller',
                'alternatif' => [
                    'C1' => 1400000,
                    'C2' => 5,
                    'C3' => 2,
                    'C4' => 2,
                    'C5' => 2.95,
                ],
            ],
            [
                'kode' => 'A3',
                'nama' => 'Leverling',
                'alternatif' => [
                    'C1' => 2500000,
                    'C2' => 6,
                    'C3' => 3,
                    'C4' => 3,
                    'C5' => 3.6,
                ],
            ],
            [
                'kode' => 'A4',
                'nama' => 'Peacock',
                'alternatif' => [
                    'C1' => 4500000,
                    'C2' => 7,
                    'C3' => 4,
                    'C4' => 4,
                    'C5' => 3.4,
                ],
            ],
            [
                'kode' => 'A5',
                'nama' => 'Alpha',
                'alternatif' => [
                    'C1' => 1500000,
                    'C2' => 4,
                    'C3' => 2,
                    'C4' => 3,
                    'C5' => 3.5,
                ],
            ],
        ];
    }

    public function klasifikasi($dataKriteria, $dataAlternatif)
    {
        $klasifikasi = [];
        foreach ($dataAlternatif as $data) {
            $row = [];

            foreach ($data['alternatif'] as $kode => $nilai) {
                foreach ($dataKriteria as $kriteria) {
                    if ($kriteria['kode'] == $kode) {
                        foreach ($kriteria['crips'] as $crip) {
                            if ($kriteria['is_range']) {
                                if (($crip['nilai_min'] === null || $nilai >= $crip['nilai_min']) &&
                                    ($crip['nilai_max'] === null || $nilai <= $crip['nilai_max'])) {
                                    $row[$kode] = $crip['bobot'];
                                }
                            } else {
                                if ($crip['nilai'] === $nilai) {
                                    $row[$kode] = $crip['bobot'];
                                }
                            }
                        }
                    }
                }
            }

            $klasifikasi[$data['kode']] = $row;
        }

        return $klasifikasi;
    }

    public function normalisasi($dataKriteria, $dataKlasifikasi)
    {
        $klasifikasiCostBenefit = [];
        // Memetakan atribut cost atau benefit dari setiap kriteria
        foreach ($dataKriteria as $kriteria) {
            $klasifikasiCostBenefit[$kriteria['kode']] = $kriteria['atribut'];
        }

        $nilaiMinMaxKriteria = [];
        // Inisialisasi nilai normalisasi untuk setiap alternatif
        $normalisasi = [];
        foreach($dataKlasifikasi as $alternatif => $klasifikasiNilai) {
            foreach ($klasifikasiNilai as $kodeKriteria => $nilai) {
                // Memeriksa apakah kriteria merupakan cost atau benefit
                $atribut = $klasifikasiCostBenefit[$kodeKriteria];
                if ($atribut == 'cost') {
                    // Jika cost, cari nilai terkecil
                    if (!isset($nilaiMinMaxKriteria[$kodeKriteria]) || $nilai < $nilaiMinMaxKriteria[$kodeKriteria]) {
                        $nilaiMinMaxKriteria[$kodeKriteria] = $nilai;
                    }
                } elseif ($atribut == 'benefit') {
                    // Jika benefit, cari nilai terbesar
                    if (!isset($nilaiMinMaxKriteria[$kodeKriteria]) || $nilai > $nilaiMinMaxKriteria[$kodeKriteria]) {
                        $nilaiMinMaxKriteria[$kodeKriteria] = $nilai;
                    }
                }
            }
        }

        // Menghitung nilai normalisasi untuk setiap alternatif
        foreach($dataKlasifikasi as $alternatif => $klasifikasiNilai) {
            foreach ($klasifikasiNilai as $kodeKriteria => $nilai) {
                // Memeriksa apakah kriteria merupakan cost atau benefit
                $atribut = $klasifikasiCostBenefit[$kodeKriteria];
                if ($atribut == 'cost') {
                    // Jika cost, nilai normalisasi adalah nilai terkecil dibagi dengan nilai alternatif
                    $normalisasi[$alternatif][$kodeKriteria] = $nilaiMinMaxKriteria[$kodeKriteria] != 0 ? $nilaiMinMaxKriteria[$kodeKriteria] / $nilai : 0;
                } elseif ($atribut == 'benefit') {
                    // Jika benefit, nilai normalisasi adalah nilai alternatif dibagi dengan nilai terbesar
                    $normalisasi[$alternatif][$kodeKriteria] = $nilai != 0 ? $nilai / $nilaiMinMaxKriteria[$kodeKriteria] : 0;
                }
            }
        }

        return $normalisasi;
    }

    public function pembobotanKriteria($dataKriteria, $dataNormalisasi)
    {
        $output = [];

        foreach ($dataNormalisasi as $key => $values) {
            $output[$key] = [];
            foreach ($values as $subkey => $value) {
                foreach ($dataKriteria as $kriteria) {
                    if ($subkey === $kriteria['kode']) {
                        $output[$key][$subkey] = $value * $kriteria['bobot'];
                        break;
                    }
                }
            }
        }

        return $output;
    }

    public function jumlahPembobotanPerAlternatif($dataNormalisasi)
    {
        $output = [];

        foreach ($dataNormalisasi as $key => $values) {
            $output[$key] = array_sum($values);
        }

        return $output;
    }

    public function peringkat($data, $ascending = true)
    {
        if ($ascending) {
            arsort($data);
        } else {
            asort($data);
        }
        return $data;
    }
}

$test = new SAWTest();
