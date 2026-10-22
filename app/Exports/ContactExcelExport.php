<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ContactExcelExport implements FromCollection, WithHeadings
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
            'Sparkasse',
            'Datum',
            'Erfasser',
            'Betreff',
        ];
    }

    public function collection()
    {
        return $this->data->map(function ($contact) {
            return array_values([
                $contact->customer->name,
                $contact->date->format('d.m.Y'),
                $contact->user->name,
                $contact->title,
            ]);
        });

    }
}
