<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div style="border:1px solid #2910b8; padding: 20px;">
        <div style="text-align: center;">
            <h2 style="color: #2910b8;">Bill monthly {{ $detail->date }}</h2>
        </div>
        <p>Bill detail for {{ $detail->name}}</p>
        <p>Client: {{ $detail->user->name }}</p>
        <p> </p>
        <table border style="border: 1px solid #2910b8; width: -webkit-fill-available;">
            <thead>
                <tr>
                    <th style="padding: 5px;">Invoice component</th>
                    <th style="padding: 5px;">Price</th>
                </tr>
            </thead>
            <tbody>
                <tr style="text-align: center;">
                    <td>Room price</td>
                    <td>{{ $detail->invoice_component->room_price }} VND</td>
                </tr>
                <tr style="text-align: center;">
                    <td>Water price</td>
                    <td>{{ $detail->invoice_component->water_price }} VND</td>
                </tr>
                <tr style="text-align: center;">
                    <td>Electric price</td>
                    <td>{{ $detail->invoice_component->electric_price }} VND</td>
                </tr>
                <tr style="text-align: center;">
                    <td>Service price</td>
                    <td>
                        <ul>
                            @foreach ($detail->invoice_component->service_price as $item)
                            <li>
                                <span>
                                    {{ $item->label }}: {{ $item->price }}VND
                                </span>
                            </li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
                <tr style="text-align: center;">
                    <td><span style="font-style: italic;">Total price</span></td>
                    <td>{{ $detail->invoice_component->totalPrice }} VND</td>
                </tr>
            </tbody>
        </table>

        <h3> Payment methods </h3>
        <ul>
            <li>
                Bank transfer : 220260888 - VIB bank - Nguyễn Khoa Trường Giang
            </li>
            <li>
                Momo: 0903463046
            </li>
        </ul>
    </div>
</body>
</html>
