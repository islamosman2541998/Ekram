@php
   
    $node = $item['node'];
@endphp

<li class="manager-node" data-id="{{ $node->id }}">
    <div class="d-flex align-items-center gap-2">
   
        <label class="mb-0">
            <input type="radio" name="supervisor_id" value="{{ $node->id }}"
                {{ old('supervisor_id', $selectedSupervisor ?? '') == $node->id ? 'checked' : '' }}>
            <span class="ms-1">{{ $node->name ?? $node->employee_name ?? ('#' . $node->id) }}</span>
        </label>

      
        @if(isset($level) && $level > 0)
            <span class="level-indicator">
                @for($i=0;$i<$level;$i++)
                    {{-- <span class="dash">—</span> --}}
                @endfor
            </span>
        @endif

        
        {{-- <span class="badge bg-secondary ms-2">GM</span> --}}
    </div>

    @if(!empty($item['children']))
       
            @foreach($item['children'] as $child)
                @include('admin.dashboard.chairty.refer._manager_node', ['item' => $child, 'level' => ($level ?? 0) + 1, 'selectedSupervisor' => $selectedSupervisor ?? null])
            @endforeach
       
    @endif
</li>
