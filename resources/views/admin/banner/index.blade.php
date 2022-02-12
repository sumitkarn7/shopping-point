@extends('admin.template')


@section('title','Ecommerce Site || Banner index')


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
        <h3>Banner</h3>
        <p class="text-subtitle text-muted">All Banner Listed Here......</p>
    </div>
    <section class="section">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Banner List</h4>
                        
                        <div class="d-flex ">
                        <a href="{{ route('banner.create') }}" class="btn btn-sm btn-success">
                            <i data-feather="plus"></i> Add Banner
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
                                        <th>Link</th>
                                        <th>Status</th>
                                        <th>Image</th>
                                        <th>Created-By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($banner)
                                        @foreach($banner as $banner_info)
                                            <tr>
                                                <td>{{ $banner_info->id}}</td>
                                                <td>{{ ucfirst($banner_info->title) }}</td>
                                                <td>
                                                    @if($banner_info->link && $banner_info->link !=null)
                                                        <a href="{{ $banner_info->link}}">Link</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('banner.update-status',[$banner_info->id,$banner_info->status]) }}" class="badge bg-{{ $banner_info->status=='active'?'success':'danger'}}">
                                                        {{ ucfirst($banner_info->status)}}
                                                    </a>
                                                </td>
                                                <td>
                                                    @if($banner_info->image && $banner_info->image !=null)
                                                        <a href="{{ asset('Uploads/Banner/'.$banner_info->image) }}" data-lightbox="image-{{ $banner_info->id}}" data-title="{{$banner_info->title}}">
                                                            Image
                                                        </a>
                                                    @endif
                                                </td>
                                                <td>{{ $banner_info->getUser->name}}</td>
                                                <td>
                                                    <a href="javascript:;" data-bannerid="{{ $banner_info->id}}" class="btn btn-sm icon btn-rounded btn-dark btn-style show-banner" data-toggle="modal" data-target="#banner-detail">
                                                        <i data-feather="eye"></i>
                                                    </a>
                                                    <a href="javascript:;" class="btn btn-sm  icon btn-rounded btn-danger btn-style delete-banner" data-id="{{ $banner_info->id}}">
                                                        <i data-feather="trash"></i>
                                                    </a>

                                                    <a href="{{ route('banner.edit',$banner_info->id) }}" class="btn btn-sm  icon btn-rounded btn-primary btn-style" >
                                                        <i data-feather="edit-3"></i>
                                                    </a>
                                                    {{ Form::open(['url'=>route('banner.destroy',$banner_info->id),'class'=>'delete-form'])}}
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


