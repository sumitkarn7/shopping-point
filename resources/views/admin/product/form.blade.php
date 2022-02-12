@extends('admin.template')


@section('title','Ecommerce Site || Product-Form')

@section('js')

    <script>
        $('#cat_id').change(function(e){
            e.preventDefault();
            const cat_id=$(this).val();

            const sub_cat_id={{ $data->sub_cat_id ?? 0}};
            console.log('Sub-Cat-Id:',sub_cat_id);

            $.ajax({
                url:"{{route('show-sub-cat')}}",
                type:"get",
                data:{
                    cat_id:cat_id
                },
                success:function(response)
                {
                    
                    if(typeof(response) !='object')
                    {
                        response=JSON.parse(response);
                    }
                    var child_html="<option value=''>----------------Select Any One--------------------</option>";
                    if(response.error)
                    {
                        alert(response.error);
                    }
                    else
                    {
                        if(response.data.child.length >0)
                        {
                            $.each(response.data.child,function(index,value){
                                child_html+="<option value='"+value.id+"'";

                                if(sub_cat_id==value.id)
                                {
                                    child_html+='selected';
                                }

                                child_html+=">"+value.title+"</option>";
                            });
                        }
                    }

                    $('#sub_cat_id').html(child_html);
                }
            });
        });

        @isset($data)
            $('#cat_id').change();
        @endisset
    </script>

@endsection

@section('main-content')

