@extends('admin.layouts.app')

@php
    $isEdit = $idea !== null;
    $title  = $isEdit ? 'Edit Business Idea' : 'New Business Idea';
    $action = $isEdit ? route('admin.ideas.update', $idea) : route('admin.ideas.store');
    $v      = function ($key) use ($en) { return old($key, $en?->{$key}); };

    $currentCover = old('cover_image', $idea?->cover_image);
    $previewUrl   = null;
    if ($currentCover) {
        if (preg_match('#^https?://#i', $currentCover)) {
            $previewUrl = $currentCover;
        } else {
            $previewUrl = asset('storage/' . ltrim($currentCover, '/'));
        }
    }
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

        {{-- Slug + Category --}}
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

        {{-- Money guidance --}}
        <h3 style="margin:1.25rem 0 .75rem; font-size:.85rem; text-transform:uppercase; letter-spacing:.05em; color:var(--brand)">Money guidance</h3>

        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(180px, 1fr)); gap:1rem; margin-bottom:1.25rem">
            <div>
                <label for="capital" style="display:block; font-weight:600; font-size:.85rem; margin-bottom:.3rem">Starting capital</label>
                <input
                    id="capital"
                    name="capital"
                    type="number"
                    step="1"
                    min="0"
                    value="{{ old('capital', $idea?->capital) }}"
                    placeholder="e.g. 50000"
                    style="width:100%; padding:.55rem .8rem; border:1px solid var(--border); border-radius:8px">
            </div>
            <div>
                <label for="expected_profit" style="display:block; font-weight:600; font-size:.85rem; margin-bottom:.3rem">Expected profit</label>
                <input
                    id="expected_profit"
                    name="expected_profit"
                    type="number"
                    step="1"
                    min="0"
                    value="{{ old('expected_profit', $idea?->expected_profit) }}"
                    placeholder="e.g. 100000"
                    style="width:100%; padding:.55rem .8rem; border:1px solid var(--border); border-radius:8px">
            </div>
            <div>
                <label for="currency" style="display:block; font-weight:600; font-size:.85rem; margin-bottom:.3rem">Currency</label>
                <input
                    id="currency"
                    name="currency"
                    type="text"
                    value="{{ old('currency', $idea?->currency ?? 'RWF') }}"
                    style="width:100%; padding:.55rem .8rem; border:1px solid var(--border); border-radius:8px">
            </div>
        </div>

        {{-- Content --}}
        <h3 style="margin:1.5rem 0 .75rem; font-size:.85rem; text-transform:uppercase; letter-spacing:.05em; color:var(--brand)">Content</h3>
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

        {{-- Admin notes --}}
        <details style="margin:1.5rem 0 0; background:var(--page-bg); border-radius:8px; padding:.75rem">
            <summary style="cursor:pointer; font-weight:600; font-size:.85rem">Admin notes (private)</summary>
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(180px, 1fr)); gap:1rem; margin-top:.75rem">
                <div>
                    <label for="operating_costs" style="display:block; font-weight:600; font-size:.8rem; margin-bottom:.25rem">Operating costs</label>
                    <input id="operating_costs" name="operating_costs" type="number" step="1" value="{{ old('operating_costs', $idea?->operating_costs) }}" style="width:100%; padding:.5rem .7rem; border:1px solid var(--border); border-radius:8px">
                </div>
                <div>
                    <label for="expected_revenue" style="display:block; font-weight:600; font-size:.8rem; margin-bottom:.25rem">Expected revenue</label>
                    <input id="expected_revenue" name="expected_revenue" type="number" step="1" value="{{ old('expected_revenue', $idea?->expected_revenue) }}" style="width:100%; padding:.5rem .7rem; border:1px solid var(--border); border-radius:8px">
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

        {{-- Cover image --}}
        <h3 style="margin:1.5rem 0 .75rem; font-size:.85rem; text-transform:uppercase; letter-spacing:.05em; color:var(--text-muted)">Cover image</h3>

        <div style="background:var(--page-bg); border-radius:8px; padding:1rem">
            <div style="display:flex; flex-wrap:wrap; gap:1rem; align-items:flex-start">
                <div style="flex-shrink:0">
                    <img id="coverPreview" src="{{ $previewUrl ?? '' }}" alt="cover preview" style="width:160px; height:160px; object-fit:cover; border-radius:8px; border:1px solid var(--border); background:#fff; {{ $previewUrl ? '' : 'display:none' }}">
                    <div id="coverPlaceholder"
                         style="width:100%; max-width:180px; aspect-ratio:1/1; border-radius:8px; border:1px dashed var(--border); display:flex; align-items:center; justify-content:center; color:var(--text-muted); font-size:.85rem; background:#fff; {{ $previewUrl ? 'display:none' : '' }}">
                        No image
                    </div>
                </div>

                <div style="flex:1; min-width:200px">
                    <input type="file" id="coverInput" accept="image/*" style="display:none">

                    <div style="display:flex; flex-wrap:wrap; gap:.5rem">
                        <button type="button" id="coverPickBtn"
                                style="background:var(--brand); color:#fff; border:0; padding:.55rem 1rem; border-radius:8px; font-weight:600; cursor:pointer; font-size:.85rem">
                            📷 Choose photo
                        </button>
                        <button type="button" id="coverRemoveBtn"
                                style="background:#fff; color:#dc2626; border:1px solid #dc2626; padding:.55rem 1rem; border-radius:8px; font-weight:600; cursor:pointer; font-size:.85rem; {{ $previewUrl ? '' : 'display:none' }}">
                            Remove
                        </button>
                    </div>

                    <div id="coverStatus" style="margin-top:.5rem; font-size:.8rem; color:var(--text-muted)"></div>

                    <input type="text" id="cover_image" name="cover_image"
                           value="{{ old('cover_image', $idea?->cover_image) }}"
                           placeholder="filled after upload"
                           style="width:100%; margin-top:.5rem; padding:.5rem .7rem; border:1px solid var(--border); border-radius:8px; font-size:.85rem; color:var(--text-muted)">

                    <div style="font-size:.75rem; color:var(--text-muted); margin-top:.35rem">
                        JPG · PNG · WEBP · GIF · BMP · SVG · HEIC · AVIF — max 10 MB
                    </div>
                </div>
            </div>
        </div>

        {{-- Publishing --}}
        
        {{-- Additional photos --}}
        <h3 style="margin:1.5rem 0 .75rem; font-size:.85rem; text-transform:uppercase; letter-spacing:.05em; color:var(--text-muted)">Additional photos</h3>

        <div style="background:var(--page-bg); border-radius:8px; padding:1rem">
            <div id="additionalPhotosGrid" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(120px, 1fr)); gap:.75rem; margin-bottom:.75rem"></div>

            <input type="file" id="additionalPhotosInput" accept="image/*" multiple style="display:none">

            <button type="button" id="additionalPhotosPick"
                    style="background:var(--brand); color:#fff; border:0; padding:.55rem 1rem; border-radius:8px; font-weight:600; cursor:pointer; font-size:.85rem">
                📷 Add photos
            </button>

            <span id="additionalPhotosStatus" style="margin-left:.75rem; font-size:.8rem; color:var(--text-muted)"></span>
            <div id="photo_ids_holder"></div>

            <div style="font-size:.75rem; color:var(--text-muted); margin-top:.5rem">
                You can select multiple photos at once. JPG, PNG, WEBP, GIF, BMP, SVG, HEIC, AVIF — max 10 MB each.
            </div>
        </div>
