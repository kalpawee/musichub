<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Event Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #8888cc;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .booking-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        input, select {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        button {
            padding: 10px;
            background-color: #99b4cf;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #8097ae;
        }
        .success-message {
            background-color: #d4edda;
            color: #88d199;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="booking-container">
    <h1>Book Your Music Event</h1>

    @if(session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    <form action="/book-event" method="POST">
        @csrf
        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" required>

        <label for="event">Select Event</label>
        <select id="event" name="event" required>
            <option value="Concert - Rock the Night">Concert - Rock the Night</option>
            <option value="Music Fiesta Festival">Music Fiesta Festival</option>
            <option value="The Soundtrack of Summer">The Soundtrack of Summer</option>
            <option value="Exclusive Interview with The Soundwaves">Exclusive Interview with The Soundwaves</option>
        </select>

        <label for="tickets">Number of Tickets</label>
        <input type="number" id="tickets" name="tickets" min="1" max="10" required>

        <button type="submit">Book Tickets</button>
    </form>
</div>

</body>
</html>
