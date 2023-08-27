<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ImportData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import master data from CSV files';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $this->info('Importing master data...');

        $customerData = Storage::get('customers.csv');
        $productData = Storage::get('products.csv');

        $customerCsvRows = explode("\n", $customerData);
        $productCsvRows = explode("\n", $productData);
        
        $importedCustomers = 0;
        $importedProducts = 0;

        foreach ($customerCsvRows as $key => $row) {
            if($key == 0){
                continue;
            }
            $data = str_getcsv($row);
            if (count($data) === 6) {
                Customer::create([
                    'job_title' => $data[1],
                    'email' => $data[2],
                    'first_name_last_name' => $data[3],
                    'registered_since' => $data[4],
                    'phone' => $data[5],
                ]);
                $importedCustomers++;
            } else {
                Log::error('Invalid customer data: ' . $row);
            }
        }

        foreach ($productCsvRows as $key => $row) {
            if($key == 0){
                continue;
            }
            $data = str_getcsv($row);
            if (count($data) === 3) {
                
                Product::create([
                    'productname' => $data[1],
                    'price' => $data[2],
                ]);
                $importedProducts++;
            } else {
                Log::error('Invalid product data: ' . $row);
            }
        }

        $this->info('Data imported successfully.');
        $this->info("Imported customers: $importedCustomers");
        $this->info("Imported products: $importedProducts");

        return Command::SUCCESS;
    }
}
