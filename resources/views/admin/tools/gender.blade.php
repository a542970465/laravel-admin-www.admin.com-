<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <div class="btn-group" data-toggle="buttons">
        @foreach($options as $option => $label)
            <label class="btn btn-default btn-sm {{ \Request::get('gender', 'all') == $option ? 'active' : '' }}">
                <input type="radio" class="user-gender" value="{{ $option }}">{{$label}}
            </label>
        @endforeach
    </div>

</html>