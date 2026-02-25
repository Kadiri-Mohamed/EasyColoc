@extends('admin.layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Tableau de bord')

@push('styles')
    <style>
        /* ── STAT CARDS ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.25rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: #fff;
            border: 1px solid #D1D3D4;
            border-radius: 16px;
            padding: 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            transition: box-shadow 0.2s, transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.07);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        .stat-value {
            font-size: 1.9rem;
            font-weight: 800;
            line-height: 1;
            color: #1f2937;
        }

        .stat-label {
            font-size: 0.82rem;
            color: #9ca3af;
            font-weight: 500;
            margin-top: 0.3rem;
        }

        .stat-sub {
            font-size: 0.78rem;
            color: #6b7280;
            margin-top: 0.4rem;
        }

        /* ── SECTION TITLE ── */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .section-title {
            font-size: 1rem;
            font-weight: 700;
            color: #1f2937;
        }

        .section-link {
            font-size: 0.85rem;
            color: #E2A16F;
            font-weight: 600;
            text-decoration: none;
        }

        .section-link:hover {
            color: #c8834d;
            text-decoration: underline;
        }

        /* ── TABLES ── */
        .admin-card {
            background: #fff;
            border: 1px solid #D1D3D4;
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .admin-card-header {
            padding: 1.1rem 1.5rem;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
        }

        .admin-table th {
            padding: 0.75rem 1.25rem;
            background: #f9fafb;
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #6b7280;
            text-align: left;
            border-bottom: 1px solid #f3f4f6;
        }

        .admin-table td {
            padding: 0.85rem 1.25rem;
            font-size: 0.9rem;
            border-bottom: 1px solid #f9fafb;
            color: #374151;
        }

        .admin-table tr:last-child td {
            border-bottom: none;
        }

        .admin-table tbody tr:hover {
            background: #fafafa;
        }

        /* ── BADGES ── */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-success {
            background: #f0fdf4;
            color: #16a34a;
        }

        .badge-danger {
            background: #fef2f2;
            color: #dc2626;
        }

        .badge-warning {
            background: #fffbeb;
            color: #d97706;
        }

        .badge-info {
            background: #eff6ff;
            color: #2563eb;
        }

        /* ── 2 COL LAYOUT ── */
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        @media (max-width: 900px) {
            .grid-2 {
                grid-template-columns: 1fr;
            }
        }

        /* ── AVATAR ── */
        .user-avatar-sm {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #E2A16F, #c8834d);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        .user-cell {
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .user-cell-name {
            font-weight: 600;
            color: #1f2937;
        }

        .user-cell-email {
            font-size: 0.78rem;
            color: #9ca3af;
        }

        /* ── PROGRESS BARS ── */
        .progress-bar-wrap {
            background: #f3f4f6;
            border-radius: 50px;
            height: 6px;
            overflow: hidden;
            flex: 1;
        }

        .progress-bar-fill {
            height: 100%;
            border-radius: 50px;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <table>
            <tr>
                <th>id</th>
                <th>name</th>
                <th>email</th>
                <th>reputation</th>
                <th>status</th>
                <th>Action</th>
            </tr>
            @foreach($allUsers as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->reputation}}</td>
                    <td>{{$user->status}}</td>
                    <td>
                        <a href="">Ban</a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection