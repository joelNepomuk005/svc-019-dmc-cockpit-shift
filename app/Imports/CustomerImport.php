<?php

namespace App\Imports;

use App\Models\Customer;
use App\Models\CustomerAssociation;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomerImport implements ToCollection, WithCustomCsvSettings, WithHeadingRow
{
    public function collection(Collection $collection)
    {
        foreach ($collection as $customer) {

            $customerAssociation = CustomerAssociation::where('short_name', $customer['verband'])->first();

            if (empty($customerAssociation)) {

                $customerAssociation = CustomerAssociation::create([
                    'name' => $customer['verband'],
                    'short_name' => $customer['verband'],
                ]);

            }
            $institute = Customer::where('blz', $customer['blz'])->first();

            if (empty($institute)) {

                $customers['insert'][] = Customer::create([
                    'blz' => $customer['blz'],
                    'bic' => $customer['bic'],
                    'name' => $customer['sparkasse'],
                    'long_name' => $customer['sparkasse'],
                    'association_id' => $customerAssociation->id,
                    'created_at' => Carbon::now()->format('d.m.Y'),
                ]);

            } else {

                $institute->update([
                    'bic' => $customer['bic'],
                    'name' => $customer['sparkasse'],
                    'long_name' => $customer['sparkasse'],
                    'association_id' => $customerAssociation->id,
                ]);

                $customers['update'][] = $institute;

            }
        }
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';',
            'line_ending' => "\n",
        ];
    }
}
