@php
    $v = function ($key) use ($prefix, $values) {
        return $values["{$prefix}_{$key}"] ?? '';
    };
    $label = 'EN';
@endphp

<div style="display:grid; gap:1rem">
    <div>
        <label for="{{ $prefix }}_title" style="display:block; font-weight:600; font-size:.85rem; margin-bottom:.3rem">{{ $label }} Title</label>
        <input id="{{ $prefix }}_title" name="{{ $prefix }}_title" type="text" value="{{ $v('title') }}" required style="width:100%; padding:.55rem .8rem; border:1px solid var(--border); border-radius:8px">
    </div>

    <div>
        <label for="{{ $prefix }}_short_description" style="display:block; font-weight:600; font-size:.85rem; margin-bottom:.3rem">{{ $label }} Short description</label>
        <textarea id="{{ $prefix }}_short_description" name="{{ $prefix }}_short_description" rows="2" style="width:100%; padding:.55rem .8rem; border:1px solid var(--border); border-radius:8px">{{ $v('short_description') }}</textarea>
    </div>

    <div>
        <label for="{{ $prefix }}_full_description" style="display:block; font-weight:600; font-size:.85rem; margin-bottom:.3rem">{{ $label }} Full description</label>
        <textarea id="{{ $prefix }}_full_description" name="{{ $prefix }}_full_description" rows="5" style="width:100%; padding:.55rem .8rem; border:1px solid var(--border); border-radius:8px">{{ $v('full_description') }}</textarea>
    </div>

    <div>
        <label for="{{ $prefix }}_steps" style="display:block; font-weight:600; font-size:.85rem; margin-bottom:.3rem">{{ $label }} Steps (one per line)</label>
        <textarea id="{{ $prefix }}_steps" name="{{ $prefix }}_steps" rows="5" style="width:100%; padding:.55rem .8rem; border:1px solid var(--border); border-radius:8px">{{ $v('steps') }}</textarea>
    </div>

    <div>
        <label for="{{ $prefix }}_requirements" style="display:block; font-weight:600; font-size:.85rem; margin-bottom:.3rem">{{ $label }} Requirements</label>
        <textarea id="{{ $prefix }}_requirements" name="{{ $prefix }}_requirements" rows="3" style="width:100%; padding:.55rem .8rem; border:1px solid var(--border); border-radius:8px">{{ $v('requirements') }}</textarea>
    </div>

    <div>
        <label for="{{ $prefix }}_tips" style="display:block; font-weight:600; font-size:.85rem; margin-bottom:.3rem">{{ $label }} Tips</label>
        <textarea id="{{ $prefix }}_tips" name="{{ $prefix }}_tips" rows="3" style="width:100%; padding:.55rem .8rem; border:1px solid var(--border); border-radius:8px">{{ $v('tips') }}</textarea>
    </div>
</div>
