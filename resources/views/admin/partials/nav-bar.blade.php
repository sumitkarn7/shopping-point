            <nav class="navbar navbar-header navbar-expand navbar-light">
                <a class="sidebar-toggler" href="#"><span class="navbar-toggler-icon"></span></a>
                <button class="btn navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav d-flex align-items-center navbar-light ml-auto">
                        <li class="dropdown nav-icon">
                            <a href="#" data-toggle="dropdown" class="nav-link  dropdown-toggle nav-link-lg nav-link-user">
                                <div class="d-lg-inline-block">
                                    <i data-feather="bell"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-large">
                                <h6 class='py-2 px-4'>Notifications</h6>
                                <ul class="list-group rounded-none">
                                    <li class="list-group-item border-0 align-items-start">
                                        <div class="avatar bg-success mr-3">
                                            <span class="avatar-content"><i data-feather="shopping-cart"></i></span>
                                        </div>
                                        <div>
                                            <h6 class='text-bold'>New Order</h6>
                                            <p class='text-xs'>
                                                An order made by Ahmad Saugi for product Samsung Galaxy S69
                                            </p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="dropdown nav-icon mr-2">
                            <a href="#" data-toggle="dropdown" class="nav-link  dropdown-toggle nav-link-lg nav-link-user">
                                <div class="d-lg-inline-block">
                                    <i data-feather="mail"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#"><i data-feather="user"></i> Update Profile</a>
                                <a class="dropdown-item active" href="#"><i data-feather="mail"></i> Messages</a>
                                <a class="dropdown-item" href="#"><i data-feather="settings"></i> Settings</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#"><i data-feather="log-out"></i> Logout</a>
                            </div>
                        </li>
                        <li class="dropdown">
                            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                                <div class="avatar mr-1">
                                    @if(auth()->user()->UserInfo && auth()->user()->UserInfo->image !=null)
                                    <img src="{{ asset('Uploads/User/'.auth()->user()->UserInfo->image) }}" alt="" srcset="">
                                    @else
                                    <img src="{{ asset('sumit.jfif') }}" alt="" srcset="">
                                    @endif
                                </div>
                                <div class="d-none d-md-block d-lg-inline-block">Hi, {{ explode(" ",auth()->user()->name)[0]}}</div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="javascript:;" data-toggle="modal" data-target="#update-profile"><i data-feather="user"></i> Update Profile</a>
                                <a class="dropdown-item " href="javscript:;" data-toggle="modal" data-target="#update-password"><i data-feather="key"></i> Update Password</a>
                                <a class="dropdown-item" href="javascript:;" onclick="event.preventDefault();document.getElementById('logout').submit();"><i data-feather="log-out"></i> Logout</a>
                                {{Form::open(['url'=>route('logout'),'id'=>'logout'])}}
                                {{ Form::close()}}
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>                   
                    
                    
                    
                    <!--Update Profile- -->
                    <div class="modal fade text-left" id="update-profile" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel33" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-success">
                            <h4 class="modal-title" id="myModalLabel33">Update Profile </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                            </div>
                            {{ Form::open(['url'=>route('user.update',auth()->user()->id),'files'=>true])}}
                            @method('put')
                            <div class="modal-body">
                                {{ Form::label('name','Full-Name:')}}
                                <div class="form-group">
                                    {{ Form::text('name',auth()->user()->name ?? '',['class'=>'form-control form-control-sm '.($errors->has('name') ?'is-invalid':''),'required'=>true,'placeholder'=>'Enter Your Full Name Here........'])}}
                                @error('name')
                                    <div class="invalid-feedback">
                                        <i class="bx bx-radio-circle"></i>
                                        {{ $message}}
                                    </div>
                                @enderror
                                </div>
                                


                                {{ Form::label('address','Address:')}}
                                <div class="form-group">
                                    {{ Form::textarea('address',auth()->user()->UserInfo->address ?? '',['class'=>'form-control form-control-sm '.($errors->has('address') ?'is-invalid':''),'required'=>false,'placeholder'=>'Enter Your Address Here........','rows'=>4,'style'=>'resisze:none;'])}}
                                @error('address')
                                    <div class="invalid-feedback">
                                        <i class="bx bx-radio-circle"></i>
                                        {{ $message}}
                                    </div>
                                @enderror
                                </div>
                                


                                {{ Form::label('phone','Phone Num:')}}
                                <div class="form-group">
                                    {{ Form::tel('phone',auth()->user()->UserInfo->phone ?? '',['class'=>'form-control form-control-sm '.($errors->has('phone') ?'is-invalid':''),'required'=>false,'placeholder'=>'Enter Your Phone Number........'])}}
                                @error('phone')
                                    <div class="invalid-feedback">
                                        <i class="bx bx-radio-circle"></i>
                                        {{ $message}}
                                    </div>
                                @enderror
                                </div>
                                

                                {{ Form::label('image','Profile Image:')}}
                                <div class="form-group">
                                    {{ Form::file('image',['class'=>($errors->has('image') ?'is-invalid':''),'accept'=>'image/*'])}}
                                
                                @error('image')
                                    <div class="invalid-feedback">
                                        <i class="bx bx-radio-circle"></i>
                                        {{ $message}}
                                    </div>
                                @enderror
                                </div>
                                @if(auth()->user()->UserInfo && auth()->user()->UserInfo->image !=null)
                                    <div>
                                        <img src="{{ asset('Uploads/User/'.auth()->user()->UserInfo->image) }}" alt="" class=" img img-fluid img-thumbnail">
                                    </div>
                                @endif

                                

                            </div>
                            <div class="modal-footer">
                                {{ Form::button('<i data-feather="x"></i>Reset',['class'=>'btn btn-sm btn-danger','type'=>'reset'])}}

                                {{ Form::button('<i data-feather="send"></i> Update',['class'=>'btn btn-sm btn-success','type'=>'submit'])}}
                                
                                
                            </div>
                            {{ Form::close()}}
                        </div>
                        </div>
                    </div>     
                    <!--Update Profile--->


                    <!--Update Password- -->
                    <div class="modal fade text-left" id="update-password" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel33" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-success">
                            <h4 class="modal-title" id="myModalLabel33">Update Password </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                            </div>
                            {{ Form::open(['url'=>route('user.update-password',auth()->user()->id),'files'=>true])}}
                            @method('put')
                            <div class="modal-body">

                                {{ Form::label('password','New Password:')}}
                                <div class="form-group">
                                    {{ Form::password('password',['class'=>'form-control form-control-sm '.($errors->has('password') ?'is-invalid':''),'required'=>true,'placeholder'=>'Enter New Password........'])}}
                                @error('password')
                                    <div class="invalid-feedback">
                                        <i class="bx bx-radio-circle"></i>
                                        {{ $message}}
                                    </div>
                                @enderror
                                </div>

                                {{ Form::label('password_confirmation','Re-Type Password:')}}
                                <div class="form-group">
                                    {{ Form::password('password_confirmation',['class'=>'form-control form-control-sm '.($errors->has('password_confirmation') ?'is-invalid':''),'required'=>true,'placeholder'=>'Enter Password Again........'])}}
                                @error('password_confirmation')
                                    <div class="invalid-feedback">
                                        <i class="bx bx-radio-circle"></i>
                                        {{ $message}}
                                    </div>
                                @enderror
                                </div>


                                
                                

                            </div>
                            <div class="modal-footer">
                                {{ Form::button('<i data-feather="x"></i>Reset',['class'=>'btn btn-sm btn-danger','type'=>'reset'])}}

                                {{ Form::button('<i data-feather="send"></i> Update',['class'=>'btn btn-sm btn-success','type'=>'submit'])}}
                                
                                
                            </div>
                            {{ Form::close()}}
                        </div>
                        </div>
                    </div>     
                    <!--Update Password--->