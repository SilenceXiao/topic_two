@if( $statuses_data->count() > 0 )
    <ul class="list-unstyled">
        @foreach ($statuses_data as $status)
            @include('statuses.status',  ['user' => $status->user])
        @endforeach
    </ul>
    {!! $statuses_data->render() !!}
@else
    <p>没有数据</p>
@endif