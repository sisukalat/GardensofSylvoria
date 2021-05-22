<ul>
    <li class="sidebar-header"><a href="{{ url('shops') }}" class="card-link">Featured Character</a></li>

    <li class="sidebar-section p-2">
        @if(isset($featured) && $featured)
        
        @else
            <p>There is no featured character.</p>
        @endif
    </li>
</ul>
