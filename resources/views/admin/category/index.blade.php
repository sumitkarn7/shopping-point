@extends('admin.template')


@section('title','Ecommerce Site || Category index')


@section('js')

    <script>

        $(document).on('click','.show-category',function(e){

            e.preventDefault();

            let category_id=$(this).data('categoryid');
            // console.log('Banner-Id:',banner_id);

            $.ajax({
                url:"{{ route('show-category') }}",
                type:"get",
                data:{
                    category_id:category_id
                },
                success:function(response)
                {
                    if(typeof(response) !='object')
                    {
                        response=JSON.parse(response);
                    }

                    var brand_html="<span></span>";
                    if(response.error)
                    {
                        alert(response.error);
                    }
                    else
                    {
                        if(response.brand.length >0)
                        {
                            $.each(response.brand,function(index,value){
                            brand_html+="<span>"+value.title+"</span>";
                            brand_html+="<br>";
                            });
                        }

                        
                    }

                   
                    $('#main-title').html(response.data.title);
                    $('#title').html(response.data.title);
                    $('#slug').html(response.data.slug);
                    $('#summary').html(response.data.summary);
                    $('#status').html(response.data.status);
                    $('#show-brand').html(brand_html);
                    $('#created_by').html(response.user);
                    $('#parent').html(response.parent_of);


                    
                }
            })
        });

    </script>
    
    
                
@endsection


@section('main-content')

<div class="page-title">
        <h3>Category</h3>
        <p class="text-subtitle text-muted">All Category Listed Here......</p>
    </div>
    <section class="section">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">
                        @isset($main_cat)
                        Category List Of "<em>{{ $main_cat->title}}</em>" Category 
                        @else
                        Category List
                        @endisset
                        </h4>
                        <div class="d-flex ">
                        <a href="{{ route('category.create') }}" class="btn btn-sm btn-success">
                            <i data-feather="plus"></i> Add Category
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
                                        <th>Category</th>
                                        <th>Brand</th>
                                        <th>Slug</th>
                                        <th>Status</th>
                                        <th>Image</th>
                                        <th>Created-By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($parent_cat)
                                        @foreach($parent_cat as $cat_info)
                                            <tr>
                                                <td>{{ $cat_info->id}}</td>
                                                <td>{{ ucfirst($cat_info->title) }}</td>
                                                <td>{{ @$cat_info->getCategory->title}}</td>
                                                <td>{{ implode(" ,",$cat_info->getBrand->pluck('title')->toArray())}}</td>
                                                <td>{{ $cat_info->slug}}</td>
                                                <td>
                                                    <a href="{{ route('category.update-status',[$cat_info->id,$cat_info->status]) }}" class="badge bg-{{ $cat_info->status=='active'?'success':'danger'}}">
                                                        {{ ucfirst($cat_info->status)}}
                                                    </a>
                                                </td>
                                                <td>
                                                    @if($cat_info->image && $cat_info->image !=null)
                                                        <a href="{{ asset('Uploads/Category/'.$cat_info->image) }}" data-lightbox="image-{{ $cat_info->id}}" data-title="{{$cat_info->title}}">
                                                            Image
                                                        </a>
                                                    @endif
                                                </td>
                                                <td>{{ @$cat_info->getUser->name}}</td>
                                                <td>
                                                    @if($cat_info->getChild && $cat_info->getChild->count() >0)
                                                        <a href="{{ route('show-child',$cat_info->slug) }}" class="btn btn-sm btn-warning icon btn-rounded btn-style">
                                                            <i data-feather="list"></i>
                                                        </a>
                                                    @endif


                                                    <a href="javascript:;" data-categoryid="{{ $cat_info->id}}" class="btn btn-sm icon btn-rounded btn-dark btn-style show-category" data-toggle="modal" data-target="#category-detail">
                                                        <i data-feather="eye"></i>
                                                    </a>
                                                    <a href="javascript:;" class="btn btn-sm  icon btn-rounded btn-danger btn-style delete-category" data-id="{{ $cat_info->id}}">
                                                        <i data-feather="trash"></i>
                                                    </a>

                                                    <a href="{{ route('category.edit',$cat_info->id) }}" class="btn btn-sm  icon btn-rounded btn-primary btn-style" >
                                                        <i data-feather="edit-3"></i>
                                                    </a>
                                                    {{ Form::open(['url'=>route('category.destroy',$cat_info->id),'class'=>'delete-form'])}}
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
                <div class="modal fade" id="category-detail" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header bg-red">
                            <h5 class="modal-title" id="exampleModalLongTitle">Category Detail Of--<span id="main-title"></span> </h5>
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
                                    <strong>Sub-Category-Of :</strong> <span id="parent"></span>
                                </div>
                                <br>

                                <div>
                                    <strong>Status :</strong> <span id="status"></span>
                                </div>
                                <br>
                                <div>
                                    <strong>Summary :</strong> <span id="summary"></span>
                                </div>
                                <br>
                                <strong>Brands :</strong>
                                <div id="show-brand">
                                     <span id="brand"></span>
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


