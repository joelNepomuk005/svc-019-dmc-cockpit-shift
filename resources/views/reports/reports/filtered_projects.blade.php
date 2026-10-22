<div style="width: 100.00%;">
    <h5>Vertriebsansätze</h5>
    <table cellpadding="0"cellspacing="0">
        <thead>
        <tr>
            <th>Sparkasse</th>
            <th>Berater Vertrieb</th>
            <th>Thema / Vertriebsansatz</th>
            <th>Produkte / Leistungen</th>
            <th>Status</th>
            <th>Einführung am</th>
            <th>Fachbereich genehmigt</th>
        </tr>
        </thead>
        <tbody>
        @foreach($projects as $key => $value)
        <tr>
            <td>{{$value['customer']['name']}}</td>
            <td>
                @if ($value['customer']['internal_contact_persons'])
                    @if($value['customer']['internal_contact_persons']['vertrieb_mehrwerte_beratung'])
                        @if(array_key_exists('last_name', $value['customer']['internal_contact_persons']['vertrieb_mehrwerte_beratung']))
                            {{$value['customer']['internal_contact_persons']['vertrieb_mehrwerte_beratung']['last_name']}}
                        @endif
                    @endif
                @endif
            </td>
            <td>{{$value['subject']}}</td>
            <td>
                @foreach($value->product() as $product)
                    {{$product['name']}}
                    <br>
                @endforeach
            </td>
            <td>{{$value['status']}}</td>
            <td>
                @if($value['introduction_on'])
                    {{date('d.m.Y', strtotime($value['introduction_on']))}}
                @endif
            </td>
            <td>
                @if ($value['approved_appointment'] === 0)
                    Nein
                @else
                    Ja
                @endif
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
