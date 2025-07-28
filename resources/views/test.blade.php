<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Test</title>
</head>
<body>
	<form action="{{ url('/sim') }}" method="post" enctype="multipart/form-data">
		@csrf
		<input name="file" type="file" />
		<button type="submit">Submit</button>
	</form>
</body>
</html>