<div class="page-title">
        <h3>Product</h3>
        <p class="text-subtitle text-muted">
            @isset($data)
            Update
            @else
            Add
            @endisset
            Product......
        </p>
    </div>
    <section class="section">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Product Form</h4>
                        
                        <div class="d-flex ">
                        <a href="{{ route('product.index') }}" class="btn btn-sm btn-success">
                            <i data-feather="skip-back"></i> Back
                        </a>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-0">
                        <div class="card-body">
                            @isset($data)
                            {{ Form::open(['url'=>route('product.update',$data->id),'files'=>true,'class'=>'form form-horizontal'])}}
                                @method('put')
                            @else
                            {{ Form::open(['url'=>route('product.store'),'files'=>true,'class'=>'form form-horizontal','multiple'=>true])}}
                            @endisset
                                <div class="form-body">
                                    <div class="row">
                                    <div class="col-md-2">
                                        {{ Form::label('title','Title:')}}
                                    </div>
                                    <div class="col-md-10 form-group">
                                        {{ Form::text('title',@$data->title,['class'=>'form-control form-control-sm '.($errors->has('title') ?'is-invalid':''),'required'=>true,'placeholder'=>'Enter Product Title Here......'])}}
                                        @error('title')
                                            <div class="invalid-feedback">
                                                <i class="bx bx-radio-circle"></i>
                                                {{ $message}}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-2">
                                        {{ Form::label('cat_id','Category:')}}
                                    </div>
                                    <div class="col-md-10 form-group">
                                        {{ Form::select('cat_id',$parent_cat->pluck('title','id'),@$data->cat_id,['class'=>'form-control form-control-sm '.($errors->has('cat_id') ?'is-invalid':''),'required'=>false,'placeholder'=>'---------Select Any One-------'])}}
                                        @error('cat_id')
                                            <div class="invalid-feedback">
                                                <i class="bx bx-radio-circle"></i>
                                                {{ $message}}
                                            </div>
                                        @enderror
                                    </div>


                                    <div class="col-md-2">
                                        {{ Form::label('sub_cat_id','Sub-Category-Of:')}}
                                    </div>
                                    <div class="col-md-10 form-group">
                                        {{ Form::select('sub_cat_id',[],@$data->sub_cat_id,['class'=>'form-control form-control-sm '.($errors->has('sub_cat_id') ?'is-invalid':''),'required'=>false])}}
                                        @error('sub_cat_id')
                                            <div class="invalid-feedback">
                                                <i class="bx bx-radio-circle"></i>
                                                {{ $message}}
                                            </div>
                                        @enderror
                                    </div>


                                    <div class="col-md-2">
                                        {{ Form::label('brand_id','Brands:')}}
                                    </div>
                                    <div class="col-md-10 form-group">
                                        {{ Form::select('brand_id[]',$all_brand->pluck('title','id'),@$data->getBrand,['class'=>'form-control form-control-sm js-example-basic-single '.($errors->has('brand_id') ?'is-invalid':''),'required'=>true,'multiple'=>true])}}
                                        @error('brand_id')
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
                                        {{ Form::textarea('summary',@$data->summary,['class'=>'form-control form-control-sm '.($errors->has('summary') ?'is-invalid':''),'required'=>true,'placeholder'=>'Enter Product Summary Here......','rows'=>3,'style'=>'resize:none;'])}}
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
                                        {{ Form::textarea('description',@$data->description,['class'=>'form-control form-control-sm description '.($errors->has('description') ?'is-invalid':''),'required'=>true,'placeholder'=>'Enter Product description Here......','rows'=>5,'style'=>'resize:none;'])}}
                                        @error('description')
                                            <div class="invalid-feedback">
                                                <i class="bx bx-radio-circle"></i>
                                                {{ $message}}
                                            </div>
                                        @enderror
                                    </div>


                                    <div class="col-md-2">
                                        {{ Form::label('price','Product Price:')}}
                                    </div>
                                    <div class="col-md-10 form-group">
                                        {{ Form::number('price',@$data->price,['class'=>'form-control form-control-sm '.($errors->has('price') ?'is-invalid':''),'required'=>true,'placeholder'=>'Enter Product Price Here......','min'=>100])}}
                                        @error('price')
                                            <div class="invalid-feedback">
                                                <i class="bx bx-radio-circle"></i>
                                                {{ $message}}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-2">
                                        {{ Form::label('discount','Product Discount(%):')}}
                                    </div>
                                    <div class="col-md-10 form-group">
                                        {{ Form::number('discount',@$data->discount,['class'=>'form-control form-control-sm '.($errors->has('discount') ?'is-invalid':''),'required'=>false,'placeholder'=>'Enter Product discount Here......','min'=>0,'max'=>95])}}
                                        @error('discount')
                                            <div class="invalid-feedback">
                                                <i class="bx bx-radio-circle"></i>
                                                {{ $message}}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-2">
                                        {{ Form::label('is_featured','Is-Featured:')}}
                                    </div>
                                    <div class="col-md-10 form-group">
                                        <label id="is_featured">{{ Form::checkbox('is_featured',1,@$data->is_featured)}} Yes</label>
                                        @error('is_featured')
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
                                        {{ Form::label('seller_id','Seller:')}}
                                    </div>
                                    <div class="col-md-10 form-group">
                                        {{ Form::select('seller_id',$all_seller->pluck('name','id'),@$data->seller_id,['class'=>'form-control form-control-sm '.($errors->has('seller_id') ?'is-invalid':''),'required'=>false,'placeholder'=>'---------Select Seller-------'])}}
                                        @error('seller_id')
                                            <div class="invalid-feedback">
                                                <i class="bx bx-radio-circle"></i>
                                                {{ $message}}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-2">
                                        {{ Form::label('image','Product-Image:')}}
                                    </div>
                                    <div class="col-md-3 form-group">
                                        {{ Form::file('image[]',['class'=>($errors->has('image') ?'is-invalid':''),'accept'=>'image/*','multiple'])}}
                                        @error('image')
                                            <div class="invalid-feedback">
                                                <i class="bx bx-radio-circle"></i>
                                                {{ $message}}
                                            </div>
                                        @enderror
                                    </div>
                                    @isset($data)
                                        <div class="col-md-10">
                                            <img src="{{ asset('Uploads/Banner/'.@$data->image) }}" alt="" class="img-fluid img-thumbnail">
                                        </div>
                                    @endisset

                                    @isset($data)
                                        <div class="form-group col-md-12">
                                            <div class="row">
                                                @foreach($data->getProductImage as $image)
                                                    <div class="col-md-2">
                                                        <img src="{{ asset('Uploads/Product/'.$image->image_name) }}" alt="" class="img-fluid img-thumbnail">
                                                        <a href="javascript:;" data-imageid="{{ $image->id}}" class="btn btn-sm btn-danger btn-style icon btn-rounded delete-image">
                                                            <i data-feather="x"></i>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
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