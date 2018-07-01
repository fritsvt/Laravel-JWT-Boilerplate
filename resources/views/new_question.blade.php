@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4">Nieuwe vraag maken</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <form action="" method="post" enctype="multipart/form-data">
                    <b>Categorie</b>
                    <select name="category" class="form-control mb-4">
                        @foreach($categories as $category)
                            <option @if($cur_cat == $category->id) selected @endif value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                    <b>Vraag</b>
                    <textarea class="form-control mb-4" name="question" cols="30" rows="2" placeholder="vraag invullen"></textarea>

                    <b>Antwoorden</b>
                    <textarea class="form-control mb-4" name="answers" cols="30" rows="2" placeholder="Antwoorden | seperated"></textarea>

                    <b>Correct antwoord</b>
                    <input type="text" class="form-control mb-4" name="correct_answer" placeholder="Correct antwoord">

                    <b>Uitleg</b>
                    <textarea class="form-control mb-4" name="explanation" cols="30" rows="3" placeholder="Uitleg bij vraag antwoord"></textarea>

                    <b>Afbeelding selecteer bestand of plaats url</b>
                    <input type="text" name="image_url" class="form-control mb-4" placeholder="Afbeelding url">
                    <input type="file" class="form-control mb-4" name="image">

                    <input type="submit" class="btn btn-info w-100">

                    {{csrf_field()}}
                </form>
            </div>
        </div>
    </div>
@endsection