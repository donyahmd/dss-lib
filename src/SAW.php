<?php

namespace Donyahmd\DssLib;

/**
 * Class SAW
 *
 * Class untuk implementasi metode Simple Additive Weighting (SAW) pada sistem pendukung keputusan.
 * SAW digunakan untuk menghitung skor akhir alternatif berdasarkan bobot kriteria dan nilai subkriteria,
 * dengan opsional konsep cost dan benefit.
 *
 * @package Donyahmd\DssLib
 */
class SAW implements DecisionSupportEngine
{
    /**
     * Data kriteria dan subkriteria yang digunakan dalam perhitungan SAW.
     *
     * @var array
     */
    private $data;

    /**
     * Menentukan apakah menggunakan konsep cost dan benefit.
     *
     * @var bool
     */
    private $gunakanCostBenefit;

    /**
     * Constructor untuk inisialisasi objek SAW dengan data kriteria dan subkriteria.
     *
     * @param array $data
     * @param bool $gunakanCostBenefit Opsional. Menentukan apakah menggunakan konsep cost dan benefit. Default: false.
     */
    public function __construct(array $data, bool $gunakanCostBenefit = false)
    {
        $this->data = $data;
        $this->gunakanCostBenefit = $gunakanCostBenefit;
    }

    /**
     * Menghitung metode Simple Additive Weighting (SAW) dan mengembalikan skor akhir untuk setiap alternatif.
     *
     * @return array
     */
    public function hasil()
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
                $matriksNormalisasi[$kriteria][$alternatif] = $this->normalisasi($skor, $nilaiMaksimal);
            }
        }

        return $matriksNormalisasi;
    }

    /**
     * Mengalikan matriks normalisasi dengan bobot kriteria, dengan mempertimbangkan konsep cost dan benefit (opsional).
     *
     * @param array $matriksNormalisasi
     * @return array
     */
    private function matriksBobot(array $matriksNormalisasi)
    {
        $matriksBobot = [];

        // Terapkan bobot pada matriks normalisasi
        foreach ($matriksNormalisasi as $kriteria => $nilai) {
            $isCost = $this->gunakanCostBenefit && $this->data['jenis'][$kriteria] === 'cost';

            foreach ($nilai as $alternatif => $skorNormalisasi) {
                $matriksBobot[$kriteria][$alternatif] = $this->terapkanBobot($skorNormalisasi, $this->data['bobot'][$kriteria], $isCost);
            }
        }

        return $matriksBobot;
    }

    /**
     * Normalisasi nilai dengan membaginya oleh nilai maksimal.
     *
     * @param float $nilai
     * @param float $nilaiMaksimal
     * @return float
     */
    private function normalisasi($nilai, $nilaiMaksimal)
    {
        return $nilai / $nilaiMaksimal;
    }

    /**
     * Mengaplikasikan bobot dengan mempertimbangkan konsep cost dan benefit (opsional).
     *
     * @param float $nilai
     * @param float $bobot
     * @param bool $isCost
     * @return float
     */
    private function terapkanBobot($nilai, $bobot, $isCost)
    {
        if ($isCost) {
            // Jika kriteria bersifat cost, kurangkan bobot dari 1
            return $nilai * (1 - $bobot);
        } else {
            // Jika kriteria bersifat benefit, biarkan bobot seperti biasa
            return $nilai * $bobot;
        }
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
        foreach ($matriksBobot[array_key_first($matriksBobot)] as $alternatif => $skor) {
            $skorAkhir[$alternatif] = array_sum(array_column($matriksBobot, $alternatif));
        }

        return $skorAkhir;
    }
}
