<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ebook;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;

class EbookSeeder extends Seeder
{
    public function run(): void
    {
        $penjual    = User::where('role', 'penjual')->first();
        $teknologi  = Category::where('slug', 'teknologi')->first();
        $bisnis     = Category::where('slug', 'bisnis')->first();
        $desain     = Category::where('slug', 'desain')->first();
        $pemrograman = Category::where('slug', 'pemrograman')->first();

        $ebooks = [
            [
                'title'       => 'Machine Learning dengan Python',
                'description' => 'Panduan lengkap belajar Machine Learning menggunakan Python. Mulai dari regresi linier, klasifikasi, hingga neural network sederhana dengan contoh kode nyata.',
                'price'       => 75000,
                'category_id' => $teknologi->id,
            ],
            [
                'title'       => 'Panduan Desain UI/UX Modern',
                'description' => 'Pelajari prinsip desain UI/UX modern yang digunakan oleh designer profesional. Dari wireframing, prototyping, hingga design system.',
                'price'       => 55000,
                'category_id' => $desain->id,
            ],
            [
                'title'       => 'Sukses Bisnis Online dari Nol',
                'description' => 'Strategi membangun bisnis online yang profitable dari nol. Meliputi riset pasar, branding, digital marketing, hingga scaling bisnis.',
                'price'       => 49000,
                'category_id' => $bisnis->id,
            ],
            [
                'title'       => 'Laravel untuk Web Developer',
                'description' => 'Kuasai Laravel framework PHP terpopuler. Dari routing, MVC, Eloquent ORM, hingga deployment production.',
                'price'       => 85000,
                'category_id' => $pemrograman->id,
            ],
            [
                'title'       => 'Flutter dari Nol sampai Mahir',
                'description' => 'Belajar membuat aplikasi mobile cross-platform dengan Flutter. Dilengkapi dengan contoh proyek nyata dan best practices.',
                'price'       => 65000,
                'category_id' => $teknologi->id,
            ],
            [
                'title'       => 'Digital Marketing Strategy 2026',
                'description' => 'Strategi digital marketing terkini untuk mengembangkan bisnis di era digital. SEO, Social Media, Email Marketing, dan Paid Ads.',
                'price'       => 59000,
                'category_id' => $bisnis->id,
            ],
        ];

        foreach ($ebooks as $data) {
            // Buat file PDF dummy di private storage
            $filename = 'ebooks/' . Str::random(20) . '.pdf';
            \Storage::disk('private')->put($filename, '%PDF-1.4 dummy content');

            Ebook::create([
                'seller_id'   => $penjual->id,
                'category_id' => $data['category_id'],
                'title'       => $data['title'],
                'slug'        => Str::slug($data['title']) . '-' . Str::random(5),
                'description' => $data['description'],
                'price'       => $data['price'],
                'cover'       => null,
                'file'        => $filename,
                'status'      => 'aktif',
            ]);
        }
    }
}