@extends('admin.layouts.app')

@php
    $isEdit = $idea !== null;
    $title  = $isEdit ? 'Edit Business Idea' : 'New Business Idea';
    $action = $isEdit ? route('admin.ideas.update', $idea) : route('admin.ideas.store');
    $v = function ($key) use ($en) { return old($key, $en?->{$key}); };
@endphp

@section('title', $title)
@section('page_title', $title)

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem; flex-wrap:wrap; gap:.5rem">
        <div>
            <h2 class="page-title" style="margin-bottom:.25rem">{{ $title }}</h2>
            <p class="page-subtitle" style="margin:0">
                @if ($isEdit)
                    Updating: <code>{{ $idea->slug }}</code>
                @else
                    The slug is generated automatically from the title.
                @endif
            </p>
        </div>
        <a href="{{ route('admin.ideas.index') }}" style="color:var(--text-muted); text-decoration:none; font-size:.9rem">← Back to list</a>
    </div>

    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

    @if ($errors->any())
        <div class="alert alert-error">
            <ul style="margin:0; padding-left:1.25rem">
                @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ $action }}" style="background:#fff; border:1px solid var(--border); border-radius:12px; padding:1.25rem">
        @csrf
        @if ($isEdit) @method('PUT') @endif

        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:1rem; margin-bottom:1.25rem">
            <div>
                <label for="slug" style="display:block; font-weight:600; font-size:.85rem; margin-bottom:.3rem">Slug (URL)</label>
                <input id="slug" name="slug" type="text" value="{{ old('slug', $idea?->slug) }}" placeholder="auto-generated from title" style="width:100%; padding:.55rem .8rem; border:1px solid var(--border); border-radius:8px">
            </div>
            <div>
                <label for="category_id" style="display:block; font-weight:600; font-size:.85rem; margin-bottom:.3rem">Category</label>
                <select id="category_id" name="category_id" style="width:100%; padding:.55rem .8rem; border:1px solid var(--border); border-radius:8px">
                    <option value="">— none —</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" @selected(old('category_id', $idea?->category_id) == $cat->id)>{{ $cat->translation()?->name ?? $cat->slug }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <h3 style="margin:1.25rem 0 .75rem; font-size:.85rem; text-transform:uppercase; color:var(--brand)">Money guidance</h3>
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(180px, 1fr)); gap:1rem; margin-bottom:1.25rem">
            <div>
                <label for="capital" style="display:block; font-weight:600; font-size:.85rem; margin-bottom:.3rem">Starting capital</label>
                <input id="capital" name="capital" type="number" step="0.01" min="0" value="{{ old('capital', $idea?->capital) }}" style="width:100%; padding:.55rem .8rem; border:1px solid var(--border); border-radius:8px">
            </div>
            <div>
                <label for="expected_profit" style="display:block; font-weight:600; font-size:.85rem; margin-bottom:.3rem">Expected profit</label>
                <input id="expected_profit" name="expected_profit" type="number" step="0.01" value="{{ old('expected_profit', $idea?->expected_profit) }}" style="width:100%; padding:.55rem .8rem; border:1px solid var(--border); border-radius:8px">
            </div>
            <div>
                <label for="currency" style="display:block; font-weight:600; font-size:.85rem; margin-bottom:.3rem">Currency</label>
                <input id="currency" name="currency" type="text" value="{{ old('currency', $idea?->currency ?? 'RWF') }}" style="width:100%; padding:.55rem .8rem; border:1px solid var(--border); border-radius:8px">
            </div>
        </div>

        <h3 style="margin:1.5rem 0 .75rem; font-size:.85rem; text-transform:uppercase; color:var(--brand)">Content</h3>
        <div style="display:grid; gap:1rem">
            <div>
                <label for="en_title" style="display:block; font-weight:600; font-size:.85rem; margin-bottom:.3rem">Title</label>
                <input id="en_title" name="en_title" type="text" value="{{ $v('title') }}" required style="width:100%; padding:.55rem .8rem; border:1px solid var(--border); border-radius:8px">
            </div>
            <div>
                <label for="en_short_description" style="display:block; font-weight:600; font-size:.85rem; margin-bottom:.3rem">Short description</label>
                <textarea id="en_short_description" name="en_short_description" rows="2" style="width:100%; padding:.55rem .8rem; border:1px solid var(--border); border-radius:8px">{{ $v('short_description') }}</textarea>
            </div>
            <div>
                <label for="en_full_description" style="display:block; font-weight:600; font-size:.85rem; margin-bottom:.3rem">Full description</label>
                <textarea id="en_full_description" name="en_full_description" rows="5" style="width:100%; padding:.55rem .8rem; border:1px solid var(--border); border-radius:8px">{{ $v('full_description') }}</textarea>
            </div>
            <div>
                <label for="en_steps" style="display:block; font-weight:600; font-size:.85rem; margin-bottom:.3rem">Steps (one per line)</label>
                <textarea id="en_steps" name="en_steps" rows="5" style="width:100%; padding:.55rem .8rem; border:1px solid var(--border); border-radius:8px">{{ $v('steps') }}</textarea>
            </div>
            <div>
                <label for="en_requirements" style="display:block; font-weight:600; font-size:.85rem; margin-bottom:.3rem">Requirements</label>
                <textarea id="en_requirements" name="en_requirements" rows="3" style="width:100%; padding:.55rem .8rem; border:1px solid var(--border); border-radius:8px">{{ $v('requirements') }}</textarea>
            </div>
            <div>
                <label for="en_tips" style="display:block; font-weight:600; font-size:.85rem; margin-bottom:.3rem">Tips</label>
                <textarea id="en_tips" name="en_tips" rows="3" style="width:100%; padding:.55rem .8rem; border:1px solid var(--border); border-radius:8px">{{ $v('tips') }}</textarea>
            </div>
        </div>

        <details style="margin:1.5rem 0 0; background:var(--page-bg); border-radius:8px; padding:.75rem">
            <summary style="cursor:pointer; font-weight:600; font-size:.85rem">Admin notes (private)</summary>
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(180px, 1fr)); gap:1rem; margin-top:.75rem">
                <div>
                    <label for="operating_costs" style="display:block; font-weight:600; font-size:.8rem; margin-bottom:.25rem">Operating costs</label>
                    <input id="operating_costs" name="operating_costs" type="number" step="0.01" value="{{ old('operating_costs', $idea?->operating_costs) }}" style="width:100%; padding:.5rem .7rem; border:1px solid var(--border); border-radius:8px">
                </div>
                <div>
                    <label for="expected_revenue" style="display:block; font-weight:600; font-size:.8rem; margin-bottom:.25rem">Expected revenue</label>
                    <input id="expected_revenue" name="expected_revenue" type="number" step="0.01" value="{{ old('expected_revenue', $idea?->expected_revenue) }}" style="width:100%; padding:.5rem .7rem; border:1px solid var(--border); border-radius:8px">
                </div>
                <div>
                    <label for="difficulty_level" style="display:block; font-weight:600; font-size:.8rem; margin-bottom:.25rem">Difficulty</label>
                    <select id="difficulty_level" name="difficulty_level" style="width:100%; padding:.5rem .7rem; border:1px solid var(--border); border-radius:8px">
                        <option value="">—</option>
                        <option value="easy"   @selected(old('difficulty_level', $idea?->difficulty_level) === 'easy')>Easy</option>
                        <option value="medium" @selected(old('difficulty_level', $idea?->difficulty_level) === 'medium')>Medium</option>
                        <option value="hard"   @selected(old('difficulty_level', $idea?->difficulty_level) === 'hard')>Hard</option>
                    </select>
                </div>
                <div>
                    <label for="time_to_start" style="display:block; font-weight:600; font-size:.8rem; margin-bottom:.25rem">Time to start</label>
                    <input id="time_to_start" name="time_to_start" type="text" value="{{ old('time_to_start', $idea?->time_to_start) }}" style="width:100%; padding:.5rem .7rem; border:1px solid var(--border); border-radius:8px">
                </div>
            </div>
        </details>

        <h3 style="margin:1.5rem 0 .75rem; font-size:.85rem; text-transform:uppercase; color:var(--text-muted)">Cover image</h3>
        <input id="cover_image" name="cover_image" type="text" value="{{ old('cover_image', $idea?->cover_image) }}" placeholder="https://... (upload coming soon)" style="width:100%; padding:.55rem .8rem; border:1px solid var(--border); border-radius:8px">

        <h3 style="margin:1.5rem 0 .75rem; font-size:.85rem; text-transform:uppercase; color:var(--text-muted)">Publishing</h3>
        <label style="display:flex; align-items:center; gap:.5rem; margin-bottom:.75rem; font-size:.9rem">
            <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $idea?->is_featured))> Feature on Home Page
        </label>
        <label style="display:flex; align-items:center; gap:.5rem; margin-bottom:1.25rem; font-size:.9rem">
            <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $idea?->is_published))> Publish immediately
        </label>

        <div style="display:flex; gap:.5rem; flex-wrap:wrap; padding-top:1rem; border-top:1px solid var(--border)">
            <button type="submit" style="background:var(--brand); color:#fff; border:0; padding:.7rem 1.25rem; border-radius:8px; font-weight:600; cursor:pointer">{{ $isEdit ? 'Update Idea' : 'Save Idea' }}</button>
            <a href="{{ $isEdit ? route('admin.ideas.show', $idea) : route('admin.ideas.index') }}" style="padding:.7rem 1.25rem; border:1px solid var(--border); border-radius:8px; text-decoration:none; color:var(--text); font-weight:600">Cancel</a>
        </div>
    </form>
@endsection
