@extends('layouts.layout')
@section('content')
    @if(isset($_GET['search']))
        @if(count($posts)>0)
            <h2>Результаты поиска по запросу "<?=$_GET['search']?>"</h2>
            <p class="lead">
                <?php
                function declOfNum($num, $titles) {
                    $cases = array(2, 0, 1, 1, 1, 2);
                    return $num . " " . $titles[($num % 100 > 4 && $num % 100 < 20) ? 2 : $cases[min($num % 10, 5)]];
                }
                function desc_title($num, $titles){
                    $cases = array(2, 0, 1, 1, 1, 2);
                    return $titles[($num % 100 > 4 && $num % 100 < 20) ? 2 : $cases[min($num % 10, 5)]];
                }
                echo desc_title(count($posts), array('найден ', 'найдено ', 'найдено '));
                echo declOfNum(count($posts), array('пост', 'поста', 'постов'));
                ?>
            </p>
            <a href="{{route('post.index')}}">Посмотреть все посты</a>
        @else
            <h2>По запросу "<?=$_GET['search']?>"ничего не найдено</h2>
            <a href="{{route('post.index')}}">Посмотреть все посты</a>
        @endif
    @endif





    <div class="row">
        @foreach($posts as $post)
            <div class="col-6">
                <div class="card">
                    <div class="card-header">{{$post->short_title}}</div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="card-img" style="background-image: url({{$post->img ?? asset('img/123.jpg')}})"></div>
                        <!-- /.card-img -->
                        <!-- /.card-author -->
                        <div class="card-categoty">Категория: {{$post->category}}</div>

                        <div class="card-status">Статус: {{$post->status}}</div>
                        @guest
                            <a href="{{route('post.show',['id'=>$post->post_id])}}" class="btn btn-outline-dark">Посмотреть пост</a>
                        @endguest
                        @if (Auth::check())
                        @if (Auth::user()->admin != "yes")
                        <a href="{{route('post.show',['id'=>$post->post_id])}}" class="btn btn-outline-dark">Посмотреть пост</a>
                        @endif

                        @if (Auth::user()->admin == "yes")
                            <div class="d-flex">
                            <a href="{{route('post.edit', ['id'=>$post->post_id])}}" class="btn btn-outline-success show-btn">Сменить статус</a>
                                <form action="{{route('post.destroy', ['id'=>$post->post_id])}}" method="post">

                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" class="btn btn-outline-danger show-btn" value="Удалить">
                                </form>
                            </div>
                        @endif
                        @endif


                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col-6 -->
        @endforeach
    </div>
    <!-- /.row -->



    @if(!isset($_GET['search']))
        {{$posts->links()}}
    @endif
@endsection



