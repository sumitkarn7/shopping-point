@extends('admin.template')


@section('title','Ecommerce Site || Brand index')


@section('js')

    <script>

        $(document).on('click','.show-brand',function(e){

            e.preventDefault();

            let brand_id=$(this).data('brandid');
            // console.log('Brand-Id:',brand_id);

            $.ajax({
                url:"{{ route('show-brand') }}",
                type:"get",
                data:{
                    brand_id:brand_id
                },
                success:function(response)
                {
                    if(typeof(response) !='object')
                    {
                        response=JSON.parse(response);
                    }

                    if(response.error)
                    {
                        alert(response.error);
                    }

                   
                    $('#main-title').html(response.data.title);
                    $('#title').html(response.data.title);
                    $('#slug').html(response.data.slug);
                    $('#status').html(response.data.status);
                    $('#created_by').html(response.created_by);


                    
                }
            })
        });

    </script>
    
    
                
@endsection


@section('main-content')

<div class="page-title">
        <h3>Banner</h3>
        <p class="text-subtitle text-muted">All Brand Listed Here......</p>
    </div>
    <section class="section">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Brand List</h4>
                        
                        <div class="d-flex ">
                        <a href="{{ route('brand.create') }}" class="btn btn-sm btn-success">
                            <i data-feather="plus"></i> Add Brand
                        </a>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-0">
                        <div class="table-responsive">
                            <table class='table mb-0 text-center' id="myTable">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Title</th>
                                        <th>Slug</th>
                                        <th>Status</th>
                                        <th>Image</th>
                                        <th>Created-By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($brand)
                                        @foreach($brand as $brand_info)
                                            <tr>
                                                <td>{{ $brand_info->id}}</td>
                                                <td>{{ ucfirst($brand_info->title) }}</td>
                                                <td>{{ $brand_info->slug}}</td>
                                                <td>
                                                    <a href="{{ route('brand.update-status',[$brand_info->id,$brand_info->status]) }}" class="badge bg-{{ $brand_info->status=='active'?'success':'danger'}}">
                                                        {{ ucfirst($brand_info->status)}}
                                                    </a>
                                                </td>
                                                <td>
                                                    @if($brand_info->image && $brand_info->image !=null)
                                                        <a href="{{ asset('Uploads/Brand/'.$brand_info->image) }}" data-lightbox="image-{{ $brand_info->id}}" data-title="{{$brand_info->title}}">
                                                            Image
                                                        </a>
                                                    @endif
                                                </td>
                                                <td>{{ $brand_info->getUser->name}}</td>
                                                <td>
                                                    <a href="javascript:;" data-brandid="{{ $brand_info->id}}" class="btn btn-sm icon btn-rounded btn-dark btn-style show-brand" data-toggle="modal" data-target="#brand-detail">
                                                        <i data-feather="eye"></i>
                                                    </a>
                                                    <a href="javascript:;" class="btn btn-sm  icon btn-rounded btn-danger btn-style delete-brand" data-id="{{ $brand_info->id}}">
                                                        <i data-feather="trash"></i>
                                                    </a>

                                                    <a href="{{ route('brand.edit',$brand_info->id) }}" class="btn btn-sm  icon btn-rounded btn-primary btn-style" >
                                                        <i data-feather="edit-3"></i>
                                                    </a>
                                                    {{ Form::open(['url'=>route('brand.destroy',$brand_info->id),'class'=>'delete-form'])}}
                                                        @method('delete')
                                                    {{ Form::close()}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endisset
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


                <!--Brand Modal -->
                <div class="modal fade" id="brand-detail" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header bg-success">
                            <h5 class="modal-title" id="exampleModalLongTitle">Brand Detail Of--<span id="main-title"></span> </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            
                                <div>
                                    <strong>Title :</strong> <span id="title"></span>
                                </div>
                                <br>
                                <div>
                                    <strong>Slug :</strong> <span id="slug"></span>
                                </div>
                                <br>
                                <div>
                                    <strong>Status :</strong> <span id="status"></span>
                                </div>
                                <br>
                                <div>
                                    <strong>Created-By :</strong> <span id="created_by"></span>
                                </div>                         
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                            </button>

                        </div>
                        </div>
                    </div>
                    </div>

@endsection


