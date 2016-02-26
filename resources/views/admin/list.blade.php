@extends('master')

@section('title', 'RaffleDraw User')

@section('content')
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-8">
            <h2 class="text-center text-primary">
                RaffleDraw All
            </h2>
            <div class="well well-lg text-center">
                <table class="table table-striped">
                    <tr>
                        <th class="text-center" width="20%">Raffle ID</th>
                        <th class="text-center" width="40%%">Date / Time</th>
                        <th class="text-center">Comment</th>
                        <th class="text-center">User</th>
                    </tr>
                    @foreach($raffles as $raffle)
                        <tr>
                            <td><a href="{{route('raffle.show',$raffle->hash())}}">{{$raffle->hash()}}</a></td>
                            <td>{{Carbon::parse($raffle->request_time)->format('D j M Y H:i:s e')}}</td>
                            <td>{{$raffle->comment}}</td>
                            <td><a href="{{route('user.raffle.list',Helpers::encodeIP($raffle->user_ip))}}">{{Helpers::encodeIP($raffle->user_ip)}}</a></td>
                        </tr>
                    @endforeach
                </table>
                {!! $raffles->links() !!}
            </div>
        </div>
        <div class="col-md-2">
        </div>
    </div>
@endsection

@section('javascript')
@endsection