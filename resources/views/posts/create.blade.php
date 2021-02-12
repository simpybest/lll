@extends('layouts.layout')
@section('content')
    <form action="{{route('post.store')}}" method="post" enctype="multipart/form-data" class="create_post">
        @csrf
        <h2>Создание заявки</h2>
        <input type="text" name="title" class="form-control form-p" required id="floatingInputValue" placeholder="Заголовок">
        <div class="form-floating">
            <textarea class="form-control" name="desc" rows="10" id="floatingTextValue" placeholder="Напишите описание здесь" required></textarea>
            <label for="floatingTextValue" style="color: gray">Описание</label>
            <!-- /# -->
        </div>

        <div class="form-floating select-block form-p mb-5">
            <select id="floatingSelectValue" name="category" class="form-select form-select-lg mb-5" aria-label=".form-select-lg example" required>
                <option value="Ремонт">Ремонт</option>
                <option value="Ремонт">Ремонт</option>
                <option value="Ремонт">Ремонт</option>
            </select>
            <label for="floatingSelectValue" style="color: gray">Категория</label>
        </div>



        <!-- /# -->
        <div class="submiting">
            <input type="file" name="img">
            <button type="submit" class="btn btn-dark">Создать заявку</button>
        </div>
    </form>
@endsection
