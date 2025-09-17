<!DOCTYPE html>
<html>
<head>
	<title>Namaste Nepal</title>
</head>
<body>
	<h3>Customized Trip</h3>

	Trip: {{ $body['trip']['name'] }} <br>
	Duration: {{ $body['duration'] }} Days<br>
	No. of Travellers: {{ $body['no_of_travellers'] }}<br>
	Departure Date: {{ $body['departure_date'] }}<br>
	Price Range: {{ $body['price_range'] }}<br>
	Difficulty: {{ $body['difficulty'] }}<br>
	Customized By: {{ $body['name'] }} <br>
	Country: {{ $body['country'] }} <br>
	Email: {{ $body['email'] }} <br>
	Address: {{ $body['address'] }} <br>
	Contact No: {{ $body['contact_no'] }} <br>
	Message: {{ $body['message'] }} <br>

	<h4>Traveller Information</h4>
	IP Address: {{ $body['ip_address'] }}
</body>
</html>