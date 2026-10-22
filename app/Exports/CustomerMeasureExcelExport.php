<?php


namespace App\Exports;


use App\Models\Customer;
use App\Models\Measures;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerMeasureExcelExport implements WithHeadings, FromArray, WithCustomCsvSettings
{
    use Exportable;

    private $data;

    public function __construct(Measures $measure)
    {

        if(in_array(0, $measure->customer_ids))
        {
            $customers = \App\Models\Customer::all();
        }
        else
        {
            $customers = Customer::whereIn('id', $measure->customer_ids)->get();
        }
        foreach ($customers as $customer) {
            $this->data[] = [
                $customer->name,
                $measure->excelExportMeasureState($customer->id),
                $measure->customerMeasure($customer->id) ? $measure->customerMeasure($customer->id)->causer()->name : ' - ',
                !empty($measure->from) ? $measure->from->format('d.m.Y') : '- keine Angabe -',
                !empty($measure->to) ? $measure->to->format('d.m.Y') : '- keine Angabe -',
                $measure->incentivization == 1 ? 'Ja' : 'Nein',
                $measure->coupons == 1 ? 'Ja' : 'Nein',
            ];
        }
    }

    public function headings(): array
    {
        return [
            'Sparkasse',
            'Status',
            'anmeldende Person',
            'Start-Datum',
            'End-Datum',
            'Incentivierung',
            'Coupons',
        ];
    }

    public function array(): array
    {
        return $this->data;
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';',
            'input_encoding' => 'UTF-8',
        ];
    }
}
