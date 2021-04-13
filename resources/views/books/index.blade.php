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

<div class="container">
  <div class="row align-items-center justify-content-center">
      <div class="col-md-8">
          <div class="card">
              <div class="card-header">{{ __('Checkout') }}</div>
              @if(session()->has('message'))

                <div class="alert {{session('alert') ?? 'alert-info'}}">
                  {{ session('message') }}
                </div>
                @endif
              <div class="card-body">
                <form method="POST" action="/action">
                      @csrf

                      <div class="form-group row">
                          <label for="isbn" class="col-md-4 col-form-label text-md-right">{{ __('ISBN Number') }}</label>

                          <div class="col-md-6">
                              <input id="isbn" type="isbn" class="form-control @error('isbn') is-invalid @enderror" name="isbn" value="{{ old('isbn') }}" required autocomplete="isbn" autofocus>

                              @error('isbn')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="form-group row">
                      <label for="action" class="col-md-4 col-form-label text-md-right">{{ __('Action') }}</label>

                      <div class="col-md-6">

                      <select class="form-select" aria-label="Action" class="form-control @error('action') is-invalid @enderror" name="action" value="{{ old('action') }}" required>
                        <option selected>Open this select menu</option>
                        <option value="checkin">Checkin</option>
                        <option value="checkout">Checkout</option>
                      </select>

                      @error('action')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                      </div>
                      </div>

                      <div class="form-group row mb-0">
                          <div class="col-md-8 offset-md-4">
                              <button type="submit" class="btn btn-primary">
                                  {{ __('Submit') }}
                              </button>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
</div>
 
@endsection