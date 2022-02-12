@extends('admin.template')


@section('title','Ecommerce Site || Product index')


@section('js')

    <script>

        $(document).on('click','.show-banner',function(e){

            e.preventDefault();

            let banner_id=$(this).data('bannerid');
            // console.log('Banner-Id:',banner_id);

            $.ajax({
                url:"{{ route('show-banner') }}",
                type:"get",
                data:{
                    banner_id:banner_id
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
                    $('#link').html(response.data.link);
                    $('#status').html(response.data.status);
                    $('#created_by').html(response.user);


                    
                }
            })
        });

    </script>
    
    
                
@endsection


@section('main-content')

<div class="page-title">
        <h3>Product</h3>
        <p class="text-subtitle text-muted">All Product Listed Here......</p>
    </div>
    <section class="section">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Product List</h4>
                        
                        <div class="d-flex ">
                        <a href="{{ route('product.create') }}" class="btn btn-sm btn-success">
                            <i data-feather="plus"></i> Add Product
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
                                        <th>Category</th>
                                        <th>Sub-Category</th>
                                        <th>Price</th>
                                        <th>Actual-Price</th>
                                        <th>Is-featured</th>
                                        <th>Status</th>
                                        <th>Seller</th>
                                        <th>Created-By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($product)
                                        @foreach($product as $product_info)
                                            <tr class="table-{{ $product_info->trashed() ?'danger':''}}">
                                                <td>{{ $product_info->id}}</td>
                                                <td>{{ ucfirst($product_info->title)}}</td>
                                                <td>{{ $product_info->slug}}</td>
                                                <td>{{ @$product_info->getParent->title}}</td>
                                                <td>{{ @$product_info->getSubCat->title}}</td>
                                                <td>{{ $product_info->price}}
                                                    @if($product_info->discount && $product_info->discount !=null)
                                                        (-{{$product_info->discount}}%)
                                                    @endif
                                                </td>
                                                <td>{{ $product_info->actual_price}}</td>
                                                <td>{{ $product_info->is_featured=='1'?'Yes':'No'}}</td>
                                                <td>
                                                    <a href="{{ route('product.update-status',[$product_info->id,$product_info->status]) }}" class="badge bg-{{ $product_info->status=='active'?'success':'danger'}}">
                                                        {{ ucfirst($product_info->status)}}
                                                    </a>
                                                </td>
                                                <td>{{ $product_info->getSeller->name}}</td>
                                                <td>{{ $product_info->getUser->name}}</td>
                                                <td>

                                                    <a href="javascript:;" class="btn btn-sm  icon btn-rounded btn-danger btn-style delete-product" data-id="{{ $product_info->id}}">
                                                        <i data-feather="trash"></i>
                                                    </a>

                                                    <a href="{{ route('product.edit',$product_info->id) }}" class="btn btn-sm btn-primary icon bn-rounded btn-style">
                                                        <i data-feather="edit-3"></i>
                                                    </a>
                                                    {{ Form::open(['url'=>route('product.destroy',$product_info->id),'class'=>'delete-form'])}}
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


                <!--scrollbar Modal -->
                <div class="modal fade" id="banner-detail" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header bg-success">
                            <h5 class="modal-title" id="exampleModalLongTitle">Banner Detail Of--<span id="main-title"></span> </h5>
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
                                    <strong>Link :</strong> <span id="link"></span>
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








           