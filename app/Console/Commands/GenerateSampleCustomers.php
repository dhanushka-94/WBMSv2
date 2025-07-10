<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use App\Models\Customer;

class GenerateSampleCustomers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customers:generate-samples {--reset : Delete existing customers first} {--count=120 : Number of customers to create}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sample customers for testing the billing system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = $this->option('count');
        $reset = $this->option('reset');

        if ($reset) {
            if ($this->confirm('This will delete ALL existing customers. Are you sure?')) {
                $this->info('Deleting existing customers...');
                Customer::query()->delete();
                $this->info('✅ Existing customers deleted.');
            } else {
                $this->info('Operation cancelled.');
                return;
            }
        }

        $existingCount = Customer::count();
        if ($existingCount > 0 && !$reset) {
            $this->info("Found {$existingCount} existing customers.");
            if (!$this->confirm("Continue and add {$count} more customers?")) {
                $this->info('Operation cancelled.');
                return;
            }
        }

        $this->info("Generating {$count} sample customers...");
        
        // Run the seeder
        Artisan::call('db:seed', ['--class' => 'CustomerSampleSeeder']);
        
        $newTotal = Customer::count();
        $autoEnabled = Customer::where('auto_billing_enabled', true)->count();
        $activeCustomers = Customer::where('status', 'active')->count();
        
        $this->info('✅ Sample customers generated successfully!');
        $this->info('📊 Current Statistics:');
        $this->info("   - Total Customers: {$newTotal}");
        $this->info("   - Auto-billing Enabled: {$autoEnabled}");
        $this->info("   - Active Customers: {$activeCustomers}");
        $this->info("   - Inactive Customers: " . ($newTotal - $activeCustomers));
        
        $this->info('🔗 Next Steps:');
        $this->info('   1. Visit: http://127.0.0.1:8000/settings/billing');
        $this->info('   2. Test bulk billing date updates');
        $this->info('   3. View customer list at: http://127.0.0.1:8000/customers');
    }
}
