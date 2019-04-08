<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>paypal Test</title>
    <link rel="stylesheet" href="">
</head>
<body>
    <form action="{{route('create-payment')}}" method="POST">
    	@csrf
    	<input type="submit" value="Pay Now">
    </form>
</body>
</html>
