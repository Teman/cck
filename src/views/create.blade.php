@extends($cckMasterView)


@section($cckMasterViewSection)

    <h1>Create new {{ $cckFormTitle }}</h1>

    {{ link_to_route($cckResourceBaseRoute . '.index', 'Back to list', null, ['class' => 'btn btn-link']) }}

    {{ Form::open(['route' => $cckResourceBaseRoute . '.store']) }}

        @include('cck::partials.form')

    {{ Form::close() }}

@stop