<h3 style="margin:1.5rem 0 .75rem; font-size:.85rem; text-transform:uppercase; letter-spacing:.05em; color:var(--text-muted)">Publishing</h3>
        <label style="display:flex; align-items:center; gap:.5rem; margin-bottom:.75rem; font-size:.9rem">
            <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $idea?->is_featured))> Feature on Home Page
        </label>
        <label style="display:flex; align-items:center; gap:.5rem; margin-bottom:1.25rem; font-size:.9rem">
            <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $idea?->is_published))> Publish immediately
        </label>

        {{-- Actions --}}
        <div style="display:flex; gap:.5rem; flex-wrap:wrap; padding-top:1rem; border-top:1px solid var(--border)">
            <button type="submit" style="background:var(--brand); color:#fff; border:0; padding:.7rem 1.25rem; border-radius:8px; font-weight:600; cursor:pointer">
                {{ $isEdit ? 'Update Idea' : 'Save Idea' }}
            </button>
            <a href="{{ $isEdit ? route('admin.ideas.show', $idea) : route('admin.ideas.index') }}"
               style="padding:.7rem 1.25rem; border:1px solid var(--border); border-radius:8px; text-decoration:none; color:var(--text); font-weight:600">
                Cancel
            </a>
        </div>
    </form>

    <script>
    (function () {
        "use strict";

        var input       = document.getElementById('coverInput');
        var pickBtn     = document.getElementById('coverPickBtn');
        var removeBtn   = document.getElementById('coverRemoveBtn');
        var preview     = document.getElementById('coverPreview');
        var placeholder = document.getElementById('coverPlaceholder');
        var hidden      = document.getElementById('cover_image');
        var status      = document.getElementById('coverStatus');

        if (input && pickBtn) {
            pickBtn.addEventListener('click', function () { input.click(); });

            input.addEventListener('change', function () {
                if (! input.files || ! input.files[0]) return;
                var file = input.files[0];
                if (file.size > 10 * 1024 * 1024) {
                    status.textContent = '⚠️ File is larger than 10 MB.';
                    status.style.color = '#dc2626';
                    return;
                }
                var localUrl = URL.createObjectURL(file);
                preview.src = localUrl;
                preview.style.display = '';
                placeholder.style.display = 'none';
                status.textContent = '⏳ Uploading...';
                status.style.color = 'var(--text-muted)';
                pickBtn.disabled = true;

                var token = document.querySelector('meta[name="csrf-token"]').content;
                var fd = new FormData();
                fd.append('file', file);

                fetch('{{ route('admin.media.cover') }}', {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                    body: fd
                })
                .then(function (r) { return r.text().then(function (t) { var d; try { d = JSON.parse(t); } catch (e) { d = { ok:false, error:'Server: '+t.slice(0,200) }; } return { status:r.status, ok:r.ok, data:d }; }); })
                .then(function (res) {
                    if (res.status === 419) { alert('Session expired. Reloading...'); window.location.reload(); return; }
                    if (! res.ok || ! res.data.ok) throw new Error((res.data && (res.data.message || res.data.error)) || ('HTTP ' + res.status));
                    hidden.value = res.data.url;
                    preview.src = res.data.url;
                    status.textContent = '✅ Uploaded';
                    status.style.color = '#059669';
                    removeBtn.style.display = '';
                })
                .catch(function (err) { status.textContent = '⚠️ ' + err.message; status.style.color = '#dc2626'; preview.style.display = 'none'; placeholder.style.display = ''; hidden.value = ''; })
                .then(function () { pickBtn.disabled = false; input.value = ''; });
            });
        }

        if (removeBtn) {
            removeBtn.addEventListener('click', function () {
                if (! confirm('Remove the cover image?')) return;
                hidden.value = '';
                preview.style.display = 'none';
                preview.src = '';
                placeholder.style.display = '';
                removeBtn.style.display = 'none';
                status.textContent = 'Removed. Save the idea to confirm.';
                status.style.color = 'var(--text-muted)';
            });
        }
    })();
    </script>

    
