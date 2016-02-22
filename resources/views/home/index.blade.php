@extends('master')

@section('title','Raffle Draw')

@section('content')
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-8">
            <h2 class="text-center text-primary">
               <i class="fa fa-trophy"></i> Raffle Draw Winner Generator
            </h2>
            <p>
                Running a raffle or pot-luck draw? Use us to not only randomly generate who wins; but also give the
                entrants the ability to check that everything is legit!<br>
                We store all winner generations and provide you a link to pass onto entrants should they want to
                double-check.
            </p>

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{route('raffle.create')}}" class="form-horizontal" role="form" id="create_form"
                  data-toggle="validator">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group has-feedback">
                    <label for="min_number" class="col-sm-2 control-label">
                       Start Number <span class="text-danger">*</span> <i class="fa fa-fw fa-sort-up"></i>
                    </label>
                    <div class="col-sm-10">
                        <input type="number" min="0" max="999999" data-min_max_val="min_max_val"
                               class="form-control input-lg" id="min_number" name="min_number" value="0" required/>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="form-group has-feedback">
                    <label for="max_number" class="col-sm-2 control-label">
                        End Number <span class="text-danger">*</span> <i class="fa fa-fw fa-sort-down"></i>
                    </label>
                    <div class="col-sm-10">
                        <input type="number" max="999999" data-min_max_val="min_max_val" class="form-control input-lg"
                               id="max_number" name="max_number" value="20" required/>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="form-group has-feedback">
                    <label for="max_winners" class="col-sm-2 control-label">
                        No. of Winners <span class="text-danger">*</span> <i class="fa fa-fw fa-ticket"></i>
                    </label>
                    <div class="col-sm-10">
                        <input type="number" max="999999" data-win_max_val="win_max_val" class="form-control input-lg"
                               id="max_winners" name="max_winners" value="1" required/>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="form-group has-feedback">
                    <label for="comment" class="col-sm-2 control-label">
                        Comment
                        <small>(optional)</small>
                        <i class="fa fa-fw fa-pencil"></i>
                    </label>
                    <div class="col-sm-10">
                        <input type="text" data-max-length="255" class="form-control input-md" id="comment"
                               name="comment" placeholder="Enter a comment if you want to"/>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-fw fa-ticket"></i> Run the Draw!
                        </button>
                        <br>
                        <span class="text-success"><small><em><i class="fa fa-fw fa-clock-o"></i> {{\Carbon\Carbon::now()->toAtomString()}}</em></small></span>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-2">
        </div>
    </div>

@endsection

@section('javascript')
    <script>
        $(document).ready(function () {

            function validate_min_max_val() {
                var mxVal = $('#max_number').val();
                var mnVal = $('#min_number').val();
                return (mxVal > mnVal);
            }

            function max_winners_val() {
                var mnVal = $('#min_number').val();
                var mxVal = $('#max_number').val();
                var count = mxVal - mnVal;
                var mxWin = $('#max_winners').val();
                return (count > mxWin);
            }

            $('#create_form').validator({
                custom: {
                    'min_max_val': function (el) {
                        return validate_min_max_val();
                    },
                    'win_max_val': function (el) {
                        return max_winners_val();
                    },
                },
                errors: {
                    min_max_val: "Your end number must be bigger than your start",
                    win_max_val: "You cannot have more winners than entrants"
                }
            });
        });
    </script>
@endsection