{{-- resources/views/emails/invitation.blade.php --}}
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitation a rejoindre {{ $colocation->name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Outfit', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background: #f8f9fa;
            color: #1f2937;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        .email-wrapper {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .email-header {
            background: linear-gradient(135deg, #1a2744 0%, #0f1729 100%);
            padding: 40px 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .email-header::before {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(226, 161, 111, 0.08);
            border-radius: 50%;
            top: -60px;
            right: -40px;
        }

        .email-header::after {
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
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }

        .logo span {
            font-size: 2rem;
            font-weight: 800;
            color: #E2A16F;
            letter-spacing: 1px;
        }

        .email-header h1 {
            color: #ffffff;
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0 0 10px;
            position: relative;
            z-index: 1;
        }

        .email-header p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1rem;
            position: relative;
            z-index: 1;
        }

        .email-content {
            padding: 40px;
            background: #ffffff;
        }

        .greeting {
            font-size: 1.2rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 20px;
        }

        .message-box {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 30px;
        }

        .colocation-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: #E2A16F;
            margin-bottom: 8px;
        }

        .inviter-info {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 20px 0;
            padding: 16px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
        }

        .inviter-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, #E2A16F, #c8834d);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: 700;
            color: #ffffff;
            flex-shrink: 0;
        }

        .inviter-details {
            flex: 1;
        }

        .inviter-name {
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 4px;
        }

        .inviter-role {
            font-size: 0.9rem;
            color: #6b7280;
        }

        .button-container {
            text-align: center;
            margin: 35px 0;
        }

        .accept-button {
            display: inline-block;
            background: linear-gradient(135deg, #E2A16F, #c8834d);
            color: #ffffff;
            font-weight: 700;
            font-size: 1.1rem;
            padding: 14px 36px;
            border-radius: 12px;
            text-decoration: none;
            box-shadow: 0 4px 14px rgba(226, 161, 111, 0.4);
            transition: all 0.2s ease;
        }

        .accept-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(226, 161, 111, 0.5);
        }

        .info-box {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 12px;
            padding: 20px;
            margin: 30px 0;
        }

        .info-title {
            font-weight: 700;
            color: #0369a1;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-title svg {
            width: 20px;
            height: 20px;
        }

        .info-text {
            color: #0c4a6e;
            font-size: 0.95rem;
        }

        .info-text ul {
            margin: 10px 0 0 20px;
        }

        .info-text li {
            margin-bottom: 6px;
        }

        .expiry-note {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 8px;
            padding: 12px 16px;
            color: #92400e;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .footer {
            border-top: 1px solid #e5e7eb;
            padding: 30px 40px 20px;
            text-align: center;
        }

        .footer-logo {
            color: #9ca3af;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .footer-text {
            color: #9ca3af;
            font-size: 0.85rem;
            margin-bottom: 4px;
        }

        .footer-link {
            color: #E2A16F;
            text-decoration: none;
            font-size: 0.85rem;
        }

        .footer-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            .email-wrapper {
                margin: 20px;
                border-radius: 16px;
            }

            .email-header {
                padding: 30px 20px;
            }

            .email-content {
                padding: 30px 20px;
            }

            .footer {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="email-wrapper">
        <div class="email-header">
            <div class="logo">
                <span>EasyColoc</span>
            </div>
            <h1>Vous avez ete invite !</h1>
            <p>Rejoignez la colocation et simplifiez la gestion des depenses</p>
        </div>

        <!-- Contenu principal -->
        <div class="email-content">
            <div class="greeting">
                Bonjour,
            </div>

            <div class="message-box">
                <div class="colocation-name">
                    🏠 {{ $colocation->name }}
                </div>
                <p style="color: #4b5563; margin-top: 12px;">
                    Vous avez ete invite par <strong>{{ $inviter->name }}</strong> a rejoindre cette colocation.
                    EasyColoc vous aidera a gerer facilement les depenses communes et a savoir qui doit quoi a qui.
                </p>
            </div>

            <!-- Bouton d'acceptation -->

            <div class="button-container">
                <a href="{{ route('invitations.confirm', $invitation->token) }}" class="accept-button">
                    Voir l'invitation
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-logo">EasyColoc</div>
            <div class="footer-text" style="margin-top: 15px;">
                © {{ date('Y') }} EasyColoc. Tous droits reserves.
            </div>
        </div>
    </div>
</body>

</html>