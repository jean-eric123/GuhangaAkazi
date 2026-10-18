@extends('admin.layouts.app')

@php
    $isEdit = $idea !== null;
    $title  = $isEdit ? 'Edit Business Idea' : 'New Business Idea';
    $action = $isEdit ? route('admin.ideas.update', $idea) : route('admin.ideas.store');
    $v      = function ($key) use ($en) { return old($key, $en?->{$key}); };
@endphp

@section('title', $title)
@section('page_title', $title)

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem; flex-wrap:wrap; gap:.5rem">
        <div>
            <h2 class="page-title" style="margin-bottom:.25rem">{{ $title }}</h2>
            <p class="page-subtitle" style="margin:0">
                @if ($isEdit) Updating: <code>{{ $idea->slug }}</code> @else The slug is generated automatically from the title. @endif
            </p>
        </div>
        <a href="{{ route('admin.ideas.index') }}" style="color:var(--text-muted); text-decoration:none; font-size:.9rem">← Back to list</a>
    </div>

    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if ($errors->any())
        <div class="alert alert-error">
            <ul style="margin:0; padding-left:1.25rem">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ $action }}" style="background:#fff; border:1px solid var(--border); border-radius:12px; padding:1.25rem">
        @csrf
        @if ($isEdit) @method('PUT') @endif

        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:1rem; margin-bottom:1.25rem">
            <div>
                <label for="slug" style="display:block; font-weight:600; font-size:.85rem; margin-bottom:.3rem">Slug (URL)</label>
                <input id="slug" name="slug" type="text" value="{{ old('slug', $idea?->slug) }}" placeholder="auto-generated" style="width:100%; padding:.55rem .8rem; border:1px solid var(--border); border-radius:8px">
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
                <input id="capital" name="capital" type="number" step="1" min="0" value="{{ old('capital', $idea?->capital) }}" style="width:100%; padding:.55rem .8rem; border:1px solid var(--border); border-radius:8px">
            </div>
            <div>
                <label for="expected_profit" style="display:block; font-weight:600; font-size:.85rem; margin-bottom:.3rem">Expected profit</label>
                <input id="expected_profit" name="expected_profit" type="number" step="1" min="0" value="{{ old('expected_profit', $idea?->expected_profit) }}" style="width:100%; padding:.55rem .8rem; border:1px solid var(--border); border-radius:8px">
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
                <label for="en_steps" style="display:block; font-weight:600; font-size:.85rem; margin-bottom:.3rem">Steps</label>
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
                        <option value="easy" @selected(old('difficulty_level', $idea?->difficulty_level) === 'easy')>Easy</option>
                        <option value="medium" @selected(old('difficulty_level', $idea?->difficulty_level) === 'medium')>Medium</option>
                        <option value="hard" @selected(old('difficulty_level', $idea?->difficulty_level) === 'hard')>Hard</option>
                    </select>
                </div>
                <div>
                    <label for="time_to_start" style="display:block; font-weight:600; font-size:.8rem; margin-bottom:.25rem">Time to start</label>
                    <input id="time_to_start" name="time_to_start" type="text" value="{{ old('time_to_start', $idea?->time_to_start) }}" style="width:100%; padding:.5rem .7rem; border:1px solid var(--border); border-radius:8px">
                </div>
            </div>
        </details>

        <h3 style="margin:1.5rem 0 .75rem; font-size:.85rem; text-transform:uppercase; color:var(--text-muted)">Cover image</h3>
        <div style="background:var(--page-bg); border-radius:8px; padding:1rem">
            <input type="file" id="coverInput" accept="image/*" style="display:none">
            <div id="coverPickerBtn" style="background:var(--brand); color:#fff; display:inline-block; padding:.55rem 1rem; border-radius:8px; font-weight:600; cursor:pointer; font-size:.85rem">📷 Choose photo</div>
            <span id="coverStatus" style="margin-left:.75rem; font-size:.8rem; color:var(--text-muted)"></span>
            <div id="coverPreviewWrap" style="margin-top:1rem; display:none">
                <img id="coverPreview" src="" style="width:180px; height:180px; object-fit:cover; border-radius:8px;">
                <br><button type="button" id="coverRemoveBtn" style="margin-top:.5rem; color:#dc2626; background:none; border:0; cursor:pointer; font-weight:600; font-size:.85rem">Remove</button>
            </div>
            <input type="hidden" id="cover_image" name="cover_image" value="{{ old('cover_image', $idea?->cover_image) }}">
        </div>

        <h3 style="margin:1.5rem 0 .75rem; font-size:.85rem; text-transform:uppercase; color:var(--text-muted)">Additional photos</h3>
        <div style="background:var(--page-bg); border-radius:8px; padding:1rem">
            <input type="file" id="photoInput" accept="image/*" multiple style="display:none">
            <div id="photoPickerBtn" style="background:var(--brand); color:#fff; display:inline-block; padding:.55rem 1rem; border-radius:8px; font-weight:600; cursor:pointer; font-size:.85rem">📷 Add photos</div>
            <span id="photoStatus" style="margin-left:.75rem; font-size:.8rem; color:var(--text-muted)"></span>
            <div id="photoGrid" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(100px, 1fr)); gap:.5rem; margin-top:1rem"></div>
            <div id="photo_ids_holder"></div>
        </div>

            @if($idea && $idea->video_url)
                <div style="margin-top:1rem;">
                    <span style="font-size:.8rem; font-weight:600;">Current Video:</span><br>
                    <a href="{{ $idea->video_url }}" target="_blank" style="font-size:.8rem; color:var(--brand); word-break:break-all;">{{ $idea->video_url }}</a>
                </div>
            @endif
        </div>

        <h3 style="margin:1.5rem 0 .75rem; font-size:.85rem; text-transform:uppercase; color:var(--text-muted); text-align:center;">Publishing</h3>

        <div style="display:flex; flex-direction:column; align-items:center; gap:1rem; margin-bottom:2rem;">
            <label style="display:flex; align-items:center; gap:.5rem; font-size:.9rem; cursor:pointer;">
                <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $idea?->is_featured))> Feature on Home Page
            </label>
            <label style="display:flex; align-items:center; gap:.5rem; font-size:.9rem; cursor:pointer;">
                <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $idea?->is_published))> Publish immediately
            </label>
        </div>

        <div style="display:flex; justify-content:center; gap:1rem; padding-top:1.5rem; border-top:1px solid var(--border);">
            <button type="submit" style="background:var(--brand); color:#fff; border:0; padding:.75rem 2rem; border-radius:8px; font-weight:600; cursor:pointer; font-size:1rem;">
                {{ $isEdit ? 'Update Idea' : 'Save Idea' }}
            </button>
            <a href="{{ route('admin.ideas.index') }}" style="padding:.75rem 2rem; border:1px solid var(--border); border-radius:8px; text-decoration:none; color:var(--text); font-weight:600; text-align:center; font-size:1rem;">
                Cancel
            </a>
        </div>
