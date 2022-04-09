@extends('layouts.backend.app')

@section('title', 'Post')

@push('css')
<!-- Bootstrap Select Css -->
<link href="{{asset('assets/backend/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />
@endpush

@section('content')
<div class="container-fluid">

    <form action="{{route('admin.post.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Vertical Layout -->
        <div class="row clearfix">
            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Add New Post
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                    <li><a href="javascript:void(0);">Another action</a></li>
                                    <li><a href="javascript:void(0);">Something else here</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">


                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="title" class="form-control" name="title" placeholder="Enter post title">
                            </div>
                        </div>

                        <div class="form-froup">
                            <label for="image">Post Image</label>
                            <input type="file" id="image" name="image">
                        </div>

                        <div class="form-froup" style="margin-top: 10px;">
                            <input type="checkbox" id="publish" class="filled-in" name="status" value="1">
                            <label for="publish">publish</label>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Categories and Tags
                        </h2>
                    </div>
                    <div class="body">

                        <div class="form-group form-float">

                            <div class="form-line {{$errors->has('categories') ? 'focused error' : ''}}">
                                <label for="category">Select Category</label>
                                <select name="categories[]" id="category" class="form-control show-tick" multiple>
                                    @foreach( $categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group form-float">

                            <div class="form-line {{$errors->has('tags') ? 'focused error' : ''}}">
                                <label for="tag">Select Tag</label>
                                <select name="tags[]" id="tag" class="form-control show-tick" multiple>
                                    @foreach( $tags as $tag)
                                    <option value="{{$tag->id}}">{{$tag->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <a href="{{route('admin.post.index')}}" class="btn btn-danger m-t-15 waves-effect"> Back</a>

                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Body
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                    <li><a href="javascript:void(0);">Another action</a></li>
                                    <li><a href="javascript:void(0);">Something else here</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <textarea name="body" id="tinymce"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Vertical Layout -->
    </form>
</div>
@endsection

@push('js')
<!-- Select Plugin Js -->
<script src="{{asset('assets/backend/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>
<!-- TinyMCE -->
<script src="{{asset('assets/backend/plugins/tinymce/tinymce.js')}}"></script>

<!-- Editor.js file only for tinymce -->
<script>
    $(function() {
        //TinyMCE
        tinymce.init({
            selector: "textarea#tinymce",
            theme: "modern",
            height: 300,
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools'
            ],
            toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            toolbar2: 'print preview media | forecolor backcolor emoticons',
            image_advtab: true
        });
        tinymce.suffix = ".min";
        tinyMCE.baseURL = '{{asset('assets/backend/plugins/tinymce')}}';
    });
</script>
@endpush