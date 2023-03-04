@extends('admin.layout')

@section('admin-title') Seasons @endsection

@section('admin-content')
{!! breadcrumbs(['Admin Panel' => 'admin', 'Seasons' => 'admin/weather/seasons', ($season->id ? 'Edit' : 'Create').' Season' => $season->id ? 'admin/weather/seasons/edit/'.$season->id : 'admin/weather/seasons/create']) !!}

<h1>{{ $season->id ? 'Edit' : 'Create' }} Season
    @if($season->id)
        <a href="#" class="btn btn-danger float-right delete-season-button">Delete Season</a>
    @endif
</h1>

{!! Form::open(['url' => $season->id ? 'admin/weather/seasons/edit/'.$season->id : 'admin/weather/seasons/create', 'files' => true]) !!}

<h3>Basic Information</h3>

<div class="form-group">
    {!! Form::label('Name') !!}
    {!! Form::text('name', $season->name, ['class' => 'form-control']) !!}
</div>

@if($season->has_image)
        <img src="{{$season->imageUrl }}" class="img-fluid mr-2 mb-2" style="height: 10em;" />
        <br>
    @endif
<div class="form-group">
    {!! Form::label('World Page Image (Optional)') !!} {!! add_help('This image is used only on the world information pages.') !!}
    <div>{!! Form::file('image') !!}</div>
    <div class="text-muted">Recommended size: 100px x 100px</div>
    @if($season->has_image)
        <div class="form-check">
            {!! Form::checkbox('remove_image', 1, false, ['class' => 'form-check-input']) !!}
            {!! Form::label('remove_image', 'Remove current image', ['class' => 'form-check-label']) !!}
        </div>
    @endif
</div>

<div class="form-group">
    {!! Form::label('Summary (Optional)') !!} {!! add_help('This is a short blurb that shows up on the consolidated seasons page. HTML cannot be used here.') !!}
    {!! Form::text('summary', $season->summary, ['class' => 'form-control', 'maxLength' => 250]) !!}
</div>

<div class="form-group">
    {!! Form::label('Description (Optional)') !!} {!! add_help('This is a full description of the season that shows up on the full season page.') !!}
    {!! Form::textarea('description', $season->description, ['class' => 'form-control wysiwyg']) !!}
</div>

