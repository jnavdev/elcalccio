<!DOCTYPE html>
<html lang="es">
<title>Alumnos PDF</title>

<head>
    <title>Document</title>
    <style>
        html * {
            font-family: arial, sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
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
    <h4 style="text-align: center;">Cumpleaños estudiantes</h4>

    <table>
        <tr>
            <th>Foto</th>
            <th>Nombre Completo</th>
            <th>RUT</th>
            <th>Ciudad</th>
            <th>Fecha Nacimiento</th>
            <th>Fono</th>
            <th>Sexo</th>
        </tr>

        @foreach ($students as $student)
            <tr>
                <td>
                    <img src="{{ asset($student->profile_picture) }}" width="60" height="80"
                        alt="{{ $student->full_name }}">
                </td>
                <td>{{ $student->full_name }}</td>
                <td>{{ $student->rut }}</td>
                <td>{{ $student->commune->name }}</td>
                <td>{{ $student->birth_date->format('d-m-Y') }}</td>
                <td>{{ $student->phone }}</td>
                <td>
                    {{ $student->sex == 'M' ? 'Masculino' : 'Femenino' }}
                </td>
            </tr>
        @endforeach
    </table>
</body>

</html>
