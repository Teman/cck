@extends($cckMasterView)


@section($cckMasterViewSection)

    <h1>{{ $cckFormTitle }}</h1>

    {{ link_to_route( $cckResourceBaseRoute . '.create', 'Add a new ' . $cckFormTitle, null, ['class' => 'btn btn-primary'] ) }}

    <table class="table">

        <thead>

            <tr>
                @foreach( $cckFormFields as $field )
                    <th>{{ $field['name'] }}</th>
                @endforeach

                <th>Edit</th>
                <th>Delete</th>
            </tr>

        </thead>

        <tbody>

            @foreach( $items as $item )

                <tr>
                    @foreach( $cckFormFields as $field )
                        <td>{{ $item->{$field['name']} }}</td>
                    @endforeach

                    <td>{{ link_to_route($cckResourceBaseRoute . '.edit', 'Edit', $item->id, ['class' => 'btn btn-primary']) }}</td>
                    <td>
                        {{ Form::open(['method' => 'DELETE', 'route' => [$cckResourceBaseRoute . '.destroy', $item->id]]) }}
                            {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
                        {{ Form::close() }}
                    </td>
                </tr>

            @endforeach

        </tbody>



    </table>





@stop
