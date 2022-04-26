<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        #customers {
          font-family: Arial, Helvetica, sans-serif;
          border-collapse: collapse;
          width: 100%;
        }

        #customers td, #customers th {
          border: 1px solid #ddd;
          padding: 8px;
        }
        #customers th {
          padding-top: 12px;
          padding-bottom: 12px;
          text-align: left;
          background-color: #04AA6D;
          color: white;
        }
        </style>
</head>
<body>
    <div style="padding: 20px;">
        <div style="text-align: center; background: #4285f4; height: 50px; line-height: 50px;">
            <h2 style="color: #f4f3f7;">BILL  {{ $detail->date }}</h2>
        </div>
        <p>Bill detail for <b>{{ $detail->name}}</b></p>
        <p>Client: <b>{{ $detail->user->name }}</b></p>
        <table  id="customers" style="width: -webkit-fill-available;">
            <thead>
                <tr>
                    <th style="text-align: center;">Invoice component</th>
                    <th style="text-align: center;">Price</th>
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
                            <li style="text-align: left;">
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
