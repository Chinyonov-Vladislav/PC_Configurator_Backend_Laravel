<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
</head>
<body style="font-family: 'Arial', sans-serif;">
<div style="max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">
    <h2 style="text-align: center; color: #333;">{{$nameItemHardware}}</h2>
    <h4 style="text-align: center; color: #333;">{{$typeItemHardware}}</h4>
    <table>
        <thead>
        <tr class="header_table">
            <th>{{$nameCharacteristicTitle}}</th>
            <th>{{$valueCharacteristicTitle}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($characteristics as $characteristic)
            <tr>
                <td>{{ $characteristic->name }}</td>
                <td>{!! nl2br($characteristic->value) !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    table, th, td {
        border: 1px solid black;
    }
    td, th {
        padding: 10px; /* Здесь 10px - это пример значения отступа, которое вы можете настроить */
    }
    .header_table{
        background-color: #2afcff;
    }
</style>
</html>
