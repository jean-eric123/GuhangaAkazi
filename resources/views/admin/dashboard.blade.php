@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
    <h2 class="page-title">Welcome back, {{ auth('admin')->user()->name }}</h2>
    <p class="page-subtitle">
        Here is a quick overview of GuhangaAkazi's content.
        @if (auth('admin')->user()->last_login_at)
            Last sign-in: {{ auth('admin')->user()->last_login_at->diffForHumans() }}.
        @endif
    </p>

    <h3 style="margin-top:1.5rem; font-size:0.95rem; text-transform:uppercase; letter-spacing:.05em; color:var(--text-muted)">
        Business Ideas
    </h3>
    <div class="stats-grid">
        <div class="stat-card">
            <span class="stat-label">Total</span>
            <span class="stat-value">{{ $stats['ideas_total'] }}</span>
            <span class="stat-hint">All business ideas</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Published</span>
            <span class="stat-value" style="color:var(--success)">{{ $stats['ideas_published'] }}</span>
            <span class="stat-hint">Visible on public site</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Drafts</span>
            <span class="stat-value" style="color:var(--warning)">{{ $stats['ideas_draft'] }}</span>
            <span class="stat-hint">Not yet published</span>
        </div>
    </div>

    <h3 style="margin-top:1.5rem; font-size:0.95rem; text-transform:uppercase; letter-spacing:.05em; color:var(--text-muted)">
        Skills & Opportunities
    </h3>
    <div class="stats-grid">
        <div class="stat-card">
            <span class="stat-label">Skills Total</span>
            <span class="stat-value">{{ $stats['skills_total'] }}</span>
            <span class="stat-hint">{{ $stats['skills_published'] }} published</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Opportunities</span>
            <span class="stat-value">{{ $stats['opportunities_total'] }}</span>
            <span class="stat-hint">{{ $stats['opportunities_published'] }} published</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Articles</span>
            <span class="stat-value">{{ $stats['posts_total'] }}</span>
            <span class="stat-hint">{{ $stats['posts_published'] }} published</span>
        </div>
    </div>

    <h3 style="margin-top:1.5rem; font-size:0.95rem; text-transform:uppercase; letter-spacing:.05em; color:var(--text-muted)">
        Media
    </h3>
    <div class="stats-grid">
        <div class="stat-card">
            <span class="stat-label">Photos</span>
            <span class="stat-value">{{ $stats['photos_total'] }}</span>
            <span class="stat-hint">In the gallery</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Videos</span>
            <span class="stat-value">{{ $stats['videos_total'] }}</span>
            <span class="stat-hint">Uploaded or linked</span>
        </div>
    </div>

    <h3 style="margin-top:1.5rem; font-size:0.95rem; text-transform:uppercase; letter-spacing:.05em; color:var(--text-muted)">
        System
    </h3>
    <div class="stats-grid">
        <div class="stat-card">
            <span class="stat-label">Categories</span>
            <span class="stat-value">{{ $stats['categories_total'] }}</span>
            <span class="stat-hint">Across all content types</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Contact Messages</span>
            <span class="stat-value">{{ $stats['messages_total'] }}</span>
            <span class="stat-hint">
                @if ($stats['messages_unread'] > 0)
                    <strong style="color:var(--danger)">{{ $stats['messages_unread'] }} unread</strong>
                @else
                    All read
                @endif
            </span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Settings</span>
            <span class="stat-value">{{ $stats['settings_total'] }}</span>
            <span class="stat-hint">Website configuration</span>
        </div>
    </div>
@endsection
