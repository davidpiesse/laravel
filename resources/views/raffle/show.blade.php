@extends('master')

@section('title', 'RaffleDraw Result')

@section('content')
    {{--{{dd($raffle)}}--}}
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-8">
            <h2 class="text-center text-primary">
                <i class="fa fa-fw fa-2x fa-trophy text-warning"></i> RaffleDraw Result
            </h2>
            <div class="well well-lg text-center">
                @if($raffle->winners == 1)
                    The winner was No. <span class="text-success lead"><b>{{$raffle->result}}</b></span>
                @elseif($raffle->winners > 1)
                    The winners were (in order):
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <table class="table table-striped">
                                @foreach($raffle->result as $key => $winner)
                                    <tr>
                                        <td>
                                            <span class="text-secondary text-center">{{\App\Helpers::ordinal($key+1)}}
                                                : </span> <span
                                                    class="text-success text-center lead"> <b>{{$winner}}</b></span>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                @endif
            </div>
            @if($showImage)
                <div class="well well-lg text-center">
                    <img alt="Embedded Image" src="data:image/png;base64,{{base64_encode(\App\Helpers::buildWidgetImage($raffle))}}" />
                </div>
            @endif

            @if($raffle->comment != "")
                <div class="well well-lg text-center">{{$raffle->comment}}</div>
            @endif
            <div class="well well-lg text-center">
                This raffle was run at {{\Carbon\Carbon::parse($raffle->request_time)->format('D j M Y H:i:s e')}}
                ({{\Carbon\Carbon::parse($raffle->request_time)->diffForHumans()}})<br>
                It created <b>{{$raffle->winners}}</b> {{str_plural('winner', $raffle->winners)}} between
                <b>{{$raffle->min}}</b>
                and <b>{{$raffle->max}}</b> by User <a
                        href="{{route('user.raffle.list',\App\Helpers::encodeIP($raffle->user_ip))}}">{{\App\Helpers::encodeIP($raffle->user_ip)}}</a>
                <img src="{{ Identicon::getImageDataUri(\App\Helpers::encodeIP($raffle->user_ip),16,16) }}"
                     alt="{{\App\Helpers::encodeIP($raffle->user_ip)}}"/>
            </div>
            <div class="well well-lg">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="input-group">
                            <input type="text" class="form-control " id="url"
                                   value="{{env('APP_URL')}}/{{$raffle->hash}}">
                                    <span class="input-group-btn">
                                        <button class="btn btn-success" data-clipboard-target="#url" type="button">
                                            Copy
                                        </button>
                                    </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
        </div>
    </div>

@endsection

@section('javascript')
    <script>
        $(document).ready(function () {
            var clipboard = new Clipboard('.btn');
        });
    </script>
@endsection