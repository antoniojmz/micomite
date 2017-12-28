
<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="UTF-8">
	<title>Document</title>
</head>

	<body style="margin:0;padding:0;font-family:tahoma,arial,verdana,sans-serif;background:#eeeeee;font-size:12px;color:#333333;">
		<div style="max-width:480px;margin-bottom:10px;margin-top:0px;margin-left:auto;margin-right:auto;background:#ffffff;">
			<div style="padding-top:20px;padding-right:20px;padding-bottom:20px;padding-left:20px;border-bottom:#eeeeee 1px solid;">

				<a href="{{ URL::route('home') }}" style="font-size:14px;font-weight:700;text-decoration:none;color:#333333;">
					{{ $app_name_project }}
				</a>

			</div>

			<div style="padding-top:20px;padding-right:20px;padding-bottom:40px;padding-left:20px;">

				<h1 style="font-size:16px;color:#666666;padding:0;margin-left:0;margin-right:0;margin-top-0;margin-bottom:20px;font-weight:normal;">
					{{ $title }}
				</h1>

				@yield ('content')

			</div>
		</div>

		@if (View::hasSection('footer'))
			<div style="max-width:480px;color:#888888;margin-left:auto;margin-right:auto;font-size:10px;padding:0 10px;margin-bottom:30px;text-align:center;">

				@yield ('footer')

			</div>
		@endif

	</body>
</html>