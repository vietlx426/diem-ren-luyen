<!-- Alert message -->
@if (session('status'))
    @if(session('alarmlevel'))
        <div class="alert alert-{{session('alarmlevel')}}">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>{{ session('status')}}</strong>
        </div>
    @else
        <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('status')}}
        </div>
    @endif
@endif