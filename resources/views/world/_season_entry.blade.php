<div class="row world-entry">
@if($season->imageUrl)
        <div class="col-md-3 world-entry-image"><a href="{{ $season->imageUrl }}" data-lightbox="entry" data-title="{{ $name }}"><img src="{{ $season->imageUrl }}" class="world-entry-image" alt="{{ $season->name }}" /></a></div>
    @endif
    <div class="{{ $season->imageUrl ? 'col-md-9' : 'col-12' }}">
        <h3>{!! $season->displayName !!}</h3>
        <div class="text-muted"><i>" {!! $season->summary !!} " </i></div>
        {!! $season->description !!}
        @if($season->disclose_rates == 2)
            <p>Looks like we have no data to predict rates this season!</p>
            <p><i>(This season's rates are hidden!)</i></p>
        @endif
        @if(!$season->disclose_rates)
            <p>Looks like we have no data to predict what weather will show this season!</p>
            <p><i>(This season's weathers are hidden!)</i></p>
        @else
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th width="70%">Weather</th>
                        @if($season->disclose_rates == 1)
                            <th width="30%">Weather Rate</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($season->loot as $loot)
                        <tr>
                            <td>
                                {!! $loot->displayName !!}
                            </td>
                            @if($season->disclose_rates == 1)
                                <td>{{ $loot->dropRate }}</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>