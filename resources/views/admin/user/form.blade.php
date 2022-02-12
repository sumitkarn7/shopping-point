@extends('admin.template')


@section('title','Ecommerce Site || User-Form')

@section('main-content')

<div class="page-title">
        <h3>User</h3>
        <p class="text-subtitle text-muted">
            @isset($data)
            Update
            @else
            Add
            @endisset
            User......
        </p>
    </div>
    <section class="section">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">User Form</h4>
                        
                        <div class="d-flex ">
                        <a href="{{ route('user.index') }}" class="btn btn-sm btn-success">
                            <i data-feather="skip-back"></i> Back
                        </a>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-0">
                        <div class="card-body">
                            @isset($data)
                            {{ Form::open(['url'=>route('user.update',$data->id),'files'=>true,'class'=>'form form-horizontal'])}}
                                @method('put')
                            @else
                            {{ Form::open(['url'=>route('user.store'),'files'=>true,'class'=>'form form-horizontal'])}}
                            @endisset
                                <div class="form-body">
                                    <div class="row">
                                    <div class="col-md-2">
                                        {{ Form::label('name','Name:')}}
                                    </div>
                                    <div class="col-md-10 form-group">
                                        {{ Form::text('name',@$data->name,['class'=>'form-control form-control-sm '.($errors->has('name') ?'is-invalid':''),'required'=>true,'placeholder'=>'Enter User Name Here......'])}}
                                        @error('name')
                                            <div class="invalid-feedback">
                                                <i class="bx bx-radio-circle"></i>
                                                {{ $message}}
                                            </div>
                                        @enderror
                                    </div>

                                    @if(!isset($data))
                                    <div class="col-md-2">
                                        {{ Form::label('email','Email:')}}
                                    </div>
                                    <div class="col-md-10 form-group">
                                        {{ Form::Email('email','',['class'=>'form-control form-control-sm '.($errors->has('email') ?'is-invalid':''),'required'=>true,'placeholder'=>'Enter User Email Here......'])}}
                                        @error('email')
                                            <div class="invalid-feedback">
                                                <i class="bx bx-radio-circle"></i>
                                                {{ $message}}
                                            </div>
                                        @enderror
                                    </div>
                                    @endif

                                    

                                    <div class="col-md-2">
                                        {{ Form::label('role','Role:')}}
                                    </div>
                                    <div class="col-md-10 form-group">
                                        {{ Form::select('role',['seller'=>'Seller','customer'=>'Customer'],@$data->role,['class'=>'form-control form-control-sm '.($errors->has('role') ?'is-invalid':''),'required'=>true,'placeholder'=>'---------Select Any One-------'])}}
                                        @error('role')
                                            <div class="invalid-feedback">
                                                <i class="bx bx-radio-circle"></i>
                                                {{ $message}}
                                            </div>
                                        @enderror
                                    </div>


                                    <div class="col-md-2">
                                        {{ Form::label('address','Address:')}}
                                    </div>
                                    <div class="col-md-10 form-group">
                                        {{ Form::textarea('address',@$data->UserInfo->address,['class'=>'form-control form-control-sm '.($errors->has('address') ?'is-invalid':''),'required'=>false,'placeholder'=>'Enter User Address Here......','rows'=>5,'style'=>'resize:none;'])}}
                                        @error('address')
                                            <div class="invalid-feedback">
                                                <i class="bx bx-radio-circle"></i>
                                                {{ $message}}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-2">
                                        {{ Form::label('phone','phone:')}}
                                    </div>
                                    <div class="col-md-10 form-group">
                                        {{ Form::tel('phone',@$data->UserInfo->phone,['class'=>'form-control form-control-sm '.($errors->has('phone') ?'is-invalid':''),'required'=>false,'placeholder'=>'Enter Phoone Num......'])}}
                                        @error('phone')
                                            <div class="invalid-feedback">
                                                <i class="bx bx-radio-circle"></i>
                                                {{ $message}}
                                            </div>
                                        @enderror
                                    </div>


                                    <div class="col-md-2">
                                        {{ Form::label('image','image:')}}
                                    </div>
                                    <div class="col-md-3 form-group">
                                        {{ Form::file('image',['class'=>($errors->has('image') ?'is-invalid':''),'accept'=>'image/*'])}}
                                        @error('image')
                                            <div class="invalid-feedback">
                                                <i class="bx bx-radio-circle"></i>
                                                {{ $message}}
                                            </div>
                                        @enderror
                                    </div>
                                    @isset($data)
                                        <div class="col-md-4">
                                            <img src="{{ asset('Uploads/User/'.@$data->UserInfo->image) }}" alt="" class="img-fluid img-thumbnail">
                                        </div>
                                    @endisset
                                    
                                    
                                    
                                    <div class="offset-md-2 col-sm-10 ">
                                        {{ Form::button('<i data-feather="x"></i> Reset',['class'=>'btn btn-sm btn-danger mr-1 mb-1','type'=>'reset'])}}
                                        @isset($data)
                                        {{ Form::button('<i data-feather="send"></i> Update',['class'=>'btn btn-sm btn-success mr-1 mb-1','type'=>'submit'])}}
                                        @else
                                        {{ Form::button('<i data-feather="send"></i> Add',['class'=>'btn btn-sm btn-success mr-1 mb-1','type'=>'submit'])}}
                                        @endisset
                                       
                                    </div>
                                    </div>
                                </div>
                            {{ Form::close()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection