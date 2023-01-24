<ul>
    @foreach (json_decode($dataTypeContent->{$row->field} ?? "[]", true) as $d)
        <li>{{ $d['title'] }}</li>
        <ul>
            @foreach (json_decode($d['child'], true) as $e)
                <li>{{ $e['content'] }}</li>
            @endforeach
        </ul>
    @endforeach
    <ul>
