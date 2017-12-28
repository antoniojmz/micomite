<a style="width:145px;" href='{!! URL::route("$var_http") !!}' class="easyui-linkbutton" data-options="iconCls:'{{ $item['icon'] }}',size:'large'">
	<span id="{{ $item['icon'] }}"></span>
	<span class="easyui-linkbutton">
		{{$item['text']}}
	</span>
</a>