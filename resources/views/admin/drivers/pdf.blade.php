<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #444;
        }
        th, td {
            padding: 8px;
            font-size: 14px;
            text-align: left;
        }
    </style>
</head>
<body>
<h2>Approved Drivers List</h2>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Plate Number</th>
        <th>Pricing Model</th>
        <th>Registered At</th>
    </tr>
    </thead>
    <tbody>
    @foreach($drivers as $driver)
        <tr>
            <td>{{ $driver->id }}</td>
            <td>{{ $driver->first_name }}</td>
            <td>{{ $driver->email }}</td>
            <td>{{ $driver->phone }}</td>
            <td>{{ $driver->plate_number }}</td>
            <td>{{ ucfirst(str_replace('_', ' ', $driver->pricing_model)) }}</td>
            <td>{{ $driver->created_at->format('Y-m-d H:i') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
