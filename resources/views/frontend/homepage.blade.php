@extends('layouts.app')

@section('title', 'My Custom App')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <h3>Save files into your Dropbox account</h3>
            {!!Form::open(array('action' => 'Frontend\RequestController@submitRequest', 'class' => 'form-horizontal', 'files' => true))!!}
                <div class="form-group register-field">
                    {!!Form::text('name', null,
                        array(
                            'class' => 'form-control',
                            'placeholder' => 'Name'
                        ))
                    !!}
                </div>

                <div class="form-group register-field">
                    {!!Form::email('email', null,
                        array(
                            'class' => 'form-control',
                            'placeholder' => 'Email'
                        ))
                    !!}
                </div>

                <div class="custom-file form-group">
                    {!!Form::file('customFile',
                        array(
                            'class' => 'custom-file-input',
                            'id' => 'customFile'
                        ))
                    !!}
                    <label class="custom-file-label" for="customFile">Choose file...</label>
                </div>

            {{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}
            {!!Form::close()!!}
        </div>
    </div>
@endsection
