<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Division;
use App\Models\CustomerType;
use App\Models\Guarantor;
use Carbon\Carbon;

class CustomerSampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample first names
        $firstNames = [
            'Amara', 'Buddhika', 'Chamara', 'Dilshan', 'Eranda', 'Fathima', 'Gayani', 'Hasitha', 'Indika', 'Jayani',
            'Kasun', 'Lakshmi', 'Mahesh', 'Nimal', 'Oshani', 'Prasad', 'Qadira', 'Ravi', 'Sanduni', 'Thilina',
            'Udara', 'Vindya', 'Wasantha', 'Ximena', 'Yasmin', 'Zoysa', 'Ashan', 'Bhagya', 'Chathura', 'Danushka',
            'Eshani', 'Gayan', 'Hiruni', 'Isuru', 'Janaka', 'Kamal', 'Lasantha', 'Malka', 'Nayana', 'Oshadha',
            'Priyanka', 'Rashmi', 'Saman', 'Tharuka', 'Upul', 'Vindika', 'Wimal', 'Yashodha', 'Zara', 'Anura',
            'Bimali', 'Charith', 'Deepika', 'Eshan', 'Gayathri', 'Harsha', 'Iresha', 'Jagath', 'Kumudu', 'Lalith',
            'Manjula', 'Nalaka', 'Olivia', 'Palitha', 'Roshan', 'Samanthi', 'Tharindu', 'Uditha', 'Vihanga', 'Waruna',
            'Yohan', 'Zehra', 'Asoka', 'Buddhi', 'Chandra', 'Dilan', 'Evani', 'Gihan', 'Harini', 'Irfan'
        ];

        // Sample last names
        $lastNames = [
            'Silva', 'Fernando', 'Perera', 'De Silva', 'Jayawardena', 'Wijesinghe', 'Rajapaksa', 'Gunasekara', 'Mendis', 'Wickramasinghe',
            'Jayasuriya', 'Bandara', 'Ranasinghe', 'Dissanayake', 'Kumarasinghe', 'Amarasinghe', 'Liyanage', 'Rathnayake', 'Senanayake', 'Abeysekara',
            'Weerasinghe', 'Karunaratne', 'Dharmasena', 'Wijekoon', 'Samarasinghe', 'Gunawardena', 'Madushanka', 'Ratnayake', 'Herath', 'Kumara',
            'Pathirana', 'Abeyratne', 'Balasuriya', 'Chandrasena', 'Dayaratne', 'Edirisinghe', 'Fonseka', 'Gamage', 'Hapuarachchi', 'Illesinghe',
            'Jayaratne', 'Kanchana', 'Lakmal', 'Malalasekara', 'Nanayakkara', 'Opatha', 'Peiris', 'Quintus', 'Rodrigo', 'Siriwardena',
            'Tennakoon', 'Udarata', 'Vithanage', 'Warnakula', 'Yaparatne', 'Zoysa', 'Alwis', 'Bogollagama', 'Coonghe', 'Dalugama'
        ];

        // Sample cities in Sri Lanka
        $cities = [
            'Colombo', 'Kandy', 'Galle', 'Negombo', 'Anuradhapura', 'Polonnaruwa', 'Trincomalee', 'Batticaloa', 'Jaffna', 'Kurunegala',
            'Ratnapura', 'Badulla', 'Bandarawela', 'Chilaw', 'Dambulla', 'Ella', 'Gampaha', 'Hambantota', 'Kalutara', 'Matara',
            'Monaragala', 'Nuwara Eliya', 'Panadura', 'Puttalam', 'Sigiriya', 'Tangalle', 'Vavuniya', 'Weligama', 'Yala', 'Ampara',
            'Avissawella', 'Beruwala', 'Embilipitiya', 'Haputale', 'Kegalle', 'Maharagama', 'Nawalapitiya', 'Piliyandala', 'Tissamaharama'
        ];

        // Sample addresses
        $addressTypes = [
            'No. {number}, {street} Road', 'No. {number}/{letter}, {street} Lane', '{number}, {street} Gardens',
            'No. {number}, {street} Place', '{number}/{letter}, {street} Avenue', 'No. {number}, New {street} Road',
            '{number}, Old {street} Road', 'No. {number}, {street} Mawatha', '{number}, {street} Junction'
        ];

        $streetNames = [
            'Galle', 'Kandy', 'Main', 'Hospital', 'School', 'Temple', 'Market', 'Station', 'Beach', 'Hill',
            'Lake', 'River', 'Park', 'Garden', 'Central', 'New', 'Old', 'Church', 'Mosque', 'Police',
            'Post Office', 'Bank', 'University', 'College', 'Stadium', 'Library', 'Cinema', 'Shopping',
            'Industrial', 'Commercial', 'Residential', 'Government', 'Provincial', 'Municipal'
        ];

        // Get divisions and customer types
        $divisions = Division::all();
        $customerTypes = CustomerType::all();
        $guarantors = Guarantor::all();

        if ($divisions->isEmpty() || $customerTypes->isEmpty()) {
            $this->command->error('Please ensure divisions and customer types exist before running this seeder.');
            return;
        }

        $this->command->info('Creating 120 sample customers...');

        for ($i = 1; $i <= 120; $i++) {
            // Random personal details
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            $title = ['Mr', 'Mrs', 'Miss', 'Ms', 'Dr'][array_rand(['Mr', 'Mrs', 'Miss', 'Ms', 'Dr'])];
            
            // Generate phone numbers
            $phone = '071' . str_pad(rand(1000000, 9999999), 7, '0', STR_PAD_LEFT);
            $phoneTwo = rand(0, 1) ? '077' . str_pad(rand(1000000, 9999999), 7, '0', STR_PAD_LEFT) : null;
            
            // Generate email
            $email = rand(0, 1) ? strtolower($firstName . '.' . $lastName . '@' . ['gmail.com', 'yahoo.com', 'hotmail.com', 'outlook.com'][array_rand(['gmail.com', 'yahoo.com', 'hotmail.com', 'outlook.com'])]) : null;
            
            // Generate NIC (National Identity Card)
            $nic = rand(0, 1) ? (rand(100000000, 999999999) . 'V') : null;
            
            // Generate EPF number
            $epf = rand(0, 1) ? 'EPF' . str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT) : null;
            
            // Generate address
            $city = $cities[array_rand($cities)];
            $streetName = $streetNames[array_rand($streetNames)];
            $addressTemplate = $addressTypes[array_rand($addressTypes)];
            $address = str_replace(
                ['{number}', '{letter}', '{street}'],
                [rand(1, 999), chr(rand(65, 90)), $streetName],
                $addressTemplate
            ) . ', ' . $city;
            
            // Generate postal code
            $postalCode = str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT);
            
            // Random division and customer type
            $division = $divisions->random();
            $customerType = $customerTypes->random();
            
            // Random guarantor (50% chance)
            $guarantorId = $guarantors->isNotEmpty() && rand(0, 1) ? $guarantors->random()->id : null;
            
            // Random connection date (last 5 years)
            $connectionDate = Carbon::now()->subYears(5)->addDays(rand(0, 1825));
            
            // Random deposit amount
            $depositAmount = [0, 500, 1000, 1500, 2000, 2500, 3000, 5000][array_rand([0, 500, 1000, 1500, 2000, 2500, 3000, 5000])];
            
            // Random billing settings
            $billingDay = rand(1, 28); // Avoid month-end issues for samples
            $autoBillingEnabled = rand(0, 10) > 1; // 90% chance enabled
            
            // Generate meter number
            $meterNumber = 'WM' . str_pad($i, 6, '0', STR_PAD_LEFT);
            
            // Random notes
            $notes = rand(0, 1) ? [
                'Regular customer, prompt payments',
                'Prefers monthly billing',
                'Large family, high consumption',
                'Business premises',
                'Senior citizen discount applicable',
                'New connection, monitor usage',
                'Apartment complex - shared meter',
                'Seasonal residence',
                'Industrial usage',
                'Commercial establishment'
            ][array_rand([
                'Regular customer, prompt payments',
                'Prefers monthly billing',
                'Large family, high consumption',
                'Business premises',
                'Senior citizen discount applicable',
                'New connection, monitor usage',
                'Apartment complex - shared meter',
                'Seasonal residence',
                'Industrial usage',
                'Commercial establishment'
            ])] : null;

            // Create customer
            $customer = Customer::create([
                'meter_number' => $meterNumber,
                'title' => $title,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'phone' => $phone,
                'phone_two' => $phoneTwo,
                'nic' => $nic,
                'epf_number' => $epf,
                'address' => $address,
                'city' => $city,
                'postal_code' => $postalCode,
                'status' => ['active', 'active', 'active', 'active', 'inactive'][array_rand(['active', 'active', 'active', 'active', 'inactive'])], // 80% active
                'customer_type_id' => $customerType->id,
                'division_id' => $division->id,
                'guarantor_id' => $guarantorId,
                'connection_date' => $connectionDate,
                'deposit_amount' => $depositAmount,
                'notes' => $notes,
                'billing_day' => $billingDay,
                'auto_billing_enabled' => $autoBillingEnabled,
            ]);

            // Progress indicator
            if ($i % 20 == 0) {
                $this->command->info("Created {$i} customers...");
            }
        }

        $this->command->info('✅ Successfully created 120 sample customers with billing settings!');
        $this->command->info('📊 Summary:');
        $this->command->info('   - Customers with auto-billing enabled: ' . Customer::where('auto_billing_enabled', true)->count());
        $this->command->info('   - Active customers: ' . Customer::where('status', 'active')->count());
        $this->command->info('   - Customers with guarantors: ' . Customer::whereNotNull('guarantor_id')->count());
        $this->command->info('   - Average billing day: ' . Customer::avg('billing_day'));
    }
}
