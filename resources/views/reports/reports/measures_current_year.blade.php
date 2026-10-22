<div style="width: 80.00%;">
    <h5>Maßnahmen</h5>
    <table cellpadding="0"cellspacing="0">
        <thead>
        <tr>
            <th>#</th>
            <th>Kampagne</th>
            <th>Anmeldungen</th>
            <th>Von</th>
            <th>Bis</th>
        </tr>
        </thead>
        <tbody>
        @foreach($measures as $measure)
            <tr>
                <td>{{ $measure->id }}</td>
                <td>{{ $measure->name }}</td>
                <td>{{ $measure->customerMeasures->count() }}</td>
                <td>{{ $measure->from->format('d.m.Y') }}</td>
                <td>{{ $measure->to->format('d.m.Y') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
