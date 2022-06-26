@if (sizeof($errors) > 0)
<div class="alert alert-danger alert-dismissible">
    <h4 class="alert-heading">Error</h4>
    @if (sizeof($errors) == 1)
        <p>{{ $errors->all()[0] }}</p>
    @else
        <ol>
        @foreach ($errors->all() as $message)
            <li>{!! $message !!}</li>
        @endforeach
        </ol>
    @endif
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session()->has('alert'))
<div class="alert alert-{{ session()->get('alert')[0] }} alert-dismissible">
    <h4 class="alert-heading">{{ ucwords(session()->get('alert')[0]) }}</h4>
    <p>{!! session()->get('alert')[1] !!}</p>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
