@foreach ($items->where('parent_id', $parent_id ?? 0) as $item)
    @php
        $totalChildren = $items->where('parent_id', $item->id)->count();
        $itemTitle = @$item->trans?->where('locale', $current_lang)->first()->title;
        $itemUrl = @$item->type == 'dynamic' ? @$item->dynamic_url : @$item->url;
        $isActive =
            @$item->id == @$menu->id ||
            @$item_parent_id == $item->id ||
            in_array(@$item->id, @$menu_parent_ids ?? []) ||
            in_array(@$item->id, $ekActiveIds ?? []);
    @endphp

    @if ($totalChildren)
        <li class="ek-nav__sub-item has-sub">
            <button type="button" class="ek-nav__sub-link ek-nav__sub-toggle @if ($isActive) is-active @endif"
                aria-expanded="false">
                <span>{{ $itemTitle }}</span>
                <i class="fa-solid fa-chevron-down ek-nav__caret"></i>
            </button>
            <div class="ek-nav__sub">
                <ul class="ek-nav__sub-list">
                    @include('site.layouts.menuItem', ['parent_id' => $item->id])
                </ul>
            </div>
        </li>
    @else
        <li class="ek-nav__sub-item">
            <a class="ek-nav__sub-link @if ($isActive) is-active @endif" href="{{ $itemUrl }}">
                {{ $itemTitle }}
            </a>
        </li>
    @endif
@endforeach
