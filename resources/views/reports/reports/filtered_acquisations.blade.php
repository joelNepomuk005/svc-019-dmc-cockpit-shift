<div style="width: 100.00%;">
    <h5>Akquisitionen</h5>
    <table cellpadding="0"cellspacing="0">
        <thead>
        <tr>
            <th>Institut</th>
            <th>Verband</th>
            <th>Thema</th>
            <th>Produktkategorie</th>
            <th>Produkt</th>
            <th>Berater</th>
        </tr>
        </thead>
        <tbody>
        @foreach($acquisations as $key => $value)
            <tr>
                <td>{{ $value['customer']['name'] }}</td>
                <td>
                    @if ($value['association'])
                        {{ $value['association']['short_name'] }}
                    @endif
                </td>
                <td>{{ $value['subject'] }}</td>
                <td>
                    @if ($value['product']['category'])
                        {{ $value['product']['category']['name'] }}
                    @endif
                </td>
                <td>
                    @if ($value['product']['name'])
                        {{ $value['product']['name'] }}
                    @endif
                </td>
                <td>
                    @if (!empty($value['customer']['internal_contact_persons']['vertrieb_mehrwerte_beratung']['name']))
                        {{ $value['customer']['internal_contact_persons']['vertrieb_mehrwerte_beratung']['name'] }}
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
