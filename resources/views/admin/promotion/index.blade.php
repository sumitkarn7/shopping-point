@extends('admin.template')


@section('title','Ecommerce Site || Promotion index')





@section('main-content')

<div class="page-title">
        <h3>Promotion</h3>
        <p class="text-subtitle text-muted">All Promotion Listed Here......</p>
    </div>
    <section class="section">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Promotion List</h4>
                        
                        <div class="d-flex ">
                        <a href="{{ route('promotion.create') }}" class="btn btn-sm btn-success">
                            <i data-feather="plus"></i> Add Promotion
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
                                    @isset($promotion)
                                        @foreach($promotion as $promotion_info)
                                            <tr>
                                                <td>{{ $promotion_info->id}}</td>
                                                <td>{{ ucfirst($promotion_info->title) }}</td>
                                                <td>
                                                    @if($promotion_info->link && $promotion_info->link !=null)
                                                        <a href="{{ $promotion_info->link}}">Link</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('promotion.update-status',[$promotion_info->id,$promotion_info->status]) }}" class="badge bg-{{ $promotion_info->status=='active'?'success':'danger'}}">
                                                        {{ ucfirst($promotion_info->status)}}
                                                    </a>
                                                </td>
                                                <td>
                                                    @if($promotion_info->image && $promotion_info->image !=null)
                                                        <a href="{{ asset('Uploads/Promotion/'.$promotion_info->image) }}" data-lightbox="image-{{ $promotion_info->id}}" data-title="{{$promotion_info->title}}">
                                                            Image
                                                        </a>
                                                    @endif
                                                </td>
                                                <td>{{ $promotion_info->getUser->name}}</td>
                                                <td>
                                                    <a href="javascript:;" class="btn btn-sm  icon btn-rounded btn-danger btn-style delete-promotion" data-id="{{ $promotion_info->id}}">
                                                        <i data-feather="trash"></i>
                                                    </a>

                                                    <a href="{{ route('promotion.edit',$promotion_info->id) }}" class="btn btn-sm  icon btn-rounded btn-primary btn-style" >
                                                        <i data-feather="edit-3"></i>
                                                    </a>
                                                    {{ Form::open(['url'=>route('promotion.destroy',$promotion_info->id),'class'=>'delete-form'])}}
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


