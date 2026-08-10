<style>
    :root {
        /* ── PlayStation Blue accent scale (primary CTA) ── */
        --accent-50:#f2f8fe; --accent-100:#e3f0fc; --accent-200:#bbdcf7; --accent-300:#85c2ef;
        --accent-400:#3f9bdf; --accent-500:#0068bd; --accent-600:#0070cc; --accent-700:#005aa6;
        --accent-800:#004a8c; --accent-900:#003c70; --accent-950:#00234a;

        /* ── Gold & amber accents (secondary actions, highlights) ── */
        --gold-300:#efdda3; --gold-400:#e7cd78; --gold-500:#dfbd4d; --gold-600:#c9a63c; --gold-700:#a9882e;
        --amber-400:#f6bd23; --amber-500:#f6bd23; --amber-600:#e0a81c;
        --warning-yellow:#feeb37; --error-red:#d63d00; --hyperlink:#0000ee;

        /* ── Neutral scale ── */
        --charcoal:#1f1f1f; --jet:#000000; --dark-gray:#363636; --medium-gray:#cccccc;
        --soft-gray:#d1d3df; --off-black:#050606;

        /* ── Elevation scale ── */
        --shadow-raised: rgba(0,0,0,.06) 0 4px 8px 0;
        --shadow-elevated: rgba(0,0,0,.12) 0 8px 16px 0;
        --shadow-floating: 0 12px 24px rgba(0,0,0,.15);
        --shadow-modal: 0 16px 40px rgba(0,0,0,.25);
    }

    /* ── Typography: light premium headings, weight-500 interactive ── */
    h1, h2, h3, h4 { font-weight: 300 !important; letter-spacing: 0; }
    body { font-weight: 400; }
    .btn-primary, .btn-ghost, .btn-secondary, .btn-login, .btn-register { font-weight: 500; }

    /* ── Heading scale (PS design: 39→25→20). Fallback defaults only —
       explicit Tailwind size utilities still win via specificity.
       `body h1` beats Tailwind Preflight `h1 { font-size: inherit }`
       while losing to `.text-2xl`-style utilities. ── */
    body h1 { font-size: 39px; line-height: 1.25; }
    body h2 { font-size: 39px; line-height: 1.25; }
    body h3 { font-size: 25px; line-height: 1.25; }
    body h4 { font-size: 20px; line-height: 1.25; }
    @media (min-width: 480px) and (max-width: 1023px) {
        body h1, body h2 { font-size: 28px; }
        body h3 { font-size: 24px; }
        body h4 { font-size: 20px; }
    }
    @media (max-width: 479px) {
        body h1, body h2 { font-size: 24px; }
        body h3 { font-size: 21px; }
        body h4 { font-size: 18px; }
    }

    /* ── Primary Button: PS Blue pill ── */
    .btn-primary {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: var(--accent-500, #0068bd);
        color: #ffffff;
        font-size: 13.3333px;
        padding: 16px 20px;
        line-height: 21px;
        border-radius: 999px;
        border: 2px solid transparent;
        box-shadow: var(--shadow-raised, rgba(0,0,0,.06) 0 4px 8px 0);
        cursor: pointer;
        transition: all .3s ease;
        overflow: hidden;
    }
    .btn-primary:hover { background: var(--accent-600, #0070cc); transform: translateY(-1px); }
    .btn-primary:active { background: var(--accent-700, #005aa6); transform: scale(.98); }
    .btn-primary:disabled, .btn-primary[disabled] {
        background: #cccccc; color: #363636; opacity: .5; cursor: not-allowed; box-shadow: none;
    }

    /* ── Secondary Button: outlined pill ── */
    .btn-ghost {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        background: #ffffff;
        color: var(--accent-500, #0068bd);
        font-size: 13.3333px;
        padding: 16px 20px;
        line-height: 21px;
        border-radius: 999px;
        border: 2px solid var(--accent-500, #0068bd);
        box-shadow: none;
        cursor: pointer;
        transition: all .3s ease;
    }
    .btn-ghost:hover { background: #f0f6ff; border-color: var(--accent-600, #0070cc); transform: translateY(-1px); }
    .btn-ghost:active { background: #e0efff; border-color: var(--accent-700, #005aa6); transform: scale(.98); }

    .dark .btn-ghost { background: transparent; color: #e2e8f0; border-color: rgba(255,255,255,.3); }
    .dark .btn-ghost:hover { background: rgba(255,255,255,.08); border-color: rgba(255,255,255,.5); }

    /* ── Login/Register submit: PS Blue pill (override emerald gradient) ── */
    .btn-login, .btn-register {
        background: var(--accent-500, #0068bd);
        color: #ffffff;
        border: 2px solid transparent;
        border-radius: 999px;
        box-shadow: var(--shadow-raised, rgba(0,0,0,.06) 0 4px 8px 0);
        font-size: 14px;
        padding: 14px 24px;
        line-height: 21px;
    }
    .btn-login:hover, .btn-register:hover {
        background: var(--accent-600, #0070cc);
        box-shadow: 0 12px 32px rgba(0,104,189,.35);
        transform: translateY(-1px);
    }
    .btn-login:active, .btn-register:active { background: var(--accent-700, #005aa6); transform: scale(.98); }

    /* ── Kill leftover gradient shimmer pseudo-elements from old styles ── */
    .btn-primary::after, .btn-login::after, .btn-register::after { content: none; }
    .btn-login .btn-ripple, .btn-register .btn-ripple { display: none; }

    /* ── Form inputs: Arial 13.3333px, 4px radius, 1px #CCC border, PS Blue focus ── */
    input[type="text"], input[type="email"], input[type="password"], input[type="number"],
    input[type="tel"], input[type="url"], input[type="search"], input[type="date"],
    input[type="time"], input[type="datetime-local"], input[type="month"], select, textarea {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 13.3333px;
        font-weight: 400;
        color: #1f1f1f;
        border-radius: 4px !important;
        border: 1px solid #cccccc;
        padding: 12px 16px;
        line-height: normal;
        background-color: #ffffff;
        min-height: 44px;
    }
    /* Select: PS Blue dropdown icon (replaces native gray arrow) */
    select:not([multiple]) {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='8' viewBox='0 0 14 8'%3E%3Cpath d='M1 1l6 6 6-6' fill='none' stroke='%230068bd' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 14px 8px;
        padding-right: 36px;
        cursor: pointer;
    }
    input[type="text"]::placeholder, input[type="email"]::placeholder,
    input[type="password"]::placeholder, input[type="number"]::placeholder,
    input[type="tel"]::placeholder, input[type="url"]::placeholder,
    input[type="search"]::placeholder, input[type="date"]::placeholder,
    input[type="time"]::placeholder, input[type="datetime-local"]::placeholder,
    input[type="month"]::placeholder, textarea::placeholder {
        color: #363636;
        opacity: .6;
    }
    input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus,
    input[type="number"]:focus, input[type="tel"]:focus, input[type="url"]:focus,
    input[type="search"]:focus, input[type="date"]:focus, input[type="time"]:focus,
    input[type="datetime-local"]:focus, input[type="month"]:focus, select:focus, textarea:focus {
        outline: none;
        border-color: #0068bd !important;
        border-width: 2px;
        box-shadow: 0 0 0 3px rgba(0,104,189,.1);
    }
    /* Error state: PS Error Red border 2px + red ring (overrides Tailwind border-red-*) */
    input.border-red-300, input.border-red-400, input.border-red-500, input[aria-invalid="true"],
    select.border-red-300, select.border-red-400, select.border-red-500, select[aria-invalid="true"],
    textarea.border-red-300, textarea.border-red-400, textarea.border-red-500, textarea[aria-invalid="true"] {
        border-color: #d63d00 !important;
        border-width: 2px !important;
        box-shadow: 0 0 0 3px rgba(214,61,0,.1);
    }
    input.border-red-300:focus, input.border-red-400:focus, input.border-red-500:focus, input[aria-invalid="true"]:focus,
    select.border-red-300:focus, select.border-red-400:focus, select.border-red-500:focus, select[aria-invalid="true"]:focus,
    textarea.border-red-300:focus, textarea.border-red-400:focus, textarea.border-red-500:focus, textarea[aria-invalid="true"]:focus {
        border-color: #d63d00 !important;
        box-shadow: 0 0 0 3px rgba(214,61,0,.1);
    }
    input[type="text"]:disabled, input[type="email"]:disabled, input[type="password"]:disabled,
    input[type="number"]:disabled, input[type="tel"]:disabled, input[type="url"]:disabled,
    input[type="search"]:disabled, input[type="date"]:disabled, input[type="time"]:disabled,
    input[type="datetime-local"]:disabled, input[type="month"]:disabled,
    select:disabled, textarea:disabled {
        background-color: #f5f5f5;
        color: #cccccc;
        opacity: .5;
    }
    /* Checkbox: 18px, 2px #CCC border, 3px radius, checked PS Blue */
    input[type="checkbox"] {
        width: 18px;
        height: 18px;
        border-radius: 3px;
        border: 2px solid #cccccc;
        background-color: #ffffff;
        -webkit-appearance: none;
        appearance: none;
        cursor: pointer;
        position: relative;
        transition: all .15s ease;
        flex-shrink: 0;
    }
    input[type="checkbox"]:checked {
        background-color: #0068bd;
        border-color: #0068bd;
    }
    input[type="checkbox"]:checked::after {
        content: "";
        position: absolute;
        left: 4px;
        top: 1px;
        width: 5px;
        height: 9px;
        border: solid #ffffff;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }
    input[type="checkbox"]:focus {
        outline: 2px solid rgba(0,104,189,.3);
        outline-offset: 1px;
    }
    input[type="radio"] { accent-color: #0068bd; }

    /* ── Touch targets: primary CTAs min 48px tall, inputs 44px (48px on mobile) ── */
    .btn-primary, .btn-ghost, .btn-login, .btn-register { min-height: 48px; }
    @media (max-width: 1024px) {
        input[type="text"], input[type="email"], input[type="password"], input[type="number"],
        input[type="tel"], input[type="url"], input[type="search"], input[type="date"],
        input[type="time"], input[type="datetime-local"], input[type="month"], select, textarea {
            min-height: 48px;
        }
    }

    /* ── Elevation: subtle PS shadows replace heavy emerald-tinted defaults ──
       Raised (1)   rgba(0,0,0,.06) 0 4px 8px      → shadow-sm / shadow
       Elevated (2) rgba(0,0,0,.12) 0 8px 16px     → shadow-md / shadow-lg
       Floating (3) 0 12px 24px rgba(0,0,0,.15)    → shadow-xl
       Modal (4)    0 16px 40px rgba(0,0,0,.25)    → shadow-2xl */
    .shadow-sm, .shadow { box-shadow: rgba(0,0,0,.06) 0 4px 8px 0 !important; }
    .shadow-md, .shadow-lg { box-shadow: rgba(0,0,0,.12) 0 8px 16px 0 !important; }
    .shadow-xl { box-shadow: 0 12px 24px rgba(0,0,0,.15) !important; }
    .shadow-2xl { box-shadow: 0 16px 40px rgba(0,0,0,.25) !important; }
    .shadow-none { box-shadow: none !important; }
    /* Neutralize emerald tint from shadow-color utilities (shadow-brand-*/500 etc.) */
    [class*="shadow-brand-"], [class*="shadow-teal-"], [class*="shadow-emerald-"],
    [class*="shadow-cyan-"], [class*="shadow-green-"], [class*="shadow-amber-"] {
        --tw-shadow-color: rgba(0,0,0,.08);
    }
</style>
<script>
    // Extend whatever tailwind.config each page sets with the PS accent palette.
    // Must run after the page's own `tailwind.config = {...}` assignment.
    (function () {
        var accent = {
            50:'#f2f8fe', 100:'#e3f0fc', 200:'#bbdcf7', 300:'#85c2ef', 400:'#3f9bdf',
            500:'#0068bd', 600:'#0070cc', 700:'#005aa6', 800:'#004a8c', 900:'#003c70', 950:'#00234a',
        };
        var gold = { 300:'#efdda3', 400:'#e7cd78', 500:'#dfbd4d', 600:'#c9a63c', 700:'#a9882e' };
        var amber = { 400:'#f6bd23', 500:'#f6bd23', 600:'#e0a81c' };
        var cfg = window.tailwind && tailwind.config ? tailwind.config : null;
        if (cfg) {
            var colors = cfg.theme && cfg.theme.extend && cfg.theme.extend.colors
                ? cfg.theme.extend.colors
                : (cfg.theme && cfg.theme.extend ? (cfg.theme.extend.colors = {}) : null);
            if (colors) {
                if (!colors.accent) colors.accent = accent;
                if (!colors.gold) colors.gold = gold;
                if (!colors.amber) colors.amber = amber;
            }
        }
    })();
</script>
