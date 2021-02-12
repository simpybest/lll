@extends('layouts.layout')
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">{{$post->title}}</div>

                <!-- /.card-header -->
                <div class="card-body">
                    <div class="card-img card-img__max" style="background-image: url({{$post->img ?? asset('img/123.jpg')}})"></div>
                    <!-- /.card-img -->
                    <div class="card-descr">Описание: {{$post->desc}}</div>
                    <!-- /.card-descr -->
                    <!-- /.card-author -->
                    <div class="card-categoty">Категория: {{$post->category}}</div>
                    <div class="card-date">Создана: {{$post->created_at->diffForHumans()}}</div>
                    <div class="card-status">Статус: {{$post->status}}</div>
                    <!-- /.card-author -->
                    <div class="card-btn">
                        <a href="{{route('post.index')}}" class="btn btn-outline-dark show-btn">Главная</a>
                        @auth()
                            @if(Auth::user()->id == $post->author_id)
                                <a href="{{route('post.edit', ['id'=>$post->post_id])}}" class="btn btn-outline-success show-btn">Редактировать</a>
                                <form action="{{route('post.destroy', ['id'=>$post->post_id])}}" method="post">

                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" class="btn btn-outline-danger show-btn" value="Удалить">
                                </form>
                            @endif
                        @endauth
                    </div>

                    <!-- /.card-btn -->
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col-6 -->
    </div>
    <!-- /.row -->


@endsection





