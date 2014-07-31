@extends($cckMasterView)


@section($cckMasterViewSection)

    <h1>Create new {{ $cckFormTitle }}</h1>



    {{ Form::open(['route' => $cckResourceBaseRoute . '.store']) }}

        @include('cck::partials.form')

    {{ Form::close() }}

@stop
