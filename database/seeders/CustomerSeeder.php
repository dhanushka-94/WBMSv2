<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Division;
use App\Models\CustomerType;
use App\Models\Guarantor;
use Carbon\Carbon;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all divisions and customer types
        $divisions = Division::all();
        $customerTypes = CustomerType::all();
        $guarantors = Guarantor::all();

        // Sample Sri Lankan names and data
        $sampleCustomers = [
            [
                'title' => 'Mr',
                'first_name' => 'Kumara',
                'last_name' => 'Silva',
                'email' => 'kumara.silva@email.com',
                'phone' => '0771234567',
                'phone_two' => '0112345678',
                'nic' => '198012345671',
                'epf_number' => 'EPF001234',
                'address' => 'No. 123, Galle Road, Colombo 03',
                'city' => 'Colombo',
                'postal_code' => '00300',
                'status' => 'active',
                'deposit_amount' => 5000.00,
                'notes' => 'Regular customer, prompt payments'
            ],
            [
                'title' => 'Mrs',
                'first_name' => 'Nimal',
                'last_name' => 'Perera',
                'email' => 'nimal.perera@email.com',
                'phone' => '0712345678',
                'phone_two' => '0332234567',
                'nic' => '197523456782',
                'epf_number' => 'EPF002345',
                'address' => 'No. 45, Kandy Road, Peradeniya',
                'city' => 'Kandy',
                'postal_code' => '20400',
                'status' => 'active',
                'deposit_amount' => 3500.00,
                'notes' => 'Commercial property owner'
            ],
            [
                'title' => 'Miss',
                'first_name' => 'Chamari',
                'last_name' => 'Fernando',
                'email' => 'chamari.fernando@email.com',
                'phone' => '0773456789',
                'phone_two' => '0112876543',
                'nic' => '198567890123',
                'epf_number' => 'EPF003456',
                'address' => 'No. 78, Temple Road, Nugegoda',
                'city' => 'Nugegoda',
                'postal_code' => '10250',
                'status' => 'active',
                'deposit_amount' => 4000.00,
                'notes' => 'New connection'
            ],
            [
                'title' => 'Mr',
                'first_name' => 'Rajitha',
                'last_name' => 'Wickramasinghe',
                'email' => 'rajitha.w@email.com',
                'phone' => '0754567890',
                'phone_two' => '0332567890',
                'nic' => '197834567891',
                'epf_number' => 'EPF004567',
                'address' => 'No. 56, Main Street, Gampaha',
                'city' => 'Gampaha',
                'postal_code' => '11000',
                'status' => 'active',
                'deposit_amount' => 2500.00
            ],
            [
                'title' => 'Dr',
                'first_name' => 'Sunil',
                'last_name' => 'Bandara',
                'email' => 'dr.sunil@email.com',
                'phone' => '0765432109',
                'phone_two' => '0112987654',
                'nic' => '196745678912',
                'epf_number' => 'EPF005678',
                'address' => 'No. 234, Hospital Road, Kandy',
                'city' => 'Kandy',
                'postal_code' => '20000',
                'status' => 'active',
                'deposit_amount' => 7500.00,
                'notes' => 'Medical professional'
            ],
            [
                'title' => 'Mrs',
                'first_name' => 'Malini',
                'last_name' => 'Jayawardena',
                'email' => 'malini.j@email.com',
                'phone' => '0776543210',
                'phone_two' => '0372345678',
                'nic' => '198234567823',
                'epf_number' => 'EPF006789',
                'address' => 'No. 67, Lake View Road, Nuwara Eliya',
                'city' => 'Nuwara Eliya',
                'postal_code' => '22200',
                'status' => 'active',
                'deposit_amount' => 6000.00
            ],
            [
                'title' => 'Mr',
                'first_name' => 'Pradeep',
                'last_name' => 'Rathnayake',
                'email' => 'pradeep.r@email.com',
                'phone' => '0787654321',
                'phone_two' => '0452345678',
                'nic' => '199045678934',
                'epf_number' => 'EPF007890',
                'address' => 'No. 89, Industrial Zone, Katunayake',
                'city' => 'Katunayake',
                'postal_code' => '11450',
                'status' => 'active',
                'deposit_amount' => 15000.00,
                'notes' => 'Industrial customer'
            ],
            [
                'title' => 'Ms',
                'first_name' => 'Shalini',
                'last_name' => 'Gunaratne',
                'email' => 'shalini.g@email.com',
                'phone' => '0798765432',
                'phone_two' => '0912345678',
                'nic' => '199156789045',
                'epf_number' => 'EPF008901',
                'address' => 'No. 45, Beach Road, Negombo',
                'city' => 'Negombo',
                'postal_code' => '11500',
                'status' => 'active',
                'deposit_amount' => 4500.00
            ],
            [
                'title' => 'Mr',
                'first_name' => 'Asanka',
                'last_name' => 'Mendis',
                'email' => 'asanka.mendis@email.com',
                'phone' => '0709876543',
                'phone_two' => '0472345678',
                'nic' => '198767890156',
                'epf_number' => 'EPF009012',
                'address' => 'No. 123, Hill Street, Badulla',
                'city' => 'Badulla',
                'postal_code' => '90000',
                'status' => 'suspended',
                'deposit_amount' => 3000.00,
                'notes' => 'Payment issues, suspended temporarily'
            ],
            [
                'title' => 'Mrs',
                'first_name' => 'Deepika',
                'last_name' => 'Senaratne',
                'email' => 'deepika.s@email.com',
                'phone' => '0719876543',
                'phone_two' => '0552345678',
                'nic' => '199278901267',
                'epf_number' => 'EPF010123',
                'address' => 'No. 78, Central Road, Matara',
                'city' => 'Matara',
                'postal_code' => '81000',
                'status' => 'active',
                'deposit_amount' => 3500.00
            ],
            [
                'title' => 'Mr',
                'first_name' => 'Roshan',
                'last_name' => 'Wijesinghe',
                'email' => 'roshan.w@email.com',
                'phone' => '0729876543',
                'nic' => '199389012378',
                'address' => 'No. 234, Factory Lane, Kurunegala',
                'city' => 'Kurunegala',
                'postal_code' => '60000',
                'status' => 'active',
                'deposit_amount' => 8000.00
            ],
            [
                'title' => 'Miss',
                'first_name' => 'Tharanga',
                'last_name' => 'Jayasuriya',
                'email' => 'tharanga.j@email.com',
                'phone' => '0739876543',
                'phone_two' => '0632345678',
                'nic' => '199490123489',
                'address' => 'No. 56, School Lane, Anuradhapura',
                'city' => 'Anuradhapura',
                'postal_code' => '50000',
                'status' => 'active',
                'deposit_amount' => 2000.00
            ],
            [
                'title' => 'Mr',
                'first_name' => 'Dinesh',
                'last_name' => 'Kodikara',
                'email' => 'dinesh.k@email.com',
                'phone' => '0749876543',
                'nic' => '198501234590',
                'address' => 'No. 167, Market Street, Ratnapura',
                'city' => 'Ratnapura',
                'postal_code' => '70000',
                'status' => 'active',
                'deposit_amount' => 4200.00
            ],
            [
                'title' => 'Mrs',
                'first_name' => 'Sandya',
                'last_name' => 'Weerasinghe',
                'email' => 'sandya.w@email.com',
                'phone' => '0759876543',
                'phone_two' => '0412345678',
                'nic' => '197612345601',
                'address' => 'No. 89, Temple Road, Jaffna',
                'city' => 'Jaffna',
                'postal_code' => '40000',
                'status' => 'active',
                'deposit_amount' => 3800.00
            ],
            [
                'title' => 'Mr',
                'first_name' => 'Chatura',
                'last_name' => 'Dissanayake',
                'email' => 'chatura.d@email.com',
                'phone' => '0769876543',
                'nic' => '199723456712',
                'address' => 'No. 45, River View, Polonnaruwa',
                'city' => 'Polonnaruwa',
                'postal_code' => '51000',
                'status' => 'inactive',
                'deposit_amount' => 1500.00,
                'notes' => 'Moved to different area'
            ]
        ];

        // Additional names and data for more customers
        $firstNames = [
            'Kamal', 'Saman', 'Ranjan', 'Wasantha', 'Udaya', 'Aruna', 'Gamini', 'Ravi',
            'Lalith', 'Tilak', 'Anura', 'Mahinda', 'Sarath', 'Nanda', 'Upul', 'Ajith',
            'Ruwan', 'Jagath', 'Sampath', 'Chandana', 'Indika', 'Thilak', 'Wimal', 'Suranga',
            'Pramila', 'Chandra', 'Kamala', 'Sriyani', 'Dayani', 'Kumari', 'Rohini', 'Shirani',
            'Wasana', 'Niluka', 'Dilrukshi', 'Menuka', 'Rashika', 'Damayanthi', 'Sewwandi'
        ];

        $lastNames = [
            'Silva', 'Perera', 'Fernando', 'Wickramasinghe', 'Bandara', 'Jayawardena', 'Rathnayake',
            'Gunaratne', 'Mendis', 'Senaratne', 'Wijesinghe', 'Jayasuriya', 'Kodikara', 'Weerasinghe',
            'Dissanayake', 'Gunasekara', 'Rajapakse', 'Amarasinghe', 'Abeysekara', 'Ranasinghe',
            'Kumarasinghe', 'Madushanka', 'Karunaratne', 'Liyanage', 'Senanayake', 'Abeywardena'
        ];

        $cities = [
            'Colombo', 'Kandy', 'Galle', 'Matara', 'Jaffna', 'Negombo', 'Kurunegala', 'Anuradhapura',
            'Polonnaruwa', 'Ratnapura', 'Badulla', 'Nuwara Eliya', 'Kalutara', 'Gampaha', 'Kegalle',
            'Puttalam', 'Hambantota', 'Vavuniya', 'Batticaloa', 'Ampara', 'Trincomalee', 'Monaragala'
        ];

        $addresses = [
            'No. %d, Main Street', 'No. %d, Galle Road', 'No. %d, Kandy Road', 'No. %d, Temple Road',
            'No. %d, School Lane', 'No. %d, Hospital Road', 'No. %d, Market Street', 'No. %d, Lake View Road',
            'No. %d, Hill Street', 'No. %d, Beach Road', 'No. %d, River View', 'No. %d, Park Avenue',
            'No. %d, Garden Street', 'No. %d, Station Road', 'No. %d, Church Lane', 'No. %d, Castle Street'
        ];

        echo "Creating sample customers...\n";

        // Create the predefined customers first
        foreach ($sampleCustomers as $index => $customerData) {
            $division = $divisions->random();
            $customerType = $customerTypes->random();
            $guarantor = $guarantors->random();

            $customer = Customer::create([
                'title' => $customerData['title'],
                'first_name' => $customerData['first_name'],
                'last_name' => $customerData['last_name'],
                'email' => $customerData['email'],
                'phone' => $customerData['phone'],
                'phone_two' => $customerData['phone_two'] ?? null,
                'nic' => $customerData['nic'],
                'epf_number' => $customerData['epf_number'] ?? null,
                'address' => $customerData['address'],
                'city' => $customerData['city'],
                'postal_code' => $customerData['postal_code'],
                'status' => $customerData['status'],
                'customer_type_id' => $customerType->id,
                'division_id' => $division->id,
                'guarantor_id' => $guarantor->id,
                'connection_date' => Carbon::now()->subDays(rand(30, 365)),
                'deposit_amount' => $customerData['deposit_amount'],
                'notes' => $customerData['notes'] ?? null,
                'meter_number' => 'WM' . str_pad($index + 1, 6, '0', STR_PAD_LEFT)
            ]);

            echo "Created customer: {$customer->full_name} ({$customer->account_number})\n";
        }

        // Generate additional customers to reach 50
        $remaining = 50 - count($sampleCustomers);
        
        for ($i = 0; $i < $remaining; $i++) {
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            $city = $cities[array_rand($cities)];
            $address = sprintf($addresses[array_rand($addresses)], rand(1, 999));
            $fullAddress = $address . ', ' . $city;
            
            $division = $divisions->random();
            $customerType = $customerTypes->random();
            $guarantor = $guarantors->random();

            $titles = ['Mr', 'Mrs', 'Miss', 'Ms', 'Dr'];
            $title = $titles[array_rand($titles)];
            
            // Generate unique NIC
            $nic = '19' . rand(70, 99) . rand(10000000, 99999999);
            
            // Generate phone numbers
            $phone = '077' . rand(1000000, 9999999);
            $phoneTwo = rand(0, 1) ? '011' . rand(1000000, 9999999) : null;
            
            // Generate email
            $email = strtolower($firstName . '.' . $lastName . rand(1, 99) . '@email.com');
            
            // Random status
            $statuses = ['active', 'active', 'active', 'active', 'suspended', 'inactive']; // More active
            $status = $statuses[array_rand($statuses)];
            
            $customer = Customer::create([
                'title' => $title,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'phone' => $phone,
                'phone_two' => $phoneTwo,
                'nic' => $nic,
                'epf_number' => rand(0, 1) ? 'EPF' . str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT) : null,
                'address' => $fullAddress,
                'city' => $city,
                'postal_code' => str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT),
                'status' => $status,
                'customer_type_id' => $customerType->id,
                'division_id' => $division->id,
                'guarantor_id' => $guarantor->id,
                'connection_date' => Carbon::now()->subDays(rand(1, 1000)),
                'deposit_amount' => rand(1000, 10000),
                'notes' => rand(0, 1) ? 'Auto-generated sample customer' : null,
                'meter_number' => 'WM' . str_pad(count($sampleCustomers) + $i + 1, 6, '0', STR_PAD_LEFT)
            ]);

            echo "Created customer: {$customer->full_name} ({$customer->account_number})\n";
        }

        echo "\n✅ Successfully created 50 sample customers!\n";
        echo "Total customers in database: " . Customer::count() . "\n";
    }
} 