<!-- PHOTO_UPLOAD_SCRIPT -->
<script>
(function () {
    "use strict";

    function initPhotoUpload() {
        var photoInput  = document.getElementById("additionalPhotosInput");
        var photoPick   = document.getElementById("additionalPhotosPick");
        var photoGrid   = document.getElementById("additionalPhotosGrid");
        var photoStatus = document.getElementById("additionalPhotosStatus");
        var photoHolder = document.getElementById("photo_ids_holder");

        if (!photoInput || !photoPick || !photoGrid) return;

        // Make sure the button is enabled
        photoPick.disabled = false;
        photoPick.removeAttribute("disabled");
        photoPick.style.cursor = "pointer";

        // Prevent double-binding
        if (photoPick.dataset.bound === "1") return;
        photoPick.dataset.bound = "1";

        photoPick.addEventListener("click", function (e) {
            e.preventDefault();
            photoInput.click();
        });

        photoInput.addEventListener("change", function () {
            if (!photoInput.files || photoInput.files.length === 0) return;

            var fd = new FormData();
            for (var i = 0; i < photoInput.files.length; i++) {
                fd.append("files[]", photoInput.files[i]);
            }

            var token = document.querySelector("meta[name=\"csrf-token\"]").content;

            photoStatus.textContent = "⏳ Uploading...";
            photoStatus.style.color = "var(--text-muted)";

            fetch("/admin/media/photos", {
                method: "POST",
                credentials: "same-origin",
                headers: {
                    "X-CSRF-TOKEN": token,
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: fd
            })
            .then(function (r) {
                return r.text().then(function (t) {
                    var d;
                    try { d = JSON.parse(t); }
                    catch (e) { d = { ok: false, error: "Server: " + t.slice(0, 200) }; }
                    return { status: r.status, ok: r.ok, data: d };
                });
            })
            .then(function (res) {
                if (res.status === 419) {
                    alert("Session expired. Reloading...");
                    window.location.reload();
                    return;
                }
                if (!res.ok || !res.data.ok) {
                    throw new Error((res.data && (res.data.message || res.data.error)) || ("HTTP " + res.status));
                }

                res.data.photos.forEach(function (p) {
                    // Add hidden photo id
                    if (photoHolder) {
                        var hidden = document.createElement("input");
                        hidden.type = "hidden";
                        hidden.name = "photo_ids[]";
                        hidden.value = p.id;
                        hidden.setAttribute("data-photo-id", p.id);
                        photoHolder.appendChild(hidden);
                    }

                    // Add thumbnail card
                    var card = document.createElement("div");
                    card.style.cssText = "background:#fff; border:1px solid var(--border); border-radius:8px; overflow:hidden; position:relative";
                    card.innerHTML =
                        "<img src=\"" + p.url + "\" alt=\"" + p.name + "\" style=\"width:100%; width:100%; height:auto; aspect-ratio:1/1; object-fit:cover; display:block\">" +
                        "<button type=\"button\" data-photo-id=\"" + p.id + "\" style=\"position:absolute; top:4px; right:4px; background:#dc2626; color:#fff; border:0; width:22px; height:22px; border-radius:50%; font-size:.7rem; cursor:pointer; line-height:1\">×</button>";
                    photoGrid.appendChild(card);
                });

                photoStatus.textContent = "✅ Uploaded " + res.data.photos.length + " photo(s)";
                photoStatus.style.color = "#059669";
            })
            .catch(function (err) {
                photoStatus.textContent = "⚠️ " + err.message;
                photoStatus.style.color = "#dc2626";
            })
            .then(function () {
                photoInput.value = "";
            });
        });

        photoGrid.addEventListener("click", function (e) {
            if (e.target && e.target.matches("[data-photo-id]")) {
                var pid = e.target.getAttribute("data-photo-id");
                e.target.closest("div").remove();
                if (photoHolder) {
                    var inputs = photoHolder.querySelectorAll("input[data-photo-id=\"" + pid + "\"]");
                    inputs.forEach(function (el) { el.remove(); });
                }
            }
        });
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", initPhotoUpload);
    } else {
        initPhotoUpload();
    }
})();
</script>
@endsection
