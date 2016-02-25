@extends('master')

@section('metatags')
    {{--<link rel="canonical" href="http://yoursite.com/product.php?p =david+walsh+blog+book" />--}}
    <meta property="og:url" content="{{Request::url()}}"/>
    <meta property="og:image" content="{{route('raffle.image',$raffle->hash())}}"/>
    <meta property="og:image:width" content="470"/>
    <meta property="og:image:height" content="246"/>
    <meta property="og:title" content="{{'RaffleDraw '.str_plural('Winner', $raffle->winners).' '. \App\Helpers::resultToString($raffle->result)}}"/>
@endsection

@section('title', 'RaffleDraw '.str_plural("Winner", $raffle->winners).' '. \App\Helpers::resultToString($raffle->result))

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
                                            @if($raffle->order_winners)
                                            <span class="text-secondary text-center">
                                                {{\App\Helpers::ordinal($key+1)}}
                                                : </span>
                                            @endif
                                            <span class="text-success text-center lead"> <b>{{$winner}}</b></span>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                @endif
            </div>

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
            @if($showImage)
                <div class="well well-lg text-center">
                    {{--add copy link for facebook--}}
                    <link rel="image_src" href="{{route('raffle.image',$raffle->hash())}}"/>
                    {{--                    <img alt="Embedded Image" src="data:image/png;base64,{{base64_encode(\App\Helpers::buildWidgetImage($raffle))}}" />--}}
                    <img class="text-center img-responsive img-rounded" alt="Embedded Image"
                         src="{{route('raffle.image',$raffle->hash())}}"/>
                </div>
            @endif

            <div class="well">
                <ul class="social-buttons list-inline text-center">
                    <li>
                        <a href="http://www.facebook.com/sharer.php?u={{route('raffle.image',$raffle->hash())}}&t=RaffleDraw" class="socialite facebook-like" data-href="{{route('raffle.image',$raffle->hash())}}" data-send="false" data-layout="box_count" data-width="60" data-show-faces="false" rel="nofollow" target="_blank"><span class="vhidden">Share on Facebook</span></a>
                    </li>
                    <li>
                        <a href="http://twitter.com/share" class="socialite twitter-share" data-text="RaffleDraw" data-url="{{route('raffle.image',$raffle->hash())}}" data-count="vertical" rel="nofollow" target="_blank"><span class="vhidden">Share on Twitter</span></a>
                    </li>
                    <li>
                        <a href="https://plus.google.com/share?url={{route('raffle.image',$raffle->hash())}}" class="socialite googleplus-one" data-size="tall" data-href="{{route('raffle.image',$raffle->hash())}}" rel="nofollow" target="_blank"><span class="vhidden">Share on Google+</span></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-2">
        </div>
    </div>

@endsection

@section('javascript')
    <script>
        $(document).ready(function () {
            //clipboard -add tooltip
            var clipboard = new Clipboard('.btn');
            //social
            Socialite.load();
        });
    </script>
@endsection