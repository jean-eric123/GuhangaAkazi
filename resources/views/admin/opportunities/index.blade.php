@extends("admin.layouts.app")
@section("content")
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem;">
    <h1 style="font-size:1.5rem; font-weight:bold;">Opportunities</h1>
    <a href="{{ route("admin.opportunities.create") }}" style="background:#0B6B4F; color:white; padding:0.5rem 1rem; border-radius:0.375rem; text-decoration:none;">+ Add Opportunity</a>
</div>
@if(session("success"))<div style="background:#d1fae5; padding:1rem; margin-bottom:1rem; border-radius:0.375rem;">{{ session("success") }}</div>@endif
<div style="background:white; border-radius:0.5rem; box-shadow:0 1px 3px rgba(0,0,0,0.1); overflow-x:auto;">
    <table style="width:100%; border-collapse:collapse; text-align:left;">
        <thead style="background:#f9fafb; border-bottom:1px solid #e5e7eb;">
            <tr><th style="padding:1rem;">Title</th><th style="padding:1rem;">Status</th><th style="padding:1rem; text-align:right;">Actions</th></tr>
        </thead>
        <tbody>
            @forelse($opportunities as $opp)
                <tr style="border-bottom:1px solid #e5e7eb;">
                    <td style="padding:1rem; font-weight:600;">{{ $opp->title ?? "Untitled" }}</td>
                    <td style="padding:1rem;"><span style="background:{{ $opp->is_published ? "#d1fae5" : "#fef3c7" }}; color:{{ $opp->is_published ? "#064e3b" : "#92400e" }}; padding:0.25rem 0.5rem; border-radius:99px; font-size:0.75rem;">{{ $opp->is_published ? "Published" : "Draft" }}</span></td>
                    <td style="padding:1rem; text-align:right;">
                        <a href="{{ route("admin.opportunities.edit", $opp) }}" style="color:#0B6B4F; margin-right:1rem; text-decoration:none;">Edit</a>
                        <form action="{{ route("admin.opportunities.destroy", $opp) }}" method="POST" style="display:inline;">@csrf @method("DELETE")<button type="submit" style="color:red; background:none; border:none; cursor:pointer;">Delete</button></form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3" style="padding:2rem; text-align:center; color:#6b7280;">No opportunities found. Click "+ Add Opportunity" to create one.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div style="margin-top:1rem;">{{ $opportunities->links() }}</div>
@endsection