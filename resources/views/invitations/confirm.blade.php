<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitation a rejoindre {{ $colocation->name }} - EasyColoc</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .invitation-card {
            max-width: 600px;
            width: 100%;
            background: white;
            border-radius: 32px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .invitation-header {
            background: linear-gradient(135deg, #1a2744 0%, #0f1729 100%);
            padding: 40px 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .invitation-header::before {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(226, 161, 111, 0.08);
            border-radius: 50%;
            top: -60px;
            right: -40px;
        }

        .invitation-header::after {
            content: '';
            position: absolute;
            width: 140px;
            height: 140px;
            background: rgba(226, 161, 111, 0.06);
            border-radius: 50%;
            bottom: -50px;
            left: -30px;
        }

        .logo {
            font-size: 2.5rem;
            font-weight: 800;
            color: #E2A16F;
            margin-bottom: 15px;
            position: relative;
            z-index: 1;
        }

        .invitation-header h1 {
            color: white;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .invitation-header p {
            color: rgba(255, 255, 255, 0.6);
            font-size: 1rem;
            position: relative;
            z-index: 1;
        }

        .invitation-content {
            padding: 40px;
        }

        .colocation-info {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            border: 1px solid #e2e8f0;
        }

        .colocation-name {
            font-size: 2rem;
            font-weight: 800;
            color: #1a2744;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .colocation-name span {
            font-size: 2rem;
        }

        .colocation-description {
            color: #475569;
            line-height: 1.6;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e2e8f0;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-top: 20px;
        }

        .stat-item {
            text-align: center;
            padding: 15px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #E2A16F;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 0.85rem;
            color: #64748b;
            font-weight: 500;
        }

        .inviter-info {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 20px;
            background: white;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            margin-bottom: 30px;
        }

        .inviter-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: linear-gradient(135deg, #E2A16F, #c8834d);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 700;
            color: white;
            flex-shrink: 0;
        }

        .inviter-details {
            flex: 1;
        }

        .inviter-name {
            font-size: 1.3rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 5px;
        }

        .inviter-role {
            color: #E2A16F;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .inviter-email {
            color: #64748b;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn-accept {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 16px 24px;
            border-radius: 16px;
            font-size: 1.1rem;
            font-weight: 700;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.3);
        }

        .btn-accept:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 12px -1px rgba(16, 185, 129, 0.4);
        }

        .btn-reject {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: #fef2f2;
            border: 2px solid #fecaca;
            color: #dc2626;
            padding: 16px 24px;
            border-radius: 16px;
            font-size: 1.1rem;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-reject:hover {
            background: #fee2e2;
            border-color: #fca5a5;
        }

        .expiry-note {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 15px;
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 12px;
            margin-top: 20px;
            color: #92400e;
            font-size: 0.9rem;
        }

        .footer {
            text-align: center;
            padding: 20px 40px;
            border-top: 1px solid #e2e8f0;
            color: #64748b;
            font-size: 0.9rem;
        }

        .footer a {
            color: #E2A16F;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .warning-box {
            background: #fff7ed;
            border: 1px solid #fed7aa;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #9a3412;
        }

        .warning-box svg {
            flex-shrink: 0;
        }

        @media (max-width: 640px) {
            .invitation-content {
                padding: 20px;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .inviter-info {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="invitation-card">
        <!-- Header -->
        <div class="invitation-header">
            <div class="logo">EasyColoc</div>
            <h1>Vous avez ete invite !</h1>
            <p>Rejoignez une colocation et simplifiez la gestion des depenses</p>
        </div>

        <!-- Contenu -->
        <div class="invitation-content">
            <!-- Avertissement si deja connecte avec un email different -->
            @if(auth()->check() && auth()->user()->email !== $invitation->email)
                <div class="warning-box">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <div>
                        <strong>Attention :</strong> Vous êtes connecte avec <strong>{{ auth()->user()->email }}</strong>, mais cette invitation a ete envoyee a <strong>{{ $invitation->email }}</strong>.
                    </div>
                </div>
            @endif

            <!-- Informations de la colocation -->
            <div class="colocation-info">
                <div class="colocation-name">
                    <span>🏠</span>
                    {{ $colocation->name }}
                </div>
                
                @if($colocation->description)
                    <div class="colocation-description">
                        {{ $colocation->description }}
                    </div>
                @endif

                <!-- Statistiques -->
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-value">{{ $memberCount }}</div>
                        <div class="stat-label">Membres</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ number_format($totalExpenses, 0) }}</div>
                        <div class="stat-label">Depenses</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $colocation->created_at->format('d/m/Y') }}</div>
                        <div class="stat-label">Creee le</div>
                    </div>
                </div>
            </div>

            <!-- Informations sur l'inviteur -->
            <div class="inviter-info">
                <div class="inviter-details">
                    <div class="inviter-name">{{ $inviter->name }}</div>
                    <div class="inviter-role">Owner de la colocation</div>
                    <div class="inviter-email">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                        {{ $inviter->email }}
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="action-buttons">
                <a href="{{ route('invitations.accept', $invitation->token) }}" class="btn-accept">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                    Accepter l'invitation
                </a>
                
                <a href="{{ route('invitations.reject', $invitation->token) }}" class="btn-reject" 
                   onclick="return confirm('Êtes-vous sûr de vouloir refuser cette invitation ?')">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                    Refuser
                </a>
            </div>

            <!-- Note pour les non-connectes -->
            @if(!auth()->check())
                <div style="margin-top: 15px; text-align: center; color: #64748b; font-size: 0.9rem;">
                    Vous n'avez pas de compte ? <a href="{{ route('register') }}" target="_blank" style="color: #E2A16F; font-weight: 600;">Creez-en un</a> après avoir accepte.
                </div>
            @endif
        </div>
    </div>
</body>
</html>