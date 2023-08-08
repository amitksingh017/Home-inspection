<div class="list-container vertical-center">
    <table class="table">
        @if(!empty($header))
            <thead>
                <tr>
                    @foreach($header as $row)
                        <th>{{ $row }}</th>
                    @endforeach
                </tr>
            </thead>
        @endif
        <tbody>
            @if(!empty($data))
                @foreach ($data as $row)
                    <tr>
                        @foreach($row as $cell)
                            <td>{{ $cell }}</td>
                        @endforeach
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-lg-center" colspan="{{ !empty($header) ? count($header) : 1 }}">
                        *No data yet*
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
