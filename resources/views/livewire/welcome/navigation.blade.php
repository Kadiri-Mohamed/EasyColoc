<nav style="
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-left: auto;
">
    @auth
        <a
            href="{{ url('/dashboard') }}"
            style="
                display: inline-flex;
                align-items: center;
                gap: 0.4rem;
                padding: 0.5rem 1.2rem;
                background: linear-gradient(135deg, #E2A16F, #c8834d);
                color: #ffffff;
                border-radius: 50px;
                font-size: 0.9rem;
                font-weight: 600;
                text-decoration: none;
                box-shadow: 0 4px 14px rgba(226, 161, 111, 0.4);
                transition: transform 0.15s, box-shadow 0.15s;
            "
            onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 6px 20px rgba(226,161,111,0.5)';"
            onmouseout="this.style.transform='';this.style.boxShadow='0 4px 14px rgba(226,161,111,0.4)';"
        >
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
            </svg>
            Dashboard
        </a>
    @else
        <a
            href="{{ route('login') }}"
            style="
                padding: 0.5rem 1.1rem;
                color: #E2A16F;
                border: 1.5px solid #E2A16F;
                border-radius: 50px;
                font-size: 0.9rem;
                font-weight: 600;
                text-decoration: none;
                transition: background 0.2s, color 0.2s;
            "
            onmouseover="this.style.background='#E2A16F';this.style.color='#fff';"
            onmouseout="this.style.background='';this.style.color='#E2A16F';"
        >
            Connexion
        </a>

        @if (Route::has('register'))
            <a
                href="{{ route('register') }}"
                style="
                    padding: 0.5rem 1.2rem;
                    background: linear-gradient(135deg, #E2A16F, #c8834d);
                    color: #ffffff;
                    border-radius: 50px;
                    font-size: 0.9rem;
                    font-weight: 600;
                    text-decoration: none;
                    box-shadow: 0 4px 14px rgba(226, 161, 111, 0.4);
                    transition: transform 0.15s, box-shadow 0.15s;
                "
                onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 6px 20px rgba(226,161,111,0.5)';"
                onmouseout="this.style.transform='';this.style.boxShadow='0 4px 14px rgba(226,161,111,0.4)';"
            >
                S'inscrire
            </a>
        @endif
    @endauth
</nav>