<div class="form-group">
    {!! Form::checkbox('is_visible', 1, $season->id ? $season->is_visible : 1, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
    {!! Form::label('is_visible', 'Is Active', ['class' => 'form-check-label ml-3']) !!} {!! add_help('Seasons that are not active will be hidden from the season list.') !!}
</div>


<div class="form-group">
    {!! Form::label('Disclose Rates') !!} {!! add_help('This determines if users can see the potential weathers of this season on the encyclopedia page.') !!}
    {!! Form::select('disclose_rates', ['0' => '0: This season\'s weathers are hidden.', '1' => '1: Users can see both weather and roll rates.', '2' => '2: Users can see weathers, but not roll rates.'],$season->disclose_rates, ['class' => 'form-control']) !!}
</div>

<h3>Table</h3>

<p>These are the potential weathers from rolling on this season.@if(!$season->id) You can test rolling after the season is created. @endif</p>
<div class="text-right mb-3">
    <a href="#" class="btn btn-info" id="addLoot">Add Weather</a>
</div>
<table class="table table-sm" id="lootSeason">
    <thead>
        <tr>
            <th width="25%">Loot Type</th>
            <th width="35%">Weather</th>
            <th width="10%">Weight {!! add_help('A higher weight means a reward is more likely to be rolled. Weights have to be integers above 0 (round positive number, no decimals) and do not have to add up to be a particular number.') !!}</th>
            <th width="10%">Chance</th>
            <th width="10%"></th>
        </tr>
    </thead>
    <tbody id="lootSeasonBody">
        @if($season->id)
            @foreach($season->loot as $loot)
                <tr class="loot-row">
                    <td>{!! Form::select('rewardable_type[]', ['Weather' => 'Weather'], $loot->rewardable_type, ['class' => 'form-control reward-type', 'placeholder' => 'Select Reward Type']) !!}</td>
                    <td class="loot-row-select">
                        @if($loot->rewardable_type == 'Weather')
                            {!! Form::select('weather_id[]', $weathers, $loot->weather_id, ['class' => 'form-control weather-select selectize', 'placeholder' => 'Select Weather']) !!}
                        @endif
                    </td>
                    <td class="loot-row-weight">{!! Form::text('weight[]', $loot->weight, ['class' => 'form-control loot-weight']) !!}</td>
                    <td class="loot-row-chance"></td>
                    <td class="text-right"><a href="#" class="btn btn-danger remove-loot-button">Remove</a></td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

<div class="text-right">
    {!! Form::submit($season->id ? 'Edit' : 'Create', ['class' => 'btn btn-primary']) !!}
</div>

{!! Form::close() !!}

<div id="lootRowData" class="hide">
    <table class="table table-sm">
        <tbody id="lootRow">
            <tr class="loot-row">
                <td>{!! Form::select('rewardable_type[]', ['Weather' => 'Weather'], null, ['class' => 'form-control reward-type', 'placeholder' => 'Select Reward Type']) !!}</td>
                <td class="loot-row-select"></td>
                <td class="loot-row-weight">{!! Form::text('weight[]', 1, ['class' => 'form-control loot-weight']) !!}</td>
                <td class="loot-row-chance"></td>
                <td class="text-right"><a href="#" class="btn btn-danger remove-loot-button">Remove</a></td>
            </tr>
        </tbody>
    </table>
    {!! Form::select('weather_id[]', $weathers, null, ['class' => 'form-control weather-select', 'placeholder' => 'Select Weather']) !!}
</div>

@if($season->id)
    <h3>Test Roll</h3>
    <p>If you have made any modifications to the loot season contents above, be sure to save it (click the Edit button) before testing.</p>
    <p>Please note that due to the nature of probability, as long as there is a chance, there will always be the possibility of rolling improbably good or bad results. <i>This is not indicative of the code being buggy or poor game balance.</i> Be cautious when adjusting values based on a small sample size, including but not limited to test rolls and a small amount of user reports.</p>
    <div class="form-group">
        {!! Form::label('quantity', 'Number of Rolls') !!}
        {!! Form::text('quantity', 1, ['class' => 'form-control', 'id' => 'rollQuantity']) !!}
    </div>
    <div class="text-right">
        <a href="#" class="btn btn-primary" id="testRoll">Test Roll</a>
    </div>
@endif

@if($season->id)
    <h3>Preview</h3>
    <div class="card mb-3">
        <div class="card-body">
        @include('world._season_entry', ['name' => $season->name, 'loot' => $season->loot])        
    </div>
    </div>
@endif

@endsection

@section('scripts')
@parent
<script>
$( document ).ready(function() {
    var $lootSeason  = $('#lootSeasonBody');
    var $lootRow = $('#lootRow').find('.loot-row');
    var $weatherSelect = $('#lootRowData').find('.weather-select');

    refreshChances();
    $('#lootSeasonBody .selectize').selectize();
    attachRemoveListener($('#lootSeasonBody .remove-loot-button'));

    $('.delete-season-button').on('click', function(e) {
        e.preventDefault();
        loadModal("{{ url('admin/weather/seasons/delete') }}/{{ $season->id }}", 'Delete Season');
    });

    $('#testRoll').on('click', function(e) {
        e.preventDefault();
        loadModal("{{ url('admin/weather/seasons/roll') }}/{{ $season->id }}?quantity=" + $('#rollQuantity').val(), 'Rolling Season');
    });

    $('#addLoot').on('click', function(e) {
        e.preventDefault();
        var $clone = $lootRow.clone();
        $lootSeason.append($clone);
        attachRewardTypeListener($clone.find('.reward-type'));
        attachRemoveListener($clone.find('.remove-loot-button'));
        attachWeightListener($clone.find('.loot-weight'));
        refreshChances();
    });

    $('.reward-type').on('change', function(e) {
        var val = $(this).val();
        var $cell = $(this).parent().find('.loot-row-select');

        var $clone = null;
        if(val == 'Weather') $clone = $weatherSelect.clone();

        $cell.html('');
        $cell.append($clone);
    });

    function attachRewardTypeListener(node) {
        node.on('change', function(e) {
            var val = $(this).val();
            var $cell = $(this).parent().parent().find('.loot-row-select');

            var $clone = null;
            if(val == 'Weather') $clone = $weatherSelect.clone();

            $cell.html('');
            $cell.append($clone);
            if (val != 'ItemCategoryRarity' && val != 'ItemRarity') $clone.selectize();
        });
    }

    function attachRemoveListener(node) {
        node.on('click', function(e) {
            e.preventDefault();
            $(this).parent().parent().remove();
            refreshChances();
        });
    }

    function attachWeightListener(node) {
        node.on('change', function(e) {
            refreshChances();
        });
    }

    function refreshChances() {
        var total = 0;
        var weights = [];
        $('#lootSeasonBody .loot-weight').each(function( index ) {
            var current = parseInt($(this).val());
            total += current;
            weights.push(current);
        });


        $('#lootSeasonBody .loot-row-chance').each(function( index ) {
            var current = (weights[index] / total) * 100;
            $(this).html(current.toString() + '%');
        });
    }
});

</script>
@endsection
