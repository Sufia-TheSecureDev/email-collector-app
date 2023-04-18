@extends('master')
@section('title')
 Email Collector App 
@endsection
@section('content')
    <div class="container">
        @include('partials.messages')

        <div class="row">
            <div class="col-12 col-md-6">
                <form action="{{ route('emails.store') }}" method="POST">
                    @csrf
                    <label for="emails" class="form-label">Emails  : </label>
                    <textarea rows="5" cols="90" class="form-control" name="emails" id="emails"
                        placeholder="Write emails by comma separator for bulk operation.{{ PHP_EOL }}Ex: sufia@example.com, sania@gmail.com"></textarea>

                    <div class="my-3">
                        <button type="submit" class="btn btn-primary">
                            Insert
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-12 col-md-6">
                <div class="p-4 shadow bg-white">
                    <h2> Search Emails :</h2>
                    <form action="" method="get" class="my-4">
                        <input type="search" value="{{ request()->search }}" name="search" placeholder="Search"
                            class="form-control">
                    </form>

                    <div class="table-responsive">
                        <table class="table table-border table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Email</th>
                                    <th>Updated at</th>
                                    <th>
                                        <span class="sr-only">
                                            Delete
                                        </span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($emails as $email)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>
                                            <a href="mailto:{{ $email->email }}" target="_blank">
                                                {{ $email->email }}
                                            </a>
                                        </td>
                                       
                                        <td>
                                            {{-- {{ \Carbon\Carbon::parse($email->updated_at)->diffForHumans() }}  --}}

                                            {{ \Carbon\Carbon::parse($email->updated_at)->format('l, F jS, Y') }}
                                        </td>

                                        
                                        <td>
                                            {{-- data delete without confirmation --}}
                                            {{-- <form action="{{ route('emails.destroy', $email->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger btn-sm delete" >
                                                    Delete
                                                </button>
                                            </form> --}}
                                            
                                            {{-- data delete   after  confirmation --}}
                                            <a href="{{ route('emails.destroy', $email->id) }}" title="Delete"   class="btn btn-danger btn-sm  delete" >
                                               Delete
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $emails->links() }}
                </div>
            </div>
        </div>

    </div>
@endsection