<tbody class="table">
@if(count($rows))
    @foreach($rows as $key => $row)
        <tr class="@if( ($key+1) % 2 === 0 ) alternate @endif">
            @foreach($columns as $column)
                @if( $column['title'] !== 'Įrankiai' )
                    <td class="" style="text-align: center;">
                        @if (isset($column['mutator']) && is_callable($column['mutator']))
                            {{ $column['mutator']($row->{ $column['attribute'] ?? $column['title'] }) }}
                        @else
                            {{ $row->{ $column['attribute'] ?? $column['title'] } }}
                        @endif
                    </td>
                @else
                    <td class="" style="text-align: right;">

                        @if (in_array('edit.door', $column['tools'], true) )
                            @if ($user->account_rank == 2)
                                <a class="btn btn-primary" href="{{ route('doors.edit', $row->getKey())}}">
                                    <span>Redaguoti</span></a>
                            @endif
                        @endif

                        @if (in_array('remove.door', $column['tools'], true) )
                            @if ($user->account_rank == 2)
                                <a class="btn btn-danger"
                                   onclick="javascript:return confirm('Ar tikrai norite pašalinti?')"
                                   href="{{route('doors.delete',$row->GetKey())}}">
                                    Pašalinti</a>
                            @endif
                        @endif

                        @if (in_array('edit_rights.door', $column['tools'], true) )
                            @if ($user->account_rank == 2)
                                    <a class="btn btn-primary" href="{{ route('doors.rights', $row->getKey())}}">
                                        <span>Durų teisės</span></a>
                            @endif
                        @endif

                        @if (in_array('display_info.door', $column['tools'], true) )
                            @if ($user->account_rank == 2)
                                <a class="btn btn-primary" href="{{ route('doors.doordisplay', $row->getKey())}}">
                                    <span>Ekranas</span></a>
                            @endif
                        @endif


                        @if (in_array('change_status.door', $column['tools'], true) )
                            <input data-doors="{{$row->getKey()}}" type="checkbox" name="change_status"
                                   id="change_status" data-toggle="toggle" data-on="Atrakinta" data-off="Užrakinta">
                        @endif

                        @if (in_array('edit.visit', $column['tools'], true) )
                            <a class="btn btn-primary" href="{{ route('visit.edit', $row->getKey())}}">
                                <span>Redaguoti</span></a>
                        @endif

                        @if (in_array('remove.visit', $column['tools'], true) )
                            <a class="btn btn-danger" onclick="javascript:return confirm('Ar tikrai norite pašalinti?')"
                               href="{{route('visit.delete',$row->GetKey())}}">
                                Pašalinti</a>
                        @endif

                        @if (in_array('complete.visit', $column['tools'], true) )
                            @if ($userlevel->account_rank == 1 || $userlevel->account_rank == 2)
                                @if ($row->status != 2)
                                    <a class="btn btn-primary" href="{{ route('visit.complete', $row->getKey())}}">
                                        <span>Užbaigti</span></a>
                                @endif
                            @endif
                        @endif

                            @if (in_array('check.visit', $column['tools'], true) )
                                    @if ($row->status == 2)
                                        <a class="btn btn-primary" href="{{ route('visit.check', $row->getKey())}}">
                                            <span>Peržiūrėti</span></a>
                                        @endif
                            @endif
                    </td>
                @endif
            @endforeach
        </tr>
    @endforeach
@else
    <tr>
        <td class="text-center"
            colspan="{{ count($columns) }}">No data
        </td>
    </tr>
@endif

</tbody>


@push('js')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function () {


            $('input[name="change_status"]').change(function () {
                let $input = $(this);

                if ($input.prop('checked')) {
                    $.post('{{ route('doors.open') }}', {doors: $input.data('doors')}, function (response) {
                        if (!response.success) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Ojojoj!',
                                text: 'Neveikia durų sistema!',
                            })
                        }
                    });

                    setTimeout(function () {
                        $input.bootstrapToggle('off');
                    }, 2000);
                }
            })
        })
    </script>
@endpush


