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
                echo desc_title(count($posts), array('найдена ', 'найдено ', 'найдено '));
                echo declOfNum(count($posts), array('заявка', 'заявки', 'заявок'));
                ?>
            </p>
            <a href="{{route('post.index')}}">Посмотреть все заявки</a>
        @else
            <h2>По запросу "<?=$_GET['search']?>"Ничего не найдено</h2>
            <a href="{{route('post.index')}}">Посмотреть все заявки</a>
        @endif
    @endif

    <?
    if (Auth::check()) {
        $user = Auth::user()->id;
    }?>
    <h2 style="margin-top: 20px">Ваши заявки:</h2>
    <div class="row">
        @foreach($posts as $post)
            @if($post->author_id == $user)
            <div class="col-6">
                <div class="card">
                    <div class="card-header">{{$post->short_title}}</div>
                    <!-- /.card-header -->
                    <div class="card-body">
                            <div class="card-img" style="background-image: url({{$post->img ?? asset('img/asset_pic.png')}}); margin-left: 0px"></div>
                        <!-- /.card-img -->
                        <div class="card-author">Питомец: {{$post->alias}}</div>
                        <!-- /.card-author -->
                        <div class="card-categoty">Категория: {{$post->category}}</div>
                        <div class="card-date">Создана: {{$post->created_at}}</div>
                        <div class="card-status">Статус: {{$post->status}}</div>
                        <a href="{{route('post.show',['id'=>$post->post_id])}}" class="btn btn-outline-dark">Посмотреть пост</a>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            @endif
            <!-- /.col-6 -->
        @endforeach
    </div>
    <!-- /.row -->



    @if(!isset($_GET['search']))
        {{$posts->links()}}
    @endif
@endsection



