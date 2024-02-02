<?php

namespace donyahmd\DssLib;

/**
 * Class SAW
 *
 * Class untuk implementasi metode Simple Additive Weighting (SAW) pada sistem pendukung keputusan.
 * SAW digunakan untuk menghitung skor akhir alternatif berdasarkan bobot kriteria dan nilai subkriteria.
 *
 * @package donyahmd\DssLib
 */
class SAW
{
    /**
     * Data kriteria dan subkriteria yang digunakan dalam perhitungan SAW.
     *
     * @var array
     */
    private $data;

    /**
     * Constructor untuk inisialisasi objek SAW dengan data kriteria dan subkriteria.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Menghitung metode Simple Additive Weighting (SAW) dan mengembalikan skor akhir untuk setiap alternatif.
     *
     * @return array
     */
    public function hitungSAW()
    {
        $matriksNormalisasi = $this->normalisasiMatriks();
        $matriksBobot = $this->matriksBobot($matriksNormalisasi);
        $skorAkhir = $this->hitungSkorAkhir($matriksBobot);

        // Kembalikan skor akhir untuk setiap alternatif
        return $skorAkhir;
    }

    /**
     * Melakukan normalisasi matriks berdasarkan nilai maksimal kriteria.
     *
     * @return array
     */
    private function normalisasiMatriks()
    {
        $matriksNormalisasi = [];

        // Lakukan normalisasi untuk setiap kriteria
        foreach ($this->data['kriteria'] as $kriteria => $nilai) {
            $nilaiMaksimal = max($nilai);

            // Normalisasi nilai subkriteria
            foreach ($this->data['subkriteria'][$kriteria] as $alternatif => $skor) {
                $matriksNormalisasi[$kriteria][$alternatif] = $skor / $nilaiMaksimal;
            }
        }

        return $matriksNormalisasi;
    }

    /**
     * Mengalikan matriks normalisasi dengan bobot kriteria.
     *
     * @param array $matriksNormalisasi
     * @return array
     */
    private function matriksBobot(array $matriksNormalisasi)
    {
        $matriksBobot = [];

        // Terapkan bobot pada matriks normalisasi
        foreach ($matriksNormalisasi as $kriteria => $nilai) {
            foreach ($nilai as $alternatif => $skorNormalisasi) {
                $matriksBobot[$kriteria][$alternatif] = $skorNormalisasi * $this->data['bobot'][$kriteria];
            }
        }

        return $matriksBobot;
    }

    /**
     * Menghitung skor akhir dengan menjumlahkan skor terbobot untuk setiap alternatif.
     *
     * @param array $matriksBobot
     * @return array
     */
    private function hitungSkorAkhir(array $matriksBobot)
    {
        $skorAkhir = [];

        // Jumlahkan skor terbobot untuk setiap alternatif
        foreach ($matriksBobot['kriteria1'] as $alternatif => $skor) {
            $skorAkhir[$alternatif] = array_sum(array_column($matriksBobot, $alternatif));
        }

        return $skorAkhir;
    }
}
