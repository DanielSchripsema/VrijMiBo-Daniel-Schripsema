 <!DOCTYPE html>
<html lang="en">
<head>
    <title>Internship Assignment VrijMiBo</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="/CSS/main.CSS">
</head>
<body>

<div class="header">
    <h1>Internship Assignment VrijMiBo</h1>
    <p>Made by Daniel Schripsema</p>
</div>

<div class="topnav">

</div>

<div class="row">
    <div class="column">
        <h2>Questions</h2>
        <h3>Question 1</h3>
        <p>How many orders have been placed?</p>
        <p>Answer: {{$Question1}}</p>
        <h3>Question 2</h3>
        <p> Who spent the most money?</p>
        <p>Answer: {{$Question2First}} {{$Question2Last}}</p>
        <h3>Question 3</h3>
        <p>How much did Mynouk van de Ven spent on 'VIP' tickets?</p>
        <p>Answer: {{$Question3}}</p>
        <h3>Question 4</h3>
        <p>Collect all the 'Regular' ticket barcodes from orders that have been paid for between 14:00:00 2022-05-30 and 14:05:00 2022-05-30 in Europe/Amsterdam timezone.</p>
        <p>Answer: </p>
        @foreach($Question4 as $barcode)
            {{$barcode}}
            <br>
        @endforeach
    </div>

    <div class="column">
        <h2>Info orders</h2>
        @foreach($orders as $order)
            <div  class="TicketsOrders">
                <h4>Order id: {{$order['id']}} </h4>
                <h5>Customer</h5>
                <p>Name: {{$order['orderer']['data']['first_name']}} {{$order['orderer']['data']['last_name']}}</p>
                <p>Email: {{$order['orderer']['data']['email']}}</p>
                <br>
                <h5>Status</h5>
                <p>Status code: {{$order['status']['code']}}</p>
                <p>Status: {{$order['status']['text' ]}}</p>
                <br>
                <h5>Payment details</h5>
                <p>Amount: {{$order['payments'][0]['amount']}}</p>
                <p>Method: {{$order['payments'][0]['method']}}</p>
                <p>Ordered at: {{$order['payments'][0]['created_at']}}</p>
                <br>
                <p>Download code: {{$order['download_code']}}</p>
{{--                "method" => "iDEAL"--}}
{{--                "created_at"--}}

            </div>
        @endforeach
    </div>

    <div class="column">
        <h2>Info tickets</h2>

                @foreach($tickets as $ticket)
                    <div  class="TicketsOrders">
                    <h4>Ticket name: {{$ticket['name']}} </h4>
                    <p>Ticket ID: {{$ticket['id']}}  </p>
                    <p>Ticket event ID: {{$ticket['event_id']}}</p>
                    <p>Ticket price:  {{$ticket['price']}}  </p>
                        @foreach($ticket["dates" ] as $date)
                            <p>Starts at {{$date["starts_at" ]}}</p>
                            <p>Ends at {{$date["ends_at"  ]}}</p>
                        @endforeach
                    </div>
                @endforeach

    </div>
</div>

</body>
</html>

