@extends('layouts.app')

@section('content')
<div class="container">
<div class="table-responsive">
<table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Title</th>
      <th scope="col">ISBN</th>
      <th scope="col">Publication date</th>
      <th scope="col">Status</th>
    </tr>
  </thead>
  <tbody>
  @foreach($books as $book)
    <tr>
      <th scope="row">{{$book->id}}</th>
      <td>{{$book->title}}</td>
      <td>{{$book->isbn}}</td>
      <td>{{$book->publication_date}}</td>
      <td>{{$book->status}}</td>
    </tr>
    @endforeach
    
  </tbody>
</table>
</div>

<ul class="pagination justify-content-center mb-4">
  {{$books->links()}}
</ul>
</div>
@endsection