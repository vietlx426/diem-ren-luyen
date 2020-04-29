<!-- Block error message -->
<div class="col">
    <!-- primary -->
    @if (session('primary'))
        <div class="alert alert-primary alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {!! session('primary') !!}
        </div>
    @endif

    <!-- secondary -->
    @if (session('secondary'))
        <div class="alert alert-secondary alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {!! session('secondary') !!}
        </div>
    @endif

    <!-- success -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {!! session('success') !!}
        </div>
    @endif

    <!-- danger -->
    @if (session('danger'))
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {!! session('danger') !!}
        </div>
    @endif

    <!-- warning -->
    @if (session('warning'))
        <div class="alert alert-warning alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {!! session('warning') !!}
        </div>
    @endif

    <!-- info -->
    @if (session('info'))
        <div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {!! session('info') !!}
        </div>
    @endif

    <!-- light -->
    @if (session('light'))
        <div class="alert alert-light alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {!! session('light') !!}
        </div>
    @endif

    <!-- dark -->
    @if (session('dark'))
        <div class="alert alert-dark alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {!! session('dark') !!}
        </div>
    @endif
</div>