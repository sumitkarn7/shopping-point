<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set New Password</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
</head>

<body>
    <div id="auth">
        
<div class="container">
    <div class="row">
        <div class="col-md-5 col-sm-12 mx-auto">
            <div class="card pt-4">
                <div class="card-body">
                    <div class="text-center mb-5">
                        <img src="{{ asset('assets/images/favicon.svg') }}" height="48" class='mb-4'>
                        <h3>Set New password</h3>
                        <p>Please Update Your Password.</p>
                    </div>
                    {{ Form::open(['url'=>route('user.update-password',auth()->user()->id)])}}
                    @method('put')
                        <div class="form-group position-relative has-icon-left">
                            <div class="clearfix mb-1">
                                {{ Form::label('password','New-Password')}}
                            </div>
                            <div class="position-relative">
                                {{ Form::password('password',['class'=>'form-control '.($errors->has('password') ?'is-invalid':''),'required'=>true,'placeholder'=>'Enter New Password Here......'])}}
                                <div class="form-control-icon">
                                    <i data-feather="lock"></i>
                                </div>
                            </div>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">
                                <i class="bx bx-radio-circle"></i>
                                    {{ $message}}
                            </div>
                        @enderror

                        <div class="form-group position-relative has-icon-left">
                            <div class="clearfix mb-1">
                                {{ Form::label('password_confirmation','Re-Type Password')}}
                            </div>
                            <div class="position-relative">
                                {{ Form::password('password_confirmation',['class'=>'form-control '.($errors->has('password_confirmation') ?'is-invalid':''),'required'=>true,'placeholder'=>'Enter Password  Again......'])}}
                                <div class="form-control-icon">
                                    <i data-feather="lock"></i>
                                </div>
                            </div>
                        </div>
                        @error('password_confirmation')
                            <div class="invalid-feedback">
                                <i class="bx bx-radio-circle"></i>
                                    {{ $message}}
                            </div>
                        @enderror


                        
                        <div class="clearfix">
                            {{ Form::button('<i data-feather="send"></i> Update',['class'=>'btn btn-primary float-right','type'=>'submit'])}}
                        </div>
                        {{ Form::close()}}
                </div>
            </div>
        </div>
    </div>
</div>

    </div>
    <script src="{{ asset('assets/js/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>
