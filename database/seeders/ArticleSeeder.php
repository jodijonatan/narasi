<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $user = User::where('role', 'user')->first();

        // If users don't exist, retrieve or create them
        if (!$admin) {
            $admin = User::factory()->create([
                'name' => 'Admin Narasi',
                'email' => 'admin@narasi.com',
                'role' => 'admin',
            ]);
        }

        if (!$user) {
            $user = User::factory()->create([
                'name' => 'Budi Santoso',
                'email' => 'budi@narasi.com',
                'role' => 'user',
            ]);
        }

        $categories = Category::all();

        if ($categories->isEmpty()) {
            $this->call(CategorySeeder::class);
            $categories = Category::all();
        }

        $articles = [
            [
                'title' => 'Masa Depan AI: Bagaimana Large Language Model Mengubah Industri Kreatif',
                'category_slug' => 'technology',
                'user_id' => $admin->id,
                'excerpt' => 'Kecerdasan Buatan (AI) bukan lagi sekadar masa depan, melainkan realitas hari ini. Temukan bagaimana LLM mengubah lanskap penulisan, desain, dan pembuatan konten komersial.',
                'content' => "Kecerdasan buatan (AI) kini telah melampaui fase eksperimen laboratorium dan menjadi pendorong utama transformasi di berbagai sektor kreatif. Kehadiran Large Language Models (LLM) seperti GPT-4 dan Claude telah mendefinisikan ulang cara kerja penulis, desainer, dan seniman digital.\n\nSalah satu perubahan paling signifikan terjadi pada efisiensi riset dan penulisan draf awal. Penulis kini menggunakan AI sebagai rekan berkolaborasi untuk memecahkan fenomena \"writer's block\". AI dapat menghasilkan ide outline, menyusun struktur artikel, bahkan memberikan saran kosakata alternatif dalam hitungan detik.\n\nNamun, perdebatan etis seputar hak cipta karya seni yang dihasilkan AI tetap menjadi topik hangat. Banyak ahli menyarankan agar industri menerapkan regulasi yang jelas mengenai transparansi penggunaan konten AI demi menjaga orisinalitas dan apresiasi terhadap talenta manusia.",
                'status' => 'published',
                'published_at' => now()->subDays(2),
                'thumbnail' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'title' => 'Minimalisme Finansial: Cara Mengelola Gaji untuk Kebebasan Masa Depan',
                'category_slug' => 'lifestyle',
                'user_id' => $user->id,
                'excerpt' => 'Gaya hidup konsumtif sering kali membuat kita terjebak dalam siklus utang. Pelajari prinsip minimalisme finansial untuk mencapai ketenangan pikiran dan tabungan melimpah.',
                'content' => "Minimalisme finansial bukan berarti hidup serba kekurangan atau kikir. Sebaliknya, ini adalah konsep hidup sadar di mana Anda mengalokasikan uang Anda hanya untuk hal-hal yang benar-benar memberikan nilai tambah bagi hidup Anda.\n\nLangkah pertama dalam menerapkan konsep ini adalah dengan membedakan secara tegas antara keinginan dan kebutuhan. Sebelum membeli barang baru, tanyakan pada diri sendiri: \"Apakah barang ini akan berguna dalam jangka panjang?\" atau \"Apakah saya membelinya hanya demi gengsi?\"\n\nDengan memotong pengeluaran impulsif, Anda dapat fokus mengalokasikan dana untuk investasi jangka panjang, persiapan dana darurat, dan membangun kebebasan finansial sejati.",
                'status' => 'published',
                'published_at' => now()->subDays(4),
                'thumbnail' => 'https://images.unsplash.com/photo-1579621970563-ebec7560ff3e?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'title' => 'Panduan Memulai Startup Digital dengan Modal Minim di Tahun 2026',
                'category_slug' => 'business',
                'user_id' => $admin->id,
                'excerpt' => 'Membangun bisnis teknologi tidak selalu membutuhkan pendanaan miliaran rupiah. Gunakan metode bootstrapping dan no-code tools untuk meluncurkan produk pertama Anda.',
                'content' => "Banyak calon wirausahawan menunda impian mereka karena mengira bahwa memulai startup membutuhkan modal yang sangat besar. Padahal, dengan berkembangnya ekosistem no-code dan cloud computing, meluncurkan produk minimum viable (MVP) kini jauh lebih terjangkau.\n\nMetode \"bootstrapping\" atau mendanai startup menggunakan modal pribadi dan pendapatan awal adalah pilihan terbaik untuk pemula. Ini memaksa pendiri startup untuk fokus menciptakan solusi yang benar-benar dibutuhkan pasar sejak hari pertama.\n\nGunakan tools gratis atau murah untuk membangun purwarupa produk Anda, lalu validasi ide tersebut langsung kepada target pengguna Anda sebelum memutuskan untuk mencari investor luar.",
                'status' => 'published',
                'published_at' => now()->subDays(6),
                'thumbnail' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'title' => 'Pentingnya Menjaga Kesehatan Mental di Tengah Tekanan Dunia Kerja Modern',
                'category_slug' => 'health',
                'user_id' => $user->id,
                'excerpt' => 'Burnout sering dianggap sebagai hal biasa di dunia kerja yang kompetitif. Ketahui tanda-tandanya dan cara menjaga kesehatan mental agar tetap produktif tanpa stres berlebih.',
                'content' => "Di era digital yang serba cepat ini, batasan antara kehidupan kerja dan kehidupan pribadi sering kali menjadi kabur. Akibatnya, banyak profesional mengalami burnout atau kelelahan mental yang akut tanpa mereka sadari.\n\nMenjaga kesehatan mental sama pentingnya dengan menjaga kesehatan fisik. Langkah awal yang bisa kita lakukan adalah dengan menetapkan batasan yang jelas, seperti tidak memeriksa email pekerjaan setelah jam kantor berakhir.\n\nSelain itu, luangkan waktu untuk melakukan hobi, berolahraga secara teratur, dan jangan ragu untuk berkonsultasi dengan profesional jika Anda merasa tekanan emosional sudah mulai mengganggu aktivitas sehari-hari.",
                'status' => 'published',
                'published_at' => now()->subDays(8),
                'thumbnail' => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'title' => 'Eksplorasi Keindahan Alam Labuan Bajo: Surga Tersembunyi di Indonesia Timur',
                'category_slug' => 'travel',
                'user_id' => $user->id,
                'excerpt' => 'Dari menyaksikan keagungan komodo hingga menikmati pemandangan matahari terbenam dari puncak Pulau Padar, Labuan Bajo menawarkan petualangan tiada tanding.',
                'content' => "Labuan Bajo telah berkembang pesat dari sebuah desa nelayan kecil menjadi salah satu destinasi wisata super prioritas terpopuler di Indonesia. Terletak di ujung barat Pulau Flores, tempat ini adalah gerbang menuju Taman Nasional Komodo yang menakjubkan.\n\nSelain melihat hewan purba komodo secara langsung di habitat aslinya, wisatawan juga disuguhi panorama laut bergradasi biru yang jernih, pantai berpasir merah muda (Pink Beach), serta perbukitan savana yang fotogenik.\n\nBagi pecinta selam, Labuan Bajo juga menyimpan kekayaan bawah laut yang luar biasa dengan keanekaragaman terumbu karang dan biota laut berukuran raksasa seperti ikan pari manta.",
                'status' => 'published',
                'published_at' => now()->subDays(10),
                'thumbnail' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'title' => 'Ide Artikel Baru: Tren Desain Web Minimalis di Era Interaksi Mikro',
                'category_slug' => 'technology',
                'user_id' => $user->id,
                'excerpt' => 'Artikel draf awal yang membahas tren visual terbaru dari antarmuka aplikasi web modern berbasis micro-interactions.',
                'content' => "Ini adalah draf kasar artikel tentang tren desain web terbaru.\n\nDengan semakin pendeknya perhatian pengguna, desainer web modern harus berfokus pada kesederhanaan visual yang dipadukan dengan interaksi mikro yang halus namun responsif.\n\nTren warna tahun ini didominasi oleh palet warna gelap berpadu dengan aksen neon bergradasi tipis.",
                'status' => 'draft',
                'published_at' => null,
                'thumbnail' => 'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'title' => 'Bagaimana Cara Membangun Kebiasaan Membaca Buku Setiap Hari?',
                'category_slug' => 'lifestyle',
                'user_id' => $user->id,
                'excerpt' => 'Artikel pending verifikasi yang menunggu ulasan admin. Membagikan tips praktis bagi pemula untuk menumbuhkan minat membaca secara konsisten.',
                'content' => "Banyak orang mengeluh tidak punya waktu untuk membaca buku. Padahal, kuncinya bukanlah memiliki waktu luang yang banyak, melainkan membangun kebiasaan membaca secara konsisten.\n\nMulailah dengan target kecil, misalnya membaca 5 hingga 10 halaman saja setiap hari sebelum tidur. Pilihlah topik buku yang benar-benar menarik minat Anda agar proses membaca terasa menyenangkan dan bukan beban.",
                'status' => 'pending',
                'published_at' => null,
                'thumbnail' => 'https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?auto=format&fit=crop&w=800&q=80',
            ]
        ];

        foreach ($articles as $art) {
            $cat = Category::where('slug', $art['category_slug'])->first();

            if ($cat) {
                Article::create([
                    'category_id' => $cat->id,
                    'user_id' => $art['user_id'],
                    'title' => $art['title'],
                    'slug' => Str::slug($art['title']),
                    'excerpt' => $art['excerpt'],
                    'content' => $art['content'],
                    'status' => $art['status'],
                    'published_at' => $art['published_at'],
                    'thumbnail' => $art['thumbnail'],
                ]);
            }
        }
    }
}
