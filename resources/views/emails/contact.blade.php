<!DOCTYPE html>
<html>
<head>
	<title>Namaste Nepal</title>
</head>
<body>
	<h3>Enquiry</h3>

	Name: {{ $body['name'] ?? '' }} <br>
	Email: {{ $body['email'] ?? '' }} <br>
	Country: {{ $body['country'] ?? '' }} <br>
	Phone No: {{ $body['phone'] ?? '' }} <br>
	Message: {{ $body['message'] ?? '' }} <br>
	
    @if (isset($body['redirect_url']) && !empty($body['redirect_url']))
        Requested from trip page: <a href="{{ $body['redirect_url'] }}">{{ $body['redirect_url'] }}</a>
    @endif
	<h4>Traveller Information</h4>
	IP Address: {{ $body['ip_address'] }}
</body>
</html>
