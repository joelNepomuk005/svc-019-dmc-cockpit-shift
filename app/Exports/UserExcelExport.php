<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExcelExport implements FromCollection, WithHeadings
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
            'S-Cockpit User',
            'Anrede',
            'Vorname',
            'Nachname',
            'E-Mail',
            'Telefon',
            'Sparkasse',
            'Verband',
            'BLZ',
        ];
    }

    public function collection()
    {
        return $this->data->map(function ($user) {
            return array_values([
                ! empty($user->scockpit_user_id) ? 'Ja' : 'Nein',
                $user->salutation == 'male' ? 'Herr' : 'Frau',
                $user->first_name,
                $user->last_name,
                $user->email,
                $user->phone,
                $user->customer->name,
                $user->customer->association->short_name,
                $user->customer->blz,
            ]);
        });

    }
}
