@extends('master')
@section('metatags')
    {{--<link rel="canonical" href="http://yoursite.com/product.php?p =david+walsh+blog+book" />--}}
    <meta property="og:url" content="{{Request::url()}}"/>
    <meta property="og:image" content="{{route('raffle.image',$raffle->hash())}}"/>
    <meta property="og:image:width" content="470"/>
    <meta property="og:image:height" content="246"/>
    <meta property="og:title"
          content="{{'RaffleDraw '.str_plural('Winner', $raffle->winners).' '. Helpers::resultToString($raffle->result)}}"/>
@endsection

@section('title', 'RaffleDraw '.str_plural("Winner", $raffle->winners).' '. Helpers::resultToString($raffle->result))

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
                    The winner was @if($raffle->type == 'raffle') No.@endif <span
                            class="text-success lead"><b>{{$raffle->result}}</b></span>
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
                                                {{\Helpers::ordinal($key+1)}}
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
                This raffle was run at {{Carbon::parse($raffle->request_time)->format('D j M Y H:i:s e')}}
                ({{Carbon::parse($raffle->request_time)->diffForHumans()}})<br>
                It created <b>{{$raffle->winners}}</b> {{str_plural('winner', $raffle->winners)}}
                @if($raffle->type == 'raffle')
                    between <b>{{$raffle->min}}</b> and <b>{{$raffle->max}}</b>
                @else

                @endif
                by User <a
                        href="{{route('user.raffle.list',Helpers::encodeIP($raffle->user_ip))}}">{{Helpers::encodeIP($raffle->user_ip)}}</a>
                <img src="{{ Identicon::getImageDataUri(Helpers::encodeIP($raffle->user_ip),16,16) }}"
                     alt="{{Helpers::encodeIP($raffle->user_ip)}}"/>
            </div>
            <div class="well well-lg">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="input-group">
                            <input type="text" class="form-control " id="url"
                                   value="{{env('APP_URL')}}/{{$raffle->hash}}">
                                    <span class="input-group-btn">
                                        <button class="btn btn-success" data-clipboard-target="#url" type="button"
                                                data-toggle="tooltip" data-placement="bottom" title="Copied">
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
                    <img class="text-center img-responsive img-rounded thumbnail" alt="Embedded Image"
                         src="{{route('raffle.image',$raffle->hash())}}"/>
                </div>
            @endif

            @if($raffle->type != "raffle")
                <div class="well">
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <h3 class="text-center">Entrants</h3>
                            <ul class="list-group">
                                @foreach($raffle->custom_array as $entrant)
                                    <li class="list-group-item">
                                        {{--check for winner and add star--}}
                                        @if(is_array($raffle->result))
                                            @if(in_array($entrant,$raffle->result))
                                                <span class="badge"><i class="fa fa-star fa-fw text-warning"></i></span>
                                            @endif
                                        @else
                                            @if($entrant ==$raffle->result)
                                                <span class="badge"><i class="fa fa-star fa-fw text-warning"></i></span>
                                            @endif
                                        @endif
                                        {{$entrant}}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="well">
                <ul class="social-buttons list-inline text-center">
                    <li>
                        <a href="http://www.facebook.com/sharer.php?u={{route('raffle.image',$raffle->hash())}}&t=RaffleDraw"
                           class="socialite facebook-like" data-href="{{route('raffle.image',$raffle->hash())}}"
                           data-send="false" data-layout="box_count" data-width="60" data-show-faces="false"
                           rel="nofollow" target="_blank"><span class="vhidden">Share on Facebook</span></a>
                    </li>
                    <li>
                        <a href="http://twitter.com/share" class="socialite twitter-share" data-text="RaffleDraw"
                           data-url="{{route('raffle.image',$raffle->hash())}}" data-count="vertical" rel="nofollow"
                           target="_blank"><span class="vhidden">Share on Twitter</span></a>
                    </li>
                    <li>
                        <a href="https://plus.google.com/share?url={{route('raffle.image',$raffle->hash())}}"
                           class="socialite googleplus-one" data-size="tall"
                           data-href="{{route('raffle.image',$raffle->hash())}}" rel="nofollow" target="_blank"><span
                                    class="vhidden">Share on Google+</span></a>
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
            var clipboard = new Clipboard('.btn');
            Socialite.load();
            $('[data-toggle="tooltip"]').tooltip()
        });
    </script>
@endsection