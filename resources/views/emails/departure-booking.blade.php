<!DOCTYPE html>
<html>

<head>
    <title>New Departure Booking</title>
</head>

<body style="font: ui-sans-serif, system-ui, sans-serif; background: #f7f7ff">
    <table style="width: 100%;">
        <tr>
            <td style="text-align: center; padding: 16px;">
                <table>
                    <tr>
                        <td style="background: #ffffff; padding: 20px; text-align:left">
                            <h1 style="font-size:1.5rem;font-weight:600;padding:2px;">New Departure Booking received</h1>
                            <h2 style="font-size:1.5rem;font-weight:600;padding:2px;">Trip Details</h2>
                            <table>
                                <tr style="border-top: 1px solid #e5e5e5;border-bottom: 1px solid #e5e5e5;">
                                    <td style="padding:2px;">Trip</td>
                                    <td style="padding:2px;">{{ $body['trip_name'] }}</td>
                                </tr>
                                <tr style="border-top: 1px solid #e5e5e5;border-bottom: 1px solid #e5e5e5;">
                                    <td style="padding:2px;">From</td>
                                    <td style="padding:2px;">{{ $body['from_date'] }}</td>
                                </tr>
                                <tr style="border-top: 1px solid #e5e5e5;border-bottom: 1px solid #e5e5e5;">
                                    <td style="padding:2px;">To</td>
                                    <td style="padding:2px;">{{ $body['to_date'] }}</td>
                                </tr>
                                <tr style="border-top: 1px solid #e5e5e5;border-bottom: 1px solid #e5e5e5;">
                                    <td style="padding:2px;">Status</td>
                                    <td style="padding:2px;">{{ $body['status_info'] }}</td>
                                </tr>
                                <tr style="border-top: 1px solid #e5e5e5;border-bottom: 1px solid #e5e5e5;">
                                    <td style="padding:2px;">No. of Travellers</td>
                                    <td style="padding:2px;">{{ $body['no_of_travellers'] }}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #e5e5e5;">
                                    <td style="padding:2px;">Preferred Departure Date</td>
                                    <td style="padding:2px;">{{ $body['preferred_departure_date'] }}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #e5e5e5;">
                                    <td style="padding:2px;">Message</td>
                                    <td style="padding:2px;">{{ $body['emergency_contact'] }}</td>
                                </tr>
                            </table>
                            <h2 style="font-size:1.5rem;font-weight:600;padding:2px;">Booked by</h2>
                            <table>
                                <tr style="border-bottom: 1px solid #e5e5e5;">
                                    <td style="padding:2px;">Name</td>
                                    <td style="padding:2px;">{{ $body['first_name'] . ' ' . $body['middle_name'] . ' ' . $body['last_name'] }}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #e5e5e5;">
                                    <td style="padding:2px;">Country</td>
                                    <td style="padding:2px;">{{ $body['country'] }}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #e5e5e5;">
                                    <td style="padding:2px;">Email</td>
                                    <td style="padding:2px;">{{ $body['email'] }}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #e5e5e5;">
                                    <td style="padding:2px;">Contact no</td>
                                    <td style="padding:2px;">{{ $body['contact_no'] }}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #e5e5e5;">
                                    <td style="padding:2px;">Gender</td>
                                    <td style="padding:2px;">{{ ucfirst($body['gender']) }}</td>
                                </tr>
                            </table>

                            <p>IP Address: {{ $body['ip_address'] }}</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
