<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="EasyColoc — La plateforme qui simplifie votre recherche de colocation. Trouvez le logement idéal parmi des centaines d'annonces vérifiées.">

        <title>EasyColoc — Trouvez votre colocation idéale</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

        <!-- Vite assets -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
            html { scroll-behavior: smooth; }
            body {
                font-family: 'Outfit', sans-serif;
                background: #FFF0DD;
                color: #1f2937;
                overflow-x: hidden;
            }

            /* ── NAVBAR ── */
            .navbar {
                position: fixed;
                top: 0; left: 0; right: 0;
                z-index: 100;
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 0 5%;
                height: 70px;
                background: rgba(255, 240, 221, 0.85);
                backdrop-filter: blur(16px);
                border-bottom: 1px solid rgba(209, 211, 212, 0.5);
                box-shadow: 0 2px 20px rgba(226, 161, 111, 0.08);
            }

            .navbar-brand {
                display: flex;
                align-items: center;
                gap: 0.65rem;
                text-decoration: none;
            }

            .navbar-brand img {
                width: 40px;
                height: 40px;
                object-fit: contain;
                border-radius: 10px;
            }

            .navbar-brand span {
                font-size: 1.3rem;
                font-weight: 700;
                color: #E2A16F;
                letter-spacing: -0.02em;
            }

            /* ── HERO ── */
            .hero {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-align: center;
                padding: 100px 5% 60px;
                position: relative;
                overflow: hidden;
            }

            /* Blobs décoratifs */
            .blob {
                position: absolute;
                border-radius: 50%;
                filter: blur(70px);
                pointer-events: none;
                animation: blobFloat 10s ease-in-out infinite;
            }
            .blob-1 {
                width: 480px; height: 480px;
                background: rgba(226, 161, 111, 0.2);
                top: -100px; left: -150px;
                animation-delay: 0s;
            }
            .blob-2 {
                width: 380px; height: 380px;
                background: rgba(134, 176, 189, 0.18);
                bottom: -80px; right: -100px;
                animation-delay: 3s;
            }
            .blob-3 {
                width: 250px; height: 250px;
                background: rgba(226, 161, 111, 0.14);
                top: 40%; left: 60%;
                animation-delay: 6s;
            }

            @keyframes blobFloat {
                0%, 100% { transform: translate(0, 0) scale(1); }
                33%       { transform: translate(20px, -20px) scale(1.04); }
                66%       { transform: translate(-15px, 15px) scale(0.97); }
            }

            .hero-badge {
                display: inline-flex;
                align-items: center;
                gap: 0.4rem;
                padding: 0.4rem 1rem;
                background: rgba(226, 161, 111, 0.15);
                border: 1px solid rgba(226, 161, 111, 0.35);
                border-radius: 50px;
                font-size: 0.84rem;
                font-weight: 600;
                color: #c8834d;
                margin-bottom: 1.5rem;
                animation: fadeInDown 0.6s ease forwards;
            }

            .hero-badge-dot {
                width: 7px; height: 7px;
                background: #E2A16F;
                border-radius: 50%;
                animation: pulse 1.5s ease-in-out infinite;
            }

            @keyframes pulse {
                0%, 100% { opacity: 1; transform: scale(1); }
                50%       { opacity: 0.6; transform: scale(1.3); }
            }

            .hero-title {
                font-size: clamp(2.5rem, 5vw, 4rem);
                font-weight: 800;
                line-height: 1.15;
                color: #1f2937;
                margin-bottom: 1.25rem;
                max-width: 780px;
                animation: fadeInUp 0.7s 0.1s ease both;
            }

            .hero-title .highlight {
                background: linear-gradient(135deg, #E2A16F, #c8834d);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .hero-subtitle {
                font-size: clamp(1rem, 2vw, 1.2rem);
                color: #6b7280;
                max-width: 560px;
                line-height: 1.7;
                margin-bottom: 2.5rem;
                animation: fadeInUp 0.7s 0.2s ease both;
            }

            .hero-actions {
                display: flex;
                gap: 1rem;
                flex-wrap: wrap;
                justify-content: center;
                animation: fadeInUp 0.7s 0.3s ease both;
            }

            .btn-hero-primary {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.85rem 2rem;
                background: linear-gradient(135deg, #E2A16F, #c8834d);
                color: #ffffff;
                border-radius: 50px;
                font-size: 1rem;
                font-weight: 700;
                text-decoration: none;
                box-shadow: 0 8px 25px rgba(226, 161, 111, 0.45);
                transition: transform 0.2s, box-shadow 0.2s;
            }
            .btn-hero-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 12px 32px rgba(226, 161, 111, 0.55);
            }

            .btn-hero-secondary {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.85rem 2rem;
                background: #ffffff;
                color: #374151;
                border: 1.5px solid #D1D3D4;
                border-radius: 50px;
                font-size: 1rem;
                font-weight: 600;
                text-decoration: none;
                transition: border-color 0.2s, box-shadow 0.2s;
            }
            .btn-hero-secondary:hover {
                border-color: #E2A16F;
                box-shadow: 0 4px 16px rgba(226, 161, 111, 0.2);
            }

            /* ── STATS ── */
            .stats-bar {
                display: flex;
                justify-content: center;
                gap: 3rem;
                flex-wrap: wrap;
                margin-top: 4rem;
                animation: fadeInUp 0.7s 0.4s ease both;
            }

            .stat-item {
                text-align: center;
            }
            .stat-number {
                font-size: 2rem;
                font-weight: 800;
                color: #E2A16F;
                line-height: 1;
            }
            .stat-label {
                font-size: 0.82rem;
                color: #9ca3af;
                margin-top: 0.25rem;
                font-weight: 500;
            }

            /* ── FEATURES ── */
            .section {
                padding: 90px 5%;
            }

            .section-label {
                display: inline-block;
                font-size: 0.82rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.1em;
                color: #E2A16F;
                margin-bottom: 0.75rem;
            }

            .section-title {
                font-size: clamp(1.8rem, 3vw, 2.5rem);
                font-weight: 800;
                color: #1f2937;
                margin-bottom: 1rem;
            }

            .section-desc {
                font-size: 1rem;
                color: #6b7280;
                max-width: 520px;
                line-height: 1.7;
                margin-bottom: 3rem;
            }

            .features-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
                gap: 1.5rem;
            }

            .feature-card {
                background: #ffffff;
                border: 1px solid #D1D3D4;
                border-radius: 20px;
                padding: 2rem;
                transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
            }
            .feature-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 16px 40px rgba(226, 161, 111, 0.15);
                border-color: rgba(226, 161, 111, 0.4);
            }

            .feature-icon {
                width: 52px; height: 52px;
                border-radius: 14px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 1.25rem;
                font-size: 1.5rem;
            }

            .icon-orange { background: rgba(226, 161, 111, 0.15); }
            .icon-blue   { background: rgba(134, 176, 189, 0.15); }
            .icon-green  { background: rgba(134, 189, 152, 0.15); }

            .feature-title {
                font-size: 1.05rem;
                font-weight: 700;
                color: #1f2937;
                margin-bottom: 0.5rem;
            }

            .feature-desc {
                font-size: 0.9rem;
                color: #6b7280;
                line-height: 1.6;
            }

            /* ── HOW IT WORKS ── */
            .steps-section {
                background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
                padding: 90px 5%;
                text-align: center;
            }

            .steps-section .section-label { color: #E2A16F; }
            .steps-section .section-title { color: #ffffff; }
            .steps-section .section-desc  { color: rgba(255,255,255,0.6); margin: 0 auto 3rem; }

            .steps-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 2rem;
                max-width: 900px;
                margin: 0 auto;
            }

            .step-card {
                text-align: center;
                position: relative;
            }

            .step-number {
                width: 52px; height: 52px;
                border-radius: 50%;
                background: linear-gradient(135deg, #E2A16F, #c8834d);
                color: #ffffff;
                font-size: 1.25rem;
                font-weight: 800;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 1.25rem;
                box-shadow: 0 8px 20px rgba(226, 161, 111, 0.4);
            }

            .step-title {
                font-size: 1rem;
                font-weight: 700;
                color: #ffffff;
                margin-bottom: 0.5rem;
            }

            .step-desc {
                font-size: 0.88rem;
                color: rgba(255,255,255,0.55);
                line-height: 1.6;
            }

            /* ── CTA ── */
            .cta-section {
                padding: 90px 5%;
                text-align: center;
            }

            .cta-box {
                background: linear-gradient(135deg, #E2A16F 0%, #c8834d 100%);
                border-radius: 28px;
                padding: 60px 40px;
                max-width: 800px;
                margin: 0 auto;
                position: relative;
                overflow: hidden;
            }

            .cta-box::before {
                content: '';
                position: absolute;
                width: 350px; height: 350px;
                background: rgba(255,255,255,0.08);
                border-radius: 50%;
                top: -120px; right: -80px;
            }

            .cta-box::after {
                content: '';
                position: absolute;
                width: 220px; height: 220px;
                background: rgba(255,255,255,0.06);
                border-radius: 50%;
                bottom: -80px; left: -50px;
            }

            .cta-box h2 {
                font-size: clamp(1.8rem, 3vw, 2.5rem);
                font-weight: 800;
                color: #ffffff;
                margin-bottom: 1rem;
                position: relative; z-index: 1;
            }

            .cta-box p {
                color: rgba(255,255,255,0.85);
                font-size: 1.05rem;
                margin-bottom: 2rem;
                position: relative; z-index: 1;
            }

            .btn-cta {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.9rem 2.2rem;
                background: #ffffff;
                color: #c8834d;
                border-radius: 50px;
                font-size: 1rem;
                font-weight: 700;
                text-decoration: none;
                box-shadow: 0 8px 25px rgba(0,0,0,0.15);
                transition: transform 0.2s, box-shadow 0.2s;
                position: relative; z-index: 1;
            }
            .btn-cta:hover {
                transform: translateY(-2px);
                box-shadow: 0 12px 32px rgba(0,0,0,0.2);
            }

            /* ── FOOTER ── */
            .footer {
                background: #1f2937;
                padding: 2rem 5%;
                display: flex;
                align-items: center;
                justify-content: space-between;
                flex-wrap: wrap;
                gap: 1rem;
            }

            .footer-brand {
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .footer-brand img {
                width: 32px; height: 32px;
                border-radius: 8px;
                opacity: 0.9;
            }

            .footer-brand span {
                font-size: 1rem;
                font-weight: 700;
                color: #E2A16F;
            }

            .footer-copy {
                font-size: 0.82rem;
                color: rgba(255,255,255,0.4);
            }

            /* ── ANIMATIONS ── */
            @keyframes fadeInUp {
                from { opacity: 0; transform: translateY(24px); }
                to   { opacity: 1; transform: translateY(0); }
            }
            @keyframes fadeInDown {
                from { opacity: 0; transform: translateY(-16px); }
                to   { opacity: 1; transform: translateY(0); }
            }

            /* ── DIVIDER ── */
            .section-divider {
                height: 1px;
                background: linear-gradient(to right, transparent, #D1D3D4, transparent);
                max-width: 1200px;
                margin: 0 auto;
            }

            /* ── RESPONSIVE ── */
            @media (max-width: 640px) {
                .stats-bar { gap: 2rem; }
                .cta-box { padding: 40px 24px; }
                .footer { flex-direction: column; text-align: center; }
            }
        </style>
    </head>
    <body>

        <!-- ══ NAVBAR ══ -->
        <nav class="navbar">
            <a href="/" class="navbar-brand">
                <img src="{{ asset('logo.png') }}" alt="EasyColoc logo">
                <span>EasyColoc</span>
            </a>

            @if (Route::has('login'))
                <livewire:welcome.navigation />
            @endif
        </nav>

        <!-- ══ HERO ══ -->
        <section class="hero">
            <!-- Blobs -->
            <div class="blob blob-1"></div>
            <div class="blob blob-2"></div>
            <div class="blob blob-3"></div>

            <!-- Badge -->
            <div class="hero-badge">
                <span class="hero-badge-dot"></span>
                La colocation simplifiée
            </div>

            <!-- Title -->
            <h1 class="hero-title">
                Trouvez votre
                <span class="highlight">colocation idéale</span>
                en quelques clics
            </h1>

            <!-- Subtitle -->
            <p class="hero-subtitle">
                EasyColoc met en relation colocataires et propriétaires partout au Maroc. Des annonces vérifiées, un processus transparent et une communauté de confiance.
            </p>

            <!-- CTA Buttons -->
            <div class="hero-actions">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-hero-primary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                        Mon Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn-hero-primary">
                        Commencer gratuitement
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                    <a href="{{ route('login') }}" class="btn-hero-secondary">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M15 12H3"/></svg>
                        Se connecter
                    </a>
                @endauth
            </div>

             </section>

        <div class="section-divider"></div>

        <!-- ══ CTA ══ -->
        <section class="cta-section">
            <div class="cta-box">
                <h2>Prêt à trouver votre colocation ?</h2>
                <p>Rejoignez des milliers d'étudiants et jeunes actifs qui ont trouvé leur logement sur EasyColoc.</p>
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-cta">
                        Accéder à mon espace
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn-cta">
                        Créer mon compte gratuit
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                @endauth
            </div>
        </section>

        <!-- ══ FOOTER ══ -->
        <footer class="footer">
            <div class="footer-brand">
                <img src="{{ asset('logo.png') }}" alt="EasyColoc">
                <span>EasyColoc</span>
            </div>
            <p class="footer-copy">© {{ date('Y') }} EasyColoc. Tous droits réservés.</p>
        </footer>

    </body>
</html>
