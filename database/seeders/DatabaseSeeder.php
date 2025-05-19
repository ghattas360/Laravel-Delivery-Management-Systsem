<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RegionSeeder::class,
            AddressSeeder::class,
            ClientSeeder::class,
            DriverSeeder::class,
            EmployeeSeeder::class,
            PackageSeeder::class,
            DeliverySeeder::class,
            PaymentSeeder::class,
            ReviewSeeder::class,
            AvailabilitySeeder::class,
            SocialMediaAccountSeeder::class,
            AvailabilityRegionSeeder::class,
            ClientAddressSeeder::class,
            ShiftSeeder::class,
        ]);
    }
}