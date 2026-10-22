<div class="alert alert-info m-3">
    <aside>
        <h3>Hinweis</h3>
        <p>
           @if(empty($alert))
                Es gibt kein Ergebnis für die gesetzten Filter.
           @else
               {!! $alert !!}
           @endif
        </p>
    </aside>
</div>
