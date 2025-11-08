<?php

namespace Database\Seeders;

use App\Models\Education;
use Illuminate\Database\Seeder;

class EducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $educations = [
            [
                'title' => '5 Makanan Kaya Zat Besi Selain Daging',
                'category' => 'Nutrisi',
                'content' => 'Zat besi adalah mineral penting yang dibutuhkan tubuh untuk memproduksi hemoglobin. Berikut adalah 5 makanan kaya zat besi selain daging:

1. Bayam - Sayuran hijau ini kaya akan zat besi non-heme. Konsumsi bersama vitamin C untuk penyerapan lebih baik.

2. Kacang-kacangan - Kacang merah, kacang hijau, dan lentil adalah sumber zat besi yang baik.

3. Tahu dan Tempe - Produk kedelai ini mengandung zat besi dan protein yang tinggi.

4. Biji-bijian - Biji labu, biji wijen, dan biji bunga matahari kaya akan zat besi.

5. Buah-buahan Kering - Kismis, kurma, dan aprikot kering mengandung zat besi yang mudah diserap.

Tips: Konsumsi makanan kaya zat besi bersama vitamin C (jeruk, tomat) untuk meningkatkan penyerapan zat besi non-heme.',
            ],
            [
                'title' => 'Kenali Tanda-tanda Awal Anemia',
                'category' => 'Anemia',
                'content' => 'Anemia terjadi ketika tubuh kekurangan sel darah merah atau hemoglobin. Kenali tanda-tanda awal berikut:

1. Kelelahan yang Berlebihan
   - Merasa lelah meskipun sudah cukup istirahat
   - Sulit berkonsentrasi
   - Merasa lesu sepanjang hari

2. Pucat
   - Wajah, bibir, dan kuku terlihat pucat
   - Bagian dalam kelopak mata bawah terlihat pucat

3. Sesak Napas
   - Napas pendek saat beraktivitas ringan
   - Jantung berdebar-debar

4. Pusing dan Sakit Kepala
   - Pusing saat berdiri
   - Sakit kepala yang sering terjadi

5. Tangan dan Kaki Dingin
   - Sirkulasi darah yang kurang optimal

Jika mengalami gejala-gejala ini, segera konsultasikan dengan dokter dan pertimbangkan untuk mengonsumsi Tablet Tambah Darah (TTD) sesuai anjuran.',
            ],
            [
                'title' => 'Hubungan Siklus Haid dan Energi Tubuh',
                'category' => 'Menstruasi',
                'content' => 'Siklus menstruasi mempengaruhi energi dan kondisi tubuh wanita. Berikut penjelasannya:

FASE MENSTRUASI (Hari 1-5)
- Tubuh kehilangan zat besi melalui darah
- Energi cenderung rendah
- Penting untuk mengonsumsi makanan kaya zat besi dan TTD

FASE FOLLIKULAR (Hari 6-14)
- Energi mulai meningkat
- Mood lebih baik
- Waktu yang baik untuk aktivitas fisik

FASE OVULASI (Hari 14-16)
- Puncak energi
- Kekuatan fisik optimal
- Waktu terbaik untuk aktivitas berat

FASE LUTEAL (Hari 17-28)
- Energi mulai menurun
- PMS mungkin terjadi
- Perlu istirahat lebih banyak

TIPS:
- Minum TTD secara teratur, terutama saat dan setelah menstruasi
- Konsumsi makanan bergizi seimbang
- Istirahat yang cukup
- Dengarkan tubuhmu dan sesuaikan aktivitas dengan fase siklus',
            ],
            [
                'title' => 'Cara Minum Tablet Tambah Darah yang Benar',
                'category' => 'TTD',
                'content' => 'Tablet Tambah Darah (TTD) membantu mencegah anemia. Berikut cara mengonsumsinya yang benar:

WAKTU KONSUMSI:
- Minum TTD seminggu sekali
- Pilih hari yang sama setiap minggu (misalnya setiap Senin)
- Minum setelah makan untuk mengurangi efek samping

CARA MINUM:
1. Minum dengan air putih yang cukup (1-2 gelas)
2. Jangan minum bersama teh atau kopi (mengganggu penyerapan)
3. Jangan minum bersama susu atau suplemen kalsium
4. Tunggu 2 jam setelah makan jika mengonsumsi antasida

EFEK SAMPING YANG MUNGKIN TERJADI:
- Mual ringan (bisa diminimalisir dengan minum setelah makan)
- Konstipasi (perbanyak serat dan air)
- Feses berwarna gelap (normal, tidak berbahaya)

PENTING:
- Konsultasikan dengan dokter sebelum mengonsumsi TTD
- Simpan di tempat yang kering dan sejuk
- Jauhkan dari jangkauan anak-anak
- Jangan mengonsumsi melebihi dosis yang dianjurkan',
            ],
            [
                'title' => 'Tips Menjaga Kesehatan Saat Menstruasi',
                'category' => 'Tips Sehat',
                'content' => 'Menstruasi adalah proses alami tubuh. Berikut tips untuk menjaga kesehatan selama menstruasi:

1. NUTRISI YANG TEPAT
   - Konsumsi makanan kaya zat besi (daging, sayuran hijau, kacang-kacangan)
   - Perbanyak vitamin C untuk penyerapan zat besi
   - Minum TTD sesuai jadwal
   - Hindari makanan yang terlalu pedas atau asam

2. HIDRASI
   - Minum air putih yang cukup (8-10 gelas per hari)
   - Hindari minuman berkafein berlebihan
   - Konsumsi air hangat untuk mengurangi kram

3. OLAHRAGA RINGAN
   - Lakukan olahraga ringan seperti jalan kaki atau yoga
   - Hindari olahraga berat saat hari pertama menstruasi
   - Olahraga dapat membantu mengurangi kram

4. ISTIRAHAT
   - Tidur cukup 7-9 jam per malam
   - Dengarkan tubuhmu, jika lelah, istirahatlah
   - Relaksasi dengan teknik pernapasan

5. KEBERSIHAN
   - Ganti pembalut setiap 4-6 jam
   - Cuci tangan sebelum dan sesudah mengganti pembalut
   - Gunakan pembalut yang sesuai dengan kebutuhan

6. MENGATASI KRAM
   - Kompres hangat di area perut
   - Pijat ringan area perut
   - Konsumsi makanan hangat
   - Minum teh jahe atau chamomile

Ingat: Jika mengalami gejala yang tidak normal atau sangat mengganggu, segera konsultasikan dengan dokter.',
            ],
        ];

        foreach ($educations as $education) {
            Education::create($education);
        }
    }
}
