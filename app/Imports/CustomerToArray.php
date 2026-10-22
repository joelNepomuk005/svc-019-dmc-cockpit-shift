<?php

namespace App\Imports;

use App\Http\Controllers\Backend\CustomerController;
use App\Models\Customer;
use App\Models\CustomerAssociation;
use App\Models\CustomerContact;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomerToArray implements ToCollection
{

    public function collection(Collection $rows)
    {
    }
}
