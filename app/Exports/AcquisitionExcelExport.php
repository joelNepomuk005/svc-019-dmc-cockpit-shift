<?php


namespace App\Exports;


use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AcquisitionExcelExport implements WithHeadings, FromArray, WithCustomCsvSettings
{
    use Exportable;

    private $data;

    public function __construct($data)
    {
        foreach ($data as $acquisation) {
            $this->data[] = [
                $acquisation->id,
                $acquisation->customer->blz,
                $acquisation->customer->name,
                $acquisation->subject,
                $acquisation->activities,
                $acquisation->product->category->name,
                $acquisation->product->name,
                $acquisation->customer->association->name,
                $acquisation->customer->key_account->name,
                !empty($acquisation->done_until) ? $acquisation->done_until->format('d.m.Y') : '',
                !empty($acquisation->done_at) ? $acquisation->done_at->format('d.m.Y') : '',
                $acquisation->done == 1 ? 'erledigt' : 'offen',
            ];
        }
    }

    public function headings(): array
    {
        return [
            'ID',
            'BLZ',
            'Institut',
            'Thema',
            'Aktivität',
            'Produktkategorie',
            'Produkt',
            'Verband',
            'Berater',
            'zu erledigen bis',
            'Erledigungsdatum',
            'Status',
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
