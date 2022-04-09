@extends('layouts.frontend.app')

@section('title')
{{ $author->name}}
@endsection

@push('css')
<link href="{{asset('assets/frontend/css/authors-profile/styles.css')}}" rel="stylesheet">

<link href="{{asset('assets/frontend/css/authors-profile/responsive.css')}}" rel="stylesheet">
@endpush

@section('content')
<div class="slider display-table center-text">
    <h1 class="title display-table-cell"><b>{{ $author->name }}</b></h1>
</div><!-- slider -->

<section class="blog-area section">
    <div class="container">

        <div class="row">

            <div class="col-lg-8 col-md-12">
                <div class="row">

                    @if($posts->count() > 0)
                    @foreach($posts as $post)
                    <div class="col-md-6 col-sm-12">
                        <div class="card h-100">
                            <div class="single-post post-style-1">

                                <div class="blog-image"><img src="{{Storage::disk('public')->url('post/'.$post->image)}}" alt="Blog Image"></div>

                                <a class="avatar" href=" {{ route('author.profile',$post->user->username) }} "><img src="{{Storage::disk('public')->url('profile/'.$author->images)}}" alt="Profile Image"></a>

                                <div class="blog-info">
                                    <h4 class="title"><a href="{{route('post.details', $post->slug)}}"><b> {{ $post->title }} </b></a></h4>

                                    <ul class="post-footer">
                                        <i class="ion-heart"></i>{{ $post->favorite_to_users->count() }}</a>
                                        <li><a href="#"><i class="ion-chatbubble"></i>{{$post->comments->count()}}</a></li>
                                        <li><a href="#"><i class="ion-eye"></i>{{$post->view_count}}</a></li>
                                    </ul>

                                </div><!-- blog-info -->

                            </div><!-- single-post -->

                        </div><!-- card -->
                    </div><!-- col-md-6 col-sm-12 -->
                    @endforeach

                    @else
                    <div class="col-md-6 col-sm-12">
                        <div class="card h-100">
                            <div class="single-post post-style-1">

                                <div class="blog-info">
                                    <h4 class="title"><b>Sorry No Post Found :(</b></h4>

                                </div><!-- blog-info -->

                            </div><!-- single-post -->

                        </div><!-- card -->
                    </div><!-- col-md-6 col-sm-12 -->

                    @endif


                </div><!-- row -->

               <!-- <a class="load-more-btn" href="#"><b>LOAD MORE</b></a>  -->

            </div><!-- col-lg-8 col-md-12 -->

            <div class="col-lg-4 col-md-12 ">

                <div class="single-post info-area ">

                    <div class="about-area">
                        <h4 class="title"><b>About Author</b></h4>
                        <b>{{ $author->name }}</b><br>
                        <p>{{ $author->about }}</p>
                        <b>Author Since: {{ $author->created_at->toDateString() }}</b><br>
                        <b>Total Post: {{ $post->count() }} </b>
                    </div>



                </div><!-- info-area -->

            </div><!-- col-lg-4 col-md-12 -->

        </div><!-- row -->

    </div><!-- container -->
</section><!-- section -->
@endsection


@push('js')

@endpush