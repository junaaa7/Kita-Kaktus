<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        // Ambil email dari .env, fallback ke default jika tidak ada
        $superAdminEmail = env('SUPER_ADMIN_EMAIL', 'admin@kitakaktus.com');
        $superAdminName = env('SUPER_ADMIN_NAME', 'Super Admin');
        
        $admin = User::where('email', $superAdminEmail)->first();
        
        if ($admin) {
            // Update user existing menjadi super admin
            $admin->update([
                'role' => 'admin',
                'is_super_admin' => true,
            ]);
            $this->command->info("Super admin berhasil diupdate: {$superAdminEmail}");
        } else {
            // Buat super admin baru
            User::create([
                'name' => $superAdminName,
                'email' => $superAdminEmail,
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'is_super_admin' => true,
            ]);
            $this->command->info("Super admin baru berhasil dibuat: {$superAdminEmail}");
        }
    }
}