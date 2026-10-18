@extends('admin.layouts.app')
@section('title', 'Website Settings')
@section('page_title', 'Website Settings')

@section('content')
    <div style="background:#fff; padding:1.5rem; border-radius:12px;">
        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

        <form method="POST" action="{{ route('admin.settings.update') }}">
            @csrf

            <h3 style="margin-top:0; color:var(--brand);">Contact Information</h3>
            <div style="margin-bottom:1rem;">
                <label style="font-weight:600; display:block; margin-bottom:.3rem;">Email Address</label>
                <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? '' }}" style="width:100%; padding:.5rem; border:1px solid var(--border); border-radius:8px;">
            </div>
            <div style="margin-bottom:1rem;">
                <label style="font-weight:600; display:block; margin-bottom:.3rem;">Phone Number</label>
                <input type="text" name="contact_phone" value="{{ $settings['contact_phone'] ?? '' }}" style="width:100%; padding:.5rem; border:1px solid var(--border); border-radius:8px;">
            </div>
            <div style="margin-bottom:2rem;">
                <label style="font-weight:600; display:block; margin-bottom:.3rem;">Physical Address</label>
                <input type="text" name="contact_address" value="{{ $settings['contact_address'] ?? '' }}" style="width:100%; padding:.5rem; border:1px solid var(--border); border-radius:8px;">
            </div>

            <h3 style="color:var(--brand);">Social Media Links</h3>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:2rem;">
                <div>
                    <label style="font-weight:600; display:block; margin-bottom:.3rem;">Facebook URL</label>
                    <input type="url" name="facebook_url" value="{{ $settings['facebook_url'] ?? '' }}" style="width:100%; padding:.5rem; border:1px solid var(--border); border-radius:8px;">
                </div>
                <div>
                    <label style="font-weight:600; display:block; margin-bottom:.3rem;">Instagram URL</label>
                    <input type="url" name="instagram_url" value="{{ $settings['instagram_url'] ?? '' }}" style="width:100%; padding:.5rem; border:1px solid var(--border); border-radius:8px;">
                </div>
                <div>
                    <label style="font-weight:600; display:block; margin-bottom:.3rem;">Twitter (X) URL</label>
                    <input type="url" name="twitter_url" value="{{ $settings['twitter_url'] ?? '' }}" style="width:100%; padding:.5rem; border:1px solid var(--border); border-radius:8px;">
                </div>
                <div>
                    <label style="font-weight:600; display:block; margin-bottom:.3rem;">YouTube URL</label>
                    <input type="url" name="youtube_url" value="{{ $settings['youtube_url'] ?? '' }}" style="width:100%; padding:.5rem; border:1px solid var(--border); border-radius:8px;">
                </div>
            </div>

            <button type="submit" style="background:var(--brand); color:#fff; padding:.7rem 1.5rem; border-radius:8px; border:0; font-weight:600; cursor:pointer;">Save Settings</button>
        </form>
    </div>
@endsection
