<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body style="background-color: black; color: white;">
    <h1>User List:</h1>

    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Classe</th>
                <th>Experiência</th>
                <th>Açõees</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($players as $player)
                <tr>
                    <td>{{ $player->name }}</td>
                    <td>{{ $player->class }}</td>
                    <td>{{ $player->xp }}</td>
                    <td> - </td>
                </tr>
            @empty
                <tr>
                    <td>Vazio</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>