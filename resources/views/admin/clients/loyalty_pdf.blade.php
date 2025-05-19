<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Client Loyalty Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>
<h2>Client Loyalty Report</h2>

<table>
    <thead>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Username</th>
        <th>Premium Level</th>
        <th>Cashback Rate (%)</th>
        <th>Total Spent ($)</th>
        <th>Total Cashback ($)</th>
    </tr>
    </thead>
    <tbody>
    @foreach($clients as $client)
        <tr>
            <td>{{ $client['name'] }}</td>
            <td>{{ $client['email'] }}</td>
            <td>{{ $client['username'] }}</td>
            <td>{{ $client['premium_level'] }}</td>
            <td>{{ number_format($client['cashback_rate'], 2) }}</td>
            <td>{{ number_format($client['total_payment'], 2) }}</td>
            <td>{{ number_format($client['total_cashback'], 2) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
