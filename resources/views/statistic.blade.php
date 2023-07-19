<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Statistic Dashboard</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body class="antialiased">
    <div class="center">
        <h2>Task 1: List of 5 hotels with the smallest number of weekend stays</h2>
        <table class="table table-dark table-striped center custom-border custom-table">
            <thead>
            <tr>
                <th scope="col" class="first-column">ID</th>
                <th scope="col" class="second-column">Hotel</th>
                <th scope="col" class="third-column">Weekend Stays</th>
            </tr>
            </thead>
            <tbody>
            @foreach($task1 as $item)
                <tr>
                    <th scope="row">{{$item['hotel_id']}}</th>
                    <td>{{$item['hotel_name']}}</td>
                    <td>{{$item['weekend_stays']}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <h2>Task 2: List of hotels and dates where we had to reject customers</h2>
        <table class="table table-dark table-striped center custom-border custom-table">
            <thead>
            <tr>
                <th scope="col" class="first-column">ID</th>
                <th scope="col" class="second-column">Hotel</th>
                <th scope="col" class="third-column">Dates</th>
            </tr>
            </thead>
            <tbody>
            @foreach($task2 as $item)
                <tr>
                    <th scope="row">{{$item['id']}}</th>
                    <td>{{$item['name']}}</td>
                    <td>
                        @foreach($item['dates'] as $tt)
                            {{$tt}}
                            <br>
                        @endforeach
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <h2>Task 3: The day when we lost the most due to rejection</h2>
        <table class="table table-dark table-striped center custom-border custom-table">
            <thead>
            <tr>
                <th scope="col" class="first-column">Clarification</th>
                <th scope="col" class="second-column">Date</th>
                <th scope="col" class="third-column">Lost</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th scope="row">Processing dates ONLY with available information about capacity</th>
                <td>{{$task3['date']}}</td>
                <td>{{$task3['value']}}</td>
            </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
