<div class="nav-container">
  @if (isset($header))
    <div class="header__dropdown--mobile">
      <div>
        @foreach($header as $item)
          @if(isset($item->child_items))
            <button class="accordion-tab">{{ $item->title }}</button>
            <div class="accordion-panel">
              @foreach($item->child_items as $child)
                <a href="{{ $child->url }}" target="{{ $child->target }}">{{ $child->title }}</a>
              @endforeach
            </div>
          @else 
            <a href="{{ $item->url }}" target="{{ $item->target }}">
              <div class="accordion-tab accordion-tab--link">
                {{ $item->title }}
              </div>
            </a>
          @endif
        @endforeach
      </div>
    </div>
  @endif
</div>
