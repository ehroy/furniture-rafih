<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class DeployProject extends Command
{
    protected $signature = 'deploy:project';
    protected $description = 'Deploy Laravel project with all required setups';

    public function handle()
    {
        $this->info("🚀 Starting deployment...");

        // 1. Jalankan Composer Install
        $this->info("📦 Running Composer Install...");
        shell_exec('composer install --no-interaction --prefer-dist');

        // 2. Copy .env jika belum ada
        if (!File::exists(base_path('.env'))) {
            $this->info("📄 Copying .env file...");
            File::copy(base_path('.env.example'), base_path('.env'));
        }

        // 3. Generate APP_KEY
        $this->info("🔑 Generating APP_KEY...");
        Artisan::call('key:generate');

        // 4. Buat Database SQLite jika belum ada
        $sqlitePath = database_path('database.sqlite');
        if (!File::exists($sqlitePath)) {
            $this->info("📂 Creating SQLite database...");
            File::put($sqlitePath, '');
        }

        // 5. Set Permission untuk Database & Storage
        $this->info("🔧 Setting permissions for SQLite & Storage...");
        shell_exec('chmod -R 775 database storage bootstrap/cache');
        shell_exec('chown -R www-data:www-data database storage bootstrap/cache');

        // 6. Set Permission untuk Log Laravel
        $this->info("🛠 Setting permissions for logs...");
        shell_exec('chmod -R 775 storage/logs');
        shell_exec('chown -R www-data:www-data storage/logs');

        // 7. Jalankan Migrasi dan Seeder
        $this->info("🛠 Running Migrations and Seeders...");
        Artisan::call('migrate --seed');

        // 8. Buat Storage Link
        $this->info("🔗 Creating storage symlink...");
        Artisan::call('storage:link');

        // 9. Bersihkan Cache
        $this->info("🧹 Clearing cache...");
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');

        $this->info("✅ Deployment completed successfully! 🎉");
    }
}
