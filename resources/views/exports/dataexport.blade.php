<table>
    <thead>
    <tr>
        <th>key</th>
        <th>value</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $key => $value)
        <tr>
            <td>{{ $key }}</td>
            <td>{{ $value }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
