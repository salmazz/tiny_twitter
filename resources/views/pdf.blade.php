<html>
<head>
    <title>Pdf report</title>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>
<body>
<h2>Report </h2>
<table class="table">
    <thead>
    <tr>
        <th>Name</th>
        <th>Tweets Count</th>
    </tr>
    </thead>
    <tbody>
    @forelse($users as $user)
        <tr>
            <td> {{ $user->name }} </td>
            <td> {{$user->tweets_count}}</td>
        </tr>
    @empty
    @endforelse
    </tbody>
</table>
<p>Average of tweets => {{ $average }}</p>
</body>
</html>


