@foreach( $cckFormFields as $field )

    @include('cck::partials.fields.' . $field['type'])

@endforeach

@include('cck::partials.fields.submit')
