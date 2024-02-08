# SAW (Simple Additive Weighting) Decision Support Engine

SAW (Simple Additive Weighting) adalah salah satu metode dalam pengambilan keputusan multi-kriteria yang sederhana namun efektif. Library ini menyediakan implementasi SAW untuk menghitung peringkat alternatif berdasarkan kriteria yang diberikan.

## Penggunaan

Untuk menggunakan library ini, Anda perlu mengikuti langkah-langkah berikut:

### Instalasi

```bash
composer require donyahmd/saw-lib
```

### Penggunaan dalam Aplikasi Anda

Setelah Anda berhasil menginstal library ini, Anda dapat menggunakannya dalam aplikasi Anda dengan cara berikut:

1. Import kelas SAW ke dalam file PHP aplikasi Anda:

```php
use Donyahmd\DssLib\SAW;
```

2. Buat objek SAW dengan menyediakan kriteria dan data alternatif dalam format array yang sesuai. Berikut adalah contoh cara melakukannya:

```php
$saw = new SAW($this->kriteria(), $this->dataAlternatif());
$perhitunganSaw = $saw->klasifikasi()
    ->normalisasi()
    ->pembobotanKriteria()
    ->jumlahPembobotanPerAlternatif()
    ->peringkat();
$hasil = $perhitunganSaw->semua();
print_r($hasil);
```

Pastikan bahwa format array untuk kriteria dan data alternatif sesuai dengan yang dijelaskan di bawah.

## Format Array untuk Kriteria

Format array untuk kriteria harus mencakup elemen-elemen berikut:

**kode**: Kode unik untuk setiap kriteria.\
**nama**: Nama kriteria.\
**atribut**: Atribut kriteria, bisa berupa 'cost' atau 'benefit'.\
**bobot**: Bobot kriteria.\
**is_range**: Boolean yang menunjukkan apakah kriteria menggunakan rentang nilai atau nilai tunggal.\
**crips**: Daftar krips (nilai atau rentang nilai) dan bobotnya untuk kriteria tersebut.

Berikut adalah contoh format array untuk kriteria:

```php
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
        // Tambahkan krips lainnya sesuai kebutuhan
    ],
],
```

## Format Array untuk Data Alternatif

Format array untuk data alternatif harus mencakup elemen-elemen berikut:

**kode**: Kode unik untuk setiap alternatif.\
**nama**: Nama alternatif.\
**alternatif**: Nilai atau rentang nilai untuk setiap kriteria yang digunakan dalam evaluasi.

Berikut adalah contoh format array untuk data alternatif:

```php
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

```

Pastikan untuk menyediakan kriteria dan data alternatif dalam format array yang sesuai saat menggunakan fungsi SAW.

## Kontribusi

Anda dipersilakan untuk berkontribusi pada pengembangan library ini dengan mengirimkan pull request.

## Lisensi

Proyek ini dilisensikan di bawah lisensi MIT. Lihat file LICENSE untuk detailnya.
