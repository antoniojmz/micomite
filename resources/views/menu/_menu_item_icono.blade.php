@if (strpos($var_icon, '.') !== false)
<img src='{!! asset("img/$var_icon") !!} ' >&nbsp;
@else
<i class="{{ $var_icon }}"></i>&nbsp;
@endif