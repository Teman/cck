@extends($cckMasterView)


@section($cckMasterViewSection)

    <h1>Edit {{ $cckFormTitle }}</h1>

    {{ Form::model($item, ['method' => 'PUT', 'route' => [$cckResourceBaseRoute . '.update', $item->id]]) }}

        @include('cck::partials.form', ['buttonText' => 'Update'])

    {{ Form::close() }}

@stop
