<?php


namespace App\Exports;


use App\Enums\Variables;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerExcelExport implements WithHeadings, FromCollection
{
    use Exportable;

    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function headings(): array
    {
        return [
            'Institut',
            'Verband',
            'Bankleitzahl',
            'BIC',
            'Gesamtbudget',
            'Verfügbares Budget',
            'Verbrauchtes Budget',
        ];
    }

    // ...

    // ...

    public function collection()
    {
        $rows = [];

        foreach ($this->data as $customer) {
            $measuresArray = [];

            foreach ($customer->measures()->get() as $customerMeasure) {
                $measureName = $customerMeasure->measure->name;
                $measureStatus = Variables::$measuresStates['states'][$customerMeasure->state]['name'];
                $measuresArray[] = $measureName . ', Status: ' . $measureStatus;
            }

            $measuresString = implode('; ', $measuresArray);

            $rows[] = [
                $customer->name,
                $customer->association->short_name,
                $customer->blz,
                $customer->bic,
                $customer->sumPositiveBudgets(),
                $customer->sumBudgets(),
                str_replace('-', '', $customer->sumNegativeBudgets()),
            ];
        }

        return collect($rows);
    }

// ...



}
