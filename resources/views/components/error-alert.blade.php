{{-- resources/views/components/error-alert.blade.php --}}

@if ($errors->any())
    <div class="alert alert-danger">
        {{-- Use a heading for better visibility --}}
        <h4 class="alert-heading">Whoops! There were some errors.</h4>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
