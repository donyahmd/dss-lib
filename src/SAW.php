<?php

namespace Donyahmd\DssLib;

/**
 * Kelas SAW (Simple Additive Weighting) merupakan implementasi dari Decision Support Engine (DSE) untuk
 * melakukan analisis dan pengambilan keputusan berdasarkan metode Simple Additive Weighting.
 */
class SAW implements DecisionSupportEngine
{
    /**
     * @var array $data Data alternatif yang akan dievaluasi.
     */
    private $data;

    /**
     * @var array $kriteria Kriteria yang digunakan dalam evaluasi.
     */
    private $kriteria;

    /**
     * @var array $klasifikasi Hasil klasifikasi nilai berdasarkan kriteria.
     */
    private $klasifikasi;

    /**
     * @var array $normalisasi Hasil normalisasi nilai berdasarkan kriteria.
     */
    private $normalisasi;

    /**
     * @var array $pembobotan Hasil pembobotan nilai berdasarkan kriteria.
     */
    private $pembobotan;

    /**
     * @var array $jumlahPembobotan Jumlah pembobotan per alternatif.
     */
    private $jumlahPembobotan;

    /**
     * @var array $peringkat Hasil peringkat alternatif.
     */
    private $peringkat;

    /**
     * Membuat instance baru dari kelas SAW.
     *
     * @param array $kriteria Data kriteria yang akan digunakan dalam evaluasi.
     * @param array $data Data alternatif yang akan dievaluasi.
     */
    public function __construct(array $kriteria, array $data)
    {
        $this->kriteria = $kriteria;
        $this->data = $data;
    }

    /**
     * Melakukan klasifikasi nilai berdasarkan kriteria.
     *
     * @return SAW Objek SAW saat ini untuk memungkinkan pemanggilan metode berantai.
     */
    public function klasifikasi()
    {
        $klasifikasi = [];
        foreach ($this->data as $data) {
            $row = [];
            foreach ($data['alternatif'] as $kode => $nilai) {
                foreach ($this->kriteria as $kriteria) {
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
        $this->klasifikasi = $klasifikasi;
        return $this;
    }

    /**
     * Melakukan normalisasi nilai berdasarkan kriteria.
     *
     * @return SAW Objek SAW saat ini untuk memungkinkan pemanggilan metode berantai.
     */
    public function normalisasi()
    {
        $klasifikasiCostBenefit = [];
        $nilaiMinMaxKriteria = [];
        $normalisasi = [];

        // Memetakan atribut cost atau benefit dari setiap kriteria
        foreach ($this->kriteria as $kriteria) {
            $klasifikasiCostBenefit[$kriteria['kode']] = $kriteria['atribut'];
        }

        // Inisialisasi nilai normalisasi untuk setiap alternatif
        foreach ($this->klasifikasi as $alternatif => $klasifikasiNilai) {
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
        foreach ($this->klasifikasi as $alternatif => $klasifikasiNilai) {
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
        $this->normalisasi = $normalisasi;
        return $this;
    }

    /**
     * Melakukan pembobotan nilai berdasarkan kriteria.
     *
     * @return SAW Objek SAW saat ini untuk memungkinkan pemanggilan metode berantai.
     */
    public function pembobotanKriteria()
    {
        $output = [];

        foreach ($this->normalisasi as $key => $values) {
            $output[$key] = [];
            foreach ($values as $subkey => $value) {
                foreach ($this->kriteria as $kriteria) {
                    if ($subkey === $kriteria['kode']) {
                        $output[$key][$subkey] = $value * $kriteria['bobot'];
                        break;
                    }
                }
            }
        }
        $this->pembobotan = $output;
        return $this;
    }

    /**
     * Menghitung jumlah pembobotan per alternatif.
     *
     * @return SAW Objek SAW saat ini untuk memungkinkan pemanggilan metode berantai.
     */
    public function jumlahPembobotanPerAlternatif()
    {
        $output = [];

        foreach ($this->pembobotan as $key => $values) {
            $output[$key] = array_sum($values);
        }
        $this->jumlahPembobotan = $output;
        return $this;
    }

    /**
     * Melakukan peringkat terhadap alternatif berdasarkan jumlah pembobotan.
     *
     * @param bool $ascending Jika true, peringkat akan disusun dari terkecil ke terbesar. Jika false, sebaliknya.
     * @return SAW Objek SAW saat ini untuk memungkinkan pemanggilan metode berantai.
     */
    public function peringkat($ascending = true)
    {
        if ($ascending) {
            arsort($this->jumlahPembobotan);
        } else {
            asort($this->jumlahPembobotan);
        }
        $this->peringkat = $this->jumlahPembobotan;
        return $this;
    }

    /**
     * Mengembalikan hasil peringkat alternatif.
     *
     * @return array Hasil peringkat alternatif.
     */
    public function hasil()
    {
        return $this->peringkat;
    }

    /**
     * Mengembalikan semua perhitungan dan hasil.
     *
     * @return array Hasil semua perhitungan.
     */
    public function semua()
    {
        return [
            'klasifikasi' => $this->klasifikasi,
            'normalisasi' => $this->normalisasi,
            'pembobotan' => $this->pembobotan,
            'jumlahPembobotan' => $this->jumlahPembobotan,
            'peringkat' => $this->peringkat
        ];
    }
}
