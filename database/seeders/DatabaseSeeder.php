<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin Kita Kaktus',
            'email' => 'admin@kitakaktus.com',
            'password' => Hash::make('password123'),
            'role' => 'admin'
        ]);

        // Create regular user
        User::create([
            'name' => 'User Biasa',
            'email' => 'user@kitakaktus.com',
            'password' => Hash::make('password123'),
            'role' => 'user'
        ]);

        // Create categories
        $categories = [
            ['name' => 'Kaktus Mini', 'slug' => 'kaktus-mini', 'description' => 'Kaktus ukuran kecil untuk meja'],
            ['name' => 'Kaktus Medium', 'slug' => 'kaktus-medium', 'description' => 'Kaktus ukuran sedang untuk ruangan'],
            ['name' => 'Kaktus Besar', 'slug' => 'kaktus-besar', 'description' => 'Kaktus ukuran besar untuk taman'],
            ['name' => 'Kaktus Langka', 'slug' => 'kaktus-langka', 'description' => 'Koleksi kaktus langka dan eksotis'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create sample products
        $products = [
            [
                'name' => 'Echinocactus Grusonii',
                'slug' => 'echinocactus-grusonii',
                'description' => 'Kaktus berbentuk bulat dengan duri berwarna keemasan. Sangat populer sebagai tanaman hias. Perawatannya mudah dan tahan terhadap berbagai kondisi.',
                'price' => 150000,
                'stock' => 10,
                'category_id' => 2,
                'image' => null
            ],
            [
                'name' => 'Astrophytum Asterias',
                'slug' => 'astrophytum-asterias',
                'description' => 'Kaktus berbentuk bintang dengan permukaan yang halus tanpa duri. Sangat langka dan diminati kolektor.',
                'price' => 250000,
                'stock' => 5,
                'category_id' => 4,
                'image' => null
            ],
            [
                'name' => 'Mammillaria Elongata',
                'slug' => 'mammillaria-elongata',
                'description' => 'Kaktus dengan bentuk memanjang seperti jari, cocok untuk koleksi mini. Mudah berkembang biak.',
                'price' => 75000,
                'stock' => 20,
                'category_id' => 1,
                'image' => null
            ],
            [
                'name' => 'Opuntia Microdasys',
                'slug' => 'opuntia-microdasys',
                'description' => 'Kaktus berbentuk telinga kelinci dengan duri halus berwarna putih. Sangat unik dan menarik.',
                'price' => 120000,
                'stock' => 15,
                'category_id' => 2,
                'image' => null
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}