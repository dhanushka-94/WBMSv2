<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rate;
use Carbon\Carbon;

class RateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing rates
        Rate::truncate();

        $effectiveDate = Carbon::now()->startOfMonth();

        // Residential Rates (Tiered Structure)
        $residentialRates = [
            [
                'name' => 'Residential - Basic (0-10 units)',
                'customer_type' => 'residential',
                'tier_from' => 0,
                'tier_to' => 10,
                'rate_per_unit' => 7.50,
                'fixed_charge' => 100.00,
                'description' => 'Basic residential rate for first 10 cubic meters'
            ],
            [
                'name' => 'Residential - Standard (11-20 units)',
                'customer_type' => 'residential',
                'tier_from' => 11,
                'tier_to' => 20,
                'rate_per_unit' => 15.00,
                'fixed_charge' => 100.00,
                'description' => 'Standard residential rate for 11-20 cubic meters'
            ],
            [
                'name' => 'Residential - High (21-30 units)',
                'customer_type' => 'residential',
                'tier_from' => 21,
                'tier_to' => 30,
                'rate_per_unit' => 25.00,
                'fixed_charge' => 100.00,
                'description' => 'High usage residential rate for 21-30 cubic meters'
            ],
            [
                'name' => 'Residential - Premium (31+ units)',
                'customer_type' => 'residential',
                'tier_from' => 31,
                'tier_to' => null,
                'rate_per_unit' => 35.00,
                'fixed_charge' => 100.00,
                'description' => 'Premium residential rate for usage above 30 cubic meters'
            ]
        ];

        // Commercial Rates (Tiered Structure)
        $commercialRates = [
            [
                'name' => 'Commercial - Basic (0-25 units)',
                'customer_type' => 'commercial',
                'tier_from' => 0,
                'tier_to' => 25,
                'rate_per_unit' => 20.00,
                'fixed_charge' => 250.00,
                'description' => 'Basic commercial rate for first 25 cubic meters'
            ],
            [
                'name' => 'Commercial - Standard (26-50 units)',
                'customer_type' => 'commercial',
                'tier_from' => 26,
                'tier_to' => 50,
                'rate_per_unit' => 30.00,
                'fixed_charge' => 250.00,
                'description' => 'Standard commercial rate for 26-50 cubic meters'
            ],
            [
                'name' => 'Commercial - High (51+ units)',
                'customer_type' => 'commercial',
                'tier_from' => 51,
                'tier_to' => null,
                'rate_per_unit' => 40.00,
                'fixed_charge' => 250.00,
                'description' => 'High usage commercial rate for usage above 50 cubic meters'
            ]
        ];

        // Industrial Rates (Tiered Structure)
        $industrialRates = [
            [
                'name' => 'Industrial - Basic (0-100 units)',
                'customer_type' => 'industrial',
                'tier_from' => 0,
                'tier_to' => 100,
                'rate_per_unit' => 25.00,
                'fixed_charge' => 500.00,
                'description' => 'Basic industrial rate for first 100 cubic meters'
            ],
            [
                'name' => 'Industrial - Standard (101-500 units)',
                'customer_type' => 'industrial',
                'tier_from' => 101,
                'tier_to' => 500,
                'rate_per_unit' => 35.00,
                'fixed_charge' => 500.00,
                'description' => 'Standard industrial rate for 101-500 cubic meters'
            ],
            [
                'name' => 'Industrial - High (501+ units)',
                'customer_type' => 'industrial',
                'tier_from' => 501,
                'tier_to' => null,
                'rate_per_unit' => 45.00,
                'fixed_charge' => 500.00,
                'description' => 'High usage industrial rate for usage above 500 cubic meters'
            ]
        ];

        // Combine all rates
        $allRates = array_merge($residentialRates, $commercialRates, $industrialRates);

        // Create rates
        foreach ($allRates as $rateData) {
            Rate::create([
                'name' => $rateData['name'],
                'customer_type' => $rateData['customer_type'],
                'tier_from' => $rateData['tier_from'],
                'tier_to' => $rateData['tier_to'],
                'rate_per_unit' => $rateData['rate_per_unit'],
                'fixed_charge' => $rateData['fixed_charge'],
                'is_active' => true,
                'effective_from' => $effectiveDate,
                'effective_to' => null,
                'description' => $rateData['description']
            ]);
        }

        $this->command->info('Water billing rates created successfully!');
        $this->command->info('Residential rates: 4 tiers (Rs. 7.50 - Rs. 35.00 per unit)');
        $this->command->info('Commercial rates: 3 tiers (Rs. 20.00 - Rs. 40.00 per unit)');
        $this->command->info('Industrial rates: 3 tiers (Rs. 25.00 - Rs. 45.00 per unit)');
        $this->command->info('All rates are active from: ' . $effectiveDate->format('Y-m-d'));
    }
}
