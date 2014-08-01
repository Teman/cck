@extends($cckMasterView)


@section($cckMasterViewSection)

    <h1>Edit {{ $cckFormTitle }}</h1>

    {{ link_to_route($cckResourceBaseRoute . '.index', 'Back to list', null, ['class' => 'btn btn-link']) }}

    {{ Form::model($item, ['method' => 'PUT', 'route' => [$cckResourceBaseRoute . '.update', $item->id]]) }}

        @include('cck::partials.form', ['buttonText' => 'Update'])

    {{ Form::close() }}

@stop
