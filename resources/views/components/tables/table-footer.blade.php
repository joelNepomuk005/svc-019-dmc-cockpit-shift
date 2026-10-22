@if($result !== null)
    <tfoot>
        <tr>
            <td colspan="{{ $colspan }}">
                <section class="d-flex justify-content-between align-items-center">
                    <aside aria-label="Statistiken zur Tabelle">
                        <span role="status" aria-live="polite">{{ __('Zeige :first bis :last von insgesamt :total Datensätzen', ['first' =>  $result->firstItem(), 'last' =>  $result->lastItem(), 'total' => $result->total()]) }}</span>
                    </aside>
                    <nav aria-label="Seitensteuerung für Tabelle">
                        {{ $result->appends(['per_page' => request('per_page', 25), 'filter' => request('filter'), 'sort' => request('sort')])->links() }}
                    </nav>
                </section>
            </td>
        </tr>
    </tfoot>
@endif
