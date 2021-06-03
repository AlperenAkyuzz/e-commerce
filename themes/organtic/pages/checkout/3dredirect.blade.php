<form method="post" action="{{ $form_data['gateway'] }}" class="redirect-form" role="form">
    @foreach ($form_data['inputs'] as $key => $value)
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
    @endforeach
    <div class="text-center">Redirecting...</div>
    <hr>
    <div class="form-group text-center">
        <button type="submit" class="btn btn-lg btn-block btn-success">Submit</button>
    </div>
</form>