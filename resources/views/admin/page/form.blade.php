@extends('admin.template')


@section('title','Ecommerce Site || Banner-Form')

@section('main-content')

<div class="page-title">
        <h3>{{ ucfirst($page_type)}}</h3>
        <p class="text-subtitle text-muted">
            @isset($data)
            Update
            @else
            Add
            @endisset
             {{ ucfirst($page_type)}}......
        </p>
    </div>
    <section class="section">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ ucfirst($page_type)}} Form</h4>
                        
                        <div class="d-flex ">
                        <a href="{{ route('page.show',$page_type) }}" class="btn btn-sm btn-success">
                            <i data-feather="skip-back"></i> Back
                        </a>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-0">
                        <div class="card-body">
                            @isset($data)
                            {{ Form::open(['url'=>route('page.update',$data->id),'files'=>true,'class'=>'form form-horizontal'])}}
                                @method('put')
                            @else
                            {{ Form::open(['url'=>route('page.store'),'files'=>true,'class'=>'form form-horizontal'])}}
                            @endisset
                                <div class="form-body">
                                    <div class="row">
                                    <div class="col-md-2">
                                        {{ Form::label('title','Title:')}}
                                    </div>
                                    <div class="col-md-10 form-group">
                                        {{ Form::text('title',@$data->title,['class'=>'form-control form-control-sm '.($errors->has('title') ?'is-invalid':''),'required'=>true,'placeholder'=>'Enter Banner Title Here......'])}}
                                        @error('title')
                                            <div class="invalid-feedback">
                                                <i class="bx bx-radio-circle"></i>
                                                {{ $message}}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-2">
                                        {{ Form::label('summary','Summary:')}}
                                    </div>
                                    <div class="col-md-10 form-group">
                                        {{ Form::textarea('summary',@$data->summary,['class'=>'form-control form-control-sm '.($errors->has('summary') ?'is-invalid':''),'required'=>true,'placeholder'=>'Enter  Summary Here......','rows'=>3,'style'=>'resize:none;'])}}
                                        @error('summary')
                                            <div class="invalid-feedback">
                                                <i class="bx bx-radio-circle"></i>
                                                {{ $message}}
                                            </div>
                                        @enderror
                                    </div>


                                    <div class="col-md-2">
                                        {{ Form::label('description','Description:')}}
                                    </div>
                                    <div class="col-md-10 form-group">
                                        {{ Form::textarea('description',@$data->description,['class'=>'form-control form-control-sm '.($errors->has('description') ?'is-invalid':''),'required'=>true,'placeholder'=>'Enter  Description Here......','rows'=>5,'style'=>'resize:none;'])}}
                                        @error('description')
                                            <div class="invalid-feedback">
                                                <i class="bx bx-radio-circle"></i>
                                                {{ $message}}
                                            </div>
                                        @enderror
                                    </div>

                                   

                                    <div class="col-md-2">
                                        {{ Form::label('status','Status:')}}
                                    </div>
                                    <div class="col-md-10 form-group">
                                        {{ Form::select('status',['active'=>'Active','inactive'=>'In-Active'],@$data->status,['class'=>'form-control form-control-sm '.($errors->has('status') ?'is-invalid':''),'required'=>true,'placeholder'=>'---------Select Any One-------'])}}
                                        @error('status')
                                            <div class="invalid-feedback">
                                                <i class="bx bx-radio-circle"></i>
                                                {{ $message}}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-2">
                                        {{ Form::label('image','Image:')}}
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
                                            <img src="{{ asset('Uploads/Page/'.@$data->image) }}" alt="" class="img-fluid img-thumbnail">
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