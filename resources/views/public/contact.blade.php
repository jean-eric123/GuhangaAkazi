@extends('public.layouts.app')
@section('content')
<div style="background: #f9fafb; min-height: 80vh; padding: 4rem 1rem;">
    <div style="max-width: 800px; margin: 0 auto;">
        <h1 style="font-size: 2.5rem; font-weight: 800; color: #064e3b; text-align: center; margin-bottom: 1rem;">Contact Us</h1>
        <p style="text-align: center; color: #6b7280; margin-bottom: 3rem; font-size: 1.1rem;">Have a question or need assistance? We'd love to hear from you.</p>
        
        <div style="background: white; border-radius: 12px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); padding: 2.5rem; display: grid; gap: 2rem;">
            
            <div style="display: flex; align-items: flex-start; gap: 1rem;">
                <div style="background: #ecfdf5; color: #0B6B4F; padding: 1rem; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <h3 style="font-weight: 700; color: #111827; margin-bottom: 0.25rem;">Email Us</h3>
                    <p style="color: #4b5563;">{{ $settings['contact_email'] ?? 'info@guhangakazi.com' }}</p>
                </div>
            </div>

            <div style="display: flex; align-items: flex-start; gap: 1rem;">
                <div style="background: #ecfdf5; color: #0B6B4F; padding: 1rem; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                </div>
                <div>
                    <h3 style="font-weight: 700; color: #111827; margin-bottom: 0.25rem;">Call Us</h3>
                    <p style="color: #4b5563;">{{ $settings['contact_phone'] ?? '+250 788 000 000' }}</p>
                </div>
            </div>

            <div style="display: flex; align-items: flex-start; gap: 1rem;">
                <div style="background: #ecfdf5; color: #0B6B4F; padding: 1rem; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <div>
                    <h3 style="font-weight: 700; color: #111827; margin-bottom: 0.25rem;">Location</h3>
                    <p style="color: #4b5563;">Kigali, Rwanda<br>East Africa</p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection