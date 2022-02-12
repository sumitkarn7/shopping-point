@extends('admin.template')


@section('title','Ecommerce Site || Page index')





@section('main-content')

<div class="page-title">
        <h3>{{ ucfirst($page_type)}}</h3>
        <p class="text-subtitle text-muted">All {{ ucfirst($page_type)}} Listed Here......</p>
    </div>
    <section class="section">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ ucfirst($page_type)}} List</h4>
                        
                        <div class="d-flex ">
                        @if($page_type=='blog')
                        <a href="{{ route('page.create') }}" class="btn btn-sm btn-success">
                            <i data-feather="plus"></i> Add Blog
                        </a>
                        @endif
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
                                        <th>Summary</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Page-Type</th>
                                        <th>Image</th>
                                        <th>Created-By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($page)
                                        @foreach($page as $page_info)
                                            <tr>
                                                <td>{{ $page_info->id}}</td>
                                                <td>{{ ucfirst($page_info->title) }}</td>
                                                <td>{{ ucfirst($page_info->slug) }}</td>
                                                <td>{{ ucfirst($page_info->summary) }}</td>
                                                <td>{{ ucfirst($page_info->description) }}</td>
                                                <td>
                                                    <a href="{{ route('page.update-status',[$page_info->id,$page_info->status]) }}" class="badge bg-{{ $page_info->status=='active'?'success':'danger'}}">
                                                        {{ ucfirst($page_info->status)}}
                                                    </a>
                                                </td>
                                                <td>{{ $page_info->page_type}}</td>
                                                <td>
                                                    @if($page_info->image && $page_info->image !=null)
                                                        <a href="{{ asset('Uploads/Page/'.$page_info->image) }}" data-lightbox="image-{{ $page_info->id}}" data-title="{{$page_info->title}}">
                                                            Image
                                                        </a>
                                                    @endif
                                                </td>
                                                <td>{{ @$page_info->getUser->name}}</td>
                                                <td>
                                                    @if($page_type=='blog')
                                                    <a href="javascript:;" class="btn btn-sm  icon btn-rounded btn-danger btn-style delete-blog" data-id="{{ $page_info->id}}">
                                                        <i data-feather="trash"></i>
                                                    </a>
                                                    @endif

                                                    <a href="{{ route('page.edit',$page_info->id) }}" class="btn btn-sm  icon btn-rounded btn-primary btn-style" >
                                                        <i data-feather="edit-3"></i>
                                                    </a>
                                                    {{ Form::open(['url'=>route('page.destroy',$page_info->id),'class'=>'delete-form'])}}
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