</form>

    <script>
    (function() {
        var csrf = document.querySelector('meta[name="csrf-token"]').content;
        
        // --- Cover Upload ---
        var cInput = document.getElementById('coverInput'), cBtn = document.getElementById('coverPickerBtn'), cStatus = document.getElementById('coverStatus'), cWrap = document.getElementById('coverPreviewWrap'), cImg = document.getElementById('coverPreview'), cHidden = document.getElementById('cover_image'), cRemove = document.getElementById('coverRemoveBtn');
        if (cHidden.value) { cWrap.style.display='block'; cImg.src = cHidden.value; }
        cBtn.onclick = () => cInput.click();
        cRemove.onclick = () => { cHidden.value=''; cWrap.style.display='none'; };
        cInput.onchange = function() {
            if(!cInput.files[0]) return;
            var fd = new FormData(); fd.append('file', cInput.files[0]);
            cStatus.textContent = '⏳ Uploading...';
            fetch('/admin/media/cover', { method:'POST', headers:{'X-CSRF-TOKEN':csrf, 'Accept':'application/json'}, body:fd })
            .then(r=>r.json()).then(d=>{
                if(!d.ok) throw new Error(d.error);
                cHidden.value = d.url; cImg.src = d.url; cWrap.style.display='block'; cStatus.textContent='✅ Uploaded';
            }).catch(e=>cStatus.textContent='⚠️ '+e.message).then(()=>cInput.value='');
        };

        // --- Photos Upload ---
        var pInput = document.getElementById('photoInput'), pBtn = document.getElementById('photoPickerBtn'), pStatus = document.getElementById('photoStatus'), pGrid = document.getElementById('photoGrid'), pHolder = document.getElementById('photo_ids_holder');
        pBtn.onclick = () => pInput.click();
        pInput.onchange = function() {
            if(!pInput.files.length) return;
            var fd = new FormData(); for(var i=0;i<pInput.files.length;i++) fd.append('files[]', pInput.files[i]);
            pStatus.textContent = '⏳ Uploading...';
            fetch('/admin/media/photos', { method:'POST', headers:{'X-CSRF-TOKEN':csrf, 'Accept':'application/json'}, body:fd })
            .then(r=>r.json()).then(d=>{
                if(!d.ok) throw new Error(d.error);
                d.photos.forEach(p=>{
                    var h = document.createElement('input'); h.type='hidden'; h.name='photo_ids[]'; h.value=p.id; pHolder.appendChild(h);
                    var img = document.createElement('img'); img.src=p.url; img.style.cssText='width:100%; height:100px; object-fit:cover; border-radius:8px;';
                    pGrid.appendChild(img);
                });
                pStatus.textContent='✅ Uploaded';
            }).catch(e=>pStatus.textContent='⚠️ '+e.message).then(()=>pInput.value='');
        };

        // --- Videos Upload ---
        var vInput = document.getElementById('videoInput'), vBtn = document.getElementById('videoPickerBtn'), vStatus = document.getElementById('videoStatus'), vGrid = document.getElementById('videoGrid'), vHolder = document.getElementById('video_ids_holder');
        vBtn.onclick = () => vInput.click();
        vInput.onchange = function() {
            if(!vInput.files.length) return;
            
            const CHUNK_SIZE = 4 * 1024 * 1024; // 4 MB
            const PARALLEL = 3;                   // 3 parallel chunks
            
            for (let f = 0; f < vInput.files.length; f++) {
                (function(file) {
                    // Show "Uploading..." placeholder immediately
                    let placeholderId = 'upl_' + Math.random().toString(36).substring(2, 9);
                    let div = document.createElement('div');
                    div.id = placeholderId;
                    div.style.cssText = 'background:#1e293b; color:#fff; padding:1rem; border-radius:8px; font-size:.8rem; word-break:break-all; display:flex; align-items:center; gap:.5rem;';
                    div.innerHTML = '<span style="display:inline-block; width:16px; height:16px; border:2px solid #fff; border-top-color:transparent; border-radius:50%; animation:spin 0.8s linear infinite;"></span> Uploading ' + file.name;
                    vGrid.appendChild(div);
                    vStatus.textContent = '';
                    
                    // Inject spinner CSS once
                    if (!document.getElementById('spinCss')) {
                        var s = document.createElement('style'); s.id = 'spinCss';
                        s.textContent = '@keyframes spin { to { transform: rotate(360deg); } }';
                        document.head.appendChild(s);
                    }
                    
                    let totalChunks = Math.ceil(file.size / CHUNK_SIZE);
                    let fileId = Math.random().toString(36).substring(2, 10) + Date.now();
                    let completed = 0;
                    
                    // Upload all chunks with concurrency limit
                    let nextChunk = 0;
                    let activeUploads = 0;
                    let failed = false;
                    
                    function uploadOne() {
                        if (failed) return;
                        if (nextChunk >= totalChunks && activeUploads === 0) return;
                        if (activeUploads >= PARALLEL) return;
                        
                        if (nextChunk >= totalChunks) return;
                        
                        let i = nextChunk++;
                        activeUploads++;
                        
                        let startByte = i * CHUNK_SIZE;
                        let endByte = Math.min(startByte + CHUNK_SIZE, file.size);
                        let chunk = file.slice(startByte, endByte);
                        
                        let fd = new FormData();
                        fd.append('chunk', chunk);
                        fd.append('fileId', fileId);
                        fd.append('fileName', file.name);
                        fd.append('chunkIndex', i);
                        fd.append('totalChunks', totalChunks);
                        
                        fetch('/admin/media/video-chunk', {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                            body: fd
                        }).then(r => r.text()).then(text => {
                            let d;
                            try { d = JSON.parse(text); } catch(e) { throw new Error('Server error: ' + text.slice(0, 80)); }
                            if (!d.ok) throw new Error(d.error || 'Chunk failed');
                            
                            completed++;
                            activeUploads--;
                            
                            if (d.complete) {
                                // Upload finished — replace placeholder with real video
                                var el = document.getElementById(placeholderId);
                                if (el) el.remove();
                                
                                var h = document.createElement('input');
                                h.type='hidden'; h.name='video_ids[]'; h.value=d.video.id;
                                vHolder.appendChild(h);
                                
                                var finalDiv = document.createElement('div');
                                finalDiv.style.cssText='background:#000; color:#fff; padding:1rem; border-radius:8px; font-size:.8rem; word-break:break-all;';
                                finalDiv.textContent = '🎥 ' + d.video.name;
                                vGrid.appendChild(finalDiv);
                                
                                vStatus.textContent = '✅ Video added';
                                vStatus.style.color = '#059669';
                            } else {
                                uploadOne();
                            }
                        }).catch(err => {
                            failed = true;
                            activeUploads--;
                            var el = document.getElementById(placeholderId);
                            if (el) { el.innerHTML = '⚠️ Failed: ' + err.message; el.style.background = '#7f1d1d'; }
                            vStatus.textContent = '⚠️ ' + err.message;
                            vStatus.style.color = '#dc2626';
                        });
                    }
                    
                    // Start parallel uploads
                    for (let p = 0; p < PARALLEL; p++) uploadOne();
                })(vInput.files[f]);
            }
            vInput.value = '';
        };
    })();
        // Submit guard: warn if videos are still uploading
    (function() {
        var form = document.querySelector('form');
        if (!form) return;
        form.addEventListener('submit', function(e) {
            var uploading = document.querySelectorAll('[id^="upl_"]');
            if (uploading.length > 0) {
                if (!confirm('A video is still uploading. Submit anyway? (The video will be lost.)')) {
                    e.preventDefault();
                }
            }
        });
    })();
    </script>
@endsection