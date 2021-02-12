@extends('layouts.layout')
@section('content')
    <form action="{{route('post.update',['id'=>$post->post_id])}}" method="post" enctype="multipart/form-data" class="create_post">
        @csrf
        @method('PATCH')
        <h2>Редактировать заявку</h2>
        <input name="title" type="text" class="form-control form-p" required id="floatingInputValue" placeholder="Title" value="{{$post->title ?? ''}}">
        <div class="form-floating form-p">
            <textarea class="form-control" name="desc" rows="10" placeholder="Leave a comment here" id="floatingTextarea" required>{{$post->desc ?? ''}}</textarea>
            <label for="floatingTextarea">Comments</label>
        </div>
        <div class="form-floating select-block form-p">
            <select id="floatingSelectValue" name="category" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" required>
                <option style="display: none" selected value="{{$post->category}}">{{$post->category}}</option>
                <option value="Ремонт">Ремонт</option>
                <option value="Ремонт">Ремонт</option>
                <option value="Ремонт">Ремонт</option>
            </select>
            <label for="floatingSelectValue" style="color: gray">Категория</label>
        </div>
        @if (Auth::user()->admin == "yes")
            <div class="form-floating select-block form-p">
                <select id="floatingSelectValue" name="status" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                    <option style="display: none" selected value="{{$post->status}}">{{$post->status}}</option>
                    <option value="Новая">Новая</option>
                    <option value="Решена">Решена</option>
                    <option value="Отклонена">Отклонена</option>
                </select>
                <label for="floatingSelectValue" style="color: gray">Статус</label>
            </div>
        @endif
        <div class="submiting form-p">
            <input name="img" type="file">
            <button type="submit" class="btn btn-primary">Редактировать</button>
        </div>
    </form>

@endsection

