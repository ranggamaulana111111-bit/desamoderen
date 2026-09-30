<x-admin-layout title="Pengaturan Desa" maxWidth="max-w-[1440px]">
    @push('styles')
    <style>
        /* ══════════════════════════════════════════════════════════
           PENGATARAN — Premium Design System
           Every card / nav item carries data-acc="<tailwind-color>"
           which resolves to --acc, --acc-rgb, --acc-tint, --acc-ink.
           ══════════════════════════════════════════════════════════ */
        [data-acc="emerald"] { --acc:#10b981; --acc-rgb:16,185,129; --acc-tint:#ecfdf5; --acc-ink:#047857; }
        [data-acc="teal"]    { --acc:#14b8a6; --acc-rgb:20,184,166; --acc-tint:#f0fdfa; --acc-ink:#0f766e; }
        [data-acc="cyan"]    { --acc:#06b6d4; --acc-rgb:6,182,212;  --acc-tint:#ecfeff; --acc-ink:#0e7490; }
        [data-acc="sky"]     { --acc:#0ea5e9; --acc-rgb:14,165,233; --acc-tint:#f0f9ff; --acc-ink:#0369a1; }
        [data-acc="blue"]    { --acc:#3b82f6; --acc-rgb:59,130,246; --acc-tint:#eff6ff; --acc-ink:#1d4ed8; }
        [data-acc="indigo"]  { --acc:#6366f1; --acc-rgb:99,102,241; --acc-tint:#eef2ff; --acc-ink:#4338ca; }
        [data-acc="violet"]  { --acc:#8b5cf6; --acc-rgb:139,92,246; --acc-tint:#f5f3ff; --acc-ink:#6d28d9; }
        [data-acc="purple"]  { --acc:#a855f7; --acc-rgb:168,85,247; --acc-tint:#faf5ff; --acc-ink:#7e22ce; }
        [data-acc="fuchsia"] { --acc:#d946ef; --acc-rgb:217,70,239; --acc-tint:#fdf4ff; --acc-ink:#a21caf; }
        [data-acc="pink"]    { --acc:#ec4899; --acc-rgb:236,72,153; --acc-tint:#fdf2f8; --acc-ink:#be185d; }
        [data-acc="rose"]    { --acc:#f43f5e; --acc-rgb:244,63,94;  --acc-tint:#fff1f2; --acc-ink:#be123c; }
        [data-acc="red"]     { --acc:#ef4444; --acc-rgb:239,68,68;  --acc-tint:#fef2f2; --acc-ink:#b91c1c; }
        [data-acc="orange"]  { --acc:#f97316; --acc-rgb:249,115,22; --acc-tint:#fff7ed; --acc-ink:#c2410c; }
        [data-acc="amber"]   { --acc:#f59e0b; --acc-rgb:245,158,11; --acc-tint:#fffbeb; --acc-ink:#b45309; }
        [data-acc="lime"]    { --acc:#84cc16; --acc-rgb:132,204,22; --acc-tint:#f7fee7; --acc-ink:#4d7c0f; }
        [data-acc="green"]   { --acc:#22c55e; --acc-rgb:34,197,94;  --acc-tint:#f0fdf4; --acc-ink:#15803d; }
        [data-acc="slate"]   { --acc:#64748b; --acc-rgb:100,116,139;--acc-tint:#f8fafc; --acc-ink:#475569; }
        [data-acc="gray"]    { --acc:#6b7280; --acc-rgb:107,114,128;--acc-tint:#f9fafb; --acc-ink:#4b5563; }
        [data-acc="stone"]   { --acc:#78716c; --acc-rgb:120,113,108;--acc-tint:#fafaf9; --acc-ink:#57534e; }

        .set-root { --acc:#10b981; --acc-rgb:16,185,129; --acc-tint:#ecfdf5; --acc-ink:#047857; }

        /* ─────────── HERO: Desa Digital Command Center ─────────── */
        .hero {
            background: var(--gradient-hero);
            border: 1px solid rgba(255,255,255,.07);
            box-shadow: 0 32px 72px -30px rgba(2,38,34,.8), inset 0 1px 0 rgba(255,255,255,.09);
        }
        .hero-grid {
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,.045) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.045) 1px, transparent 1px);
            background-size: 46px 46px;
            -webkit-mask-image: radial-gradient(ellipse 78% 72% at 22% 8%, #000 18%, transparent 76%);
            mask-image: radial-gradient(ellipse 78% 72% at 22% 8%, #000 18%, transparent 76%);
        }
        .hero-orb { position: absolute; border-radius: 50%; filter: blur(62px); pointer-events: none; }
        .hero-orb-a { width: 400px; height: 400px; top: -180px; right: -70px; background: radial-gradient(circle, rgba(16,185,129,.45), transparent 68%); }
        .hero-orb-b { width: 320px; height: 320px; bottom: -170px; left: 30%; background: radial-gradient(circle, rgba(6,182,212,.34), transparent 68%); }
        .hero-orb-c { width: 240px; height: 240px; top: 38%; left: -80px; background: radial-gradient(circle, rgba(168,85,247,.26), transparent 68%); }

        .hero-badge {
            display: inline-flex; align-items: center; gap: .4rem;
            padding: 5px 12px; border-radius: 9999px;
            font-size: 10.5px; font-weight: 700; letter-spacing: .1em; text-transform: uppercase;
            color: #a7f3d0; background: rgba(16,185,129,.14);
            border: 1px solid rgba(52,211,153,.28); backdrop-filter: blur(8px);
        }
        .hero-badge-live { color: #bae6fd; background: rgba(6,182,212,.14); border-color: rgba(34,211,238,.28); }
        .hero-eyebrow {
            display: block; margin-bottom: .5rem;
            font-size: 10.5px; font-weight: 700; letter-spacing: .16em; text-transform: uppercase;
            color: rgba(255,255,255,.52);
        }
        .hero-title {
            font-size: clamp(25px, 4.2vw, 40px) !important;
            font-weight: 800 !important; line-height: 1.06; letter-spacing: -.028em;
            color: #fff; text-shadow: 0 2px 26px rgba(0,0,0,.4);
        }
        .hero-sub {
            display: flex; flex-wrap: wrap; align-items: center; gap: .5rem;
            margin-top: .55rem; font-size: 13px; font-weight: 500; color: rgba(255,255,255,.6);
        }
        .hero-motto {
            display: inline-flex; align-items: center; gap: .5rem; margin-top: 1.1rem;
            padding: 8px 14px; border-radius: 13px;
            font-size: 12.5px; font-style: italic; font-weight: 500; color: #fcd34d;
            background: rgba(245,158,11,.1); border: 1px solid rgba(251,191,36,.22);
        }
        .hero-chip {
            display: inline-flex; align-items: center; gap: .45rem;
            padding: 6px 12px; border-radius: 9999px;
            font-size: 11.5px; font-weight: 600; color: rgba(255,255,255,.78);
            background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.1);
        }
        .hero-chip-dot { width: 6px; height: 6px; border-radius: 9999px; box-shadow: 0 0 8px currentColor; }

        .hero-stat {
            position: relative; overflow: hidden;
            padding: 14px; border-radius: 18px;
            background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.1);
            backdrop-filter: blur(14px);
            transition: transform .45s var(--ease-out-expo), background .45s, border-color .45s;
        }
        .hero-stat::after {
            content: ''; position: absolute; inset: auto -30% -60% auto;
            width: 130px; height: 130px; border-radius: 50%;
            background: radial-gradient(circle, rgba(var(--acc-rgb),.3), transparent 70%);
            opacity: .5; transition: opacity .5s;
        }
        .hero-stat:hover { transform: translateY(-4px); background: rgba(255,255,255,.11); border-color: rgba(var(--acc-rgb),.5); }
        .hero-stat:hover::after { opacity: 1; }
        .hero-stat-icon {
            width: 32px; height: 32px; border-radius: 11px; margin-bottom: 10px;
            display: flex; align-items: center; justify-content: center; color: #fff;
            background: linear-gradient(140deg, var(--acc), rgba(var(--acc-rgb),.6));
            box-shadow: 0 6px 16px rgba(var(--acc-rgb),.4);
        }
        .hero-stat-value {
            font-size: 22px; font-weight: 800; letter-spacing: -.025em;
            color: #fff; font-variant-numeric: tabular-nums;
        }
        .hero-stat-label { margin-top: 3px; font-size: 10.5px; font-weight: 600; color: rgba(255,255,255,.5); }

        .hero-status {
            display: flex; flex-wrap: wrap; align-items: center; gap: 14px;
            padding: 13px 18px; border-radius: 18px;
            background: rgba(255,255,255,.05); border: 1px solid rgba(255,255,255,.08);
            backdrop-filter: blur(14px);
        }
        .hero-status-item { display: flex; align-items: center; gap: 9px; }
        .hero-status-label { font-size: 9.5px; font-weight: 700; letter-spacing: .09em; text-transform: uppercase; color: rgba(255,255,255,.4); }
        .hero-status-value { margin-top: 1px; font-size: 12px; font-weight: 600; color: rgba(255,255,255,.9); }
        .hero-status-sep { width: 1px; height: 26px; background: rgba(255,255,255,.1); }

        /* ─────────── SIDEBAR NAVIGATION ─────────── */
        .setnav {
            position: relative; display: flex; flex-direction: column;
            border-radius: 24px; background: #fff; border: 1px solid rgba(226,232,240,.9);
            box-shadow: 0 1px 2px rgba(15,23,42,.04), 0 18px 44px -22px rgba(15,23,42,.24);
            overflow: hidden; max-height: calc(100vh - 7rem);
        }
        .setnav-top {
            padding: 16px 16px 13px;
            background: linear-gradient(165deg, #fff, #f0fdf9);
            border-bottom: 1px solid rgba(226,232,240,.75);
        }
        .setnav-kicker { font-size: 9.5px; font-weight: 800; letter-spacing: .13em; text-transform: uppercase; color: #94a3b8; }
        .setnav-search { position: relative; margin-top: 10px; }
        .setnav-search > svg { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); width: 15px; height: 15px; color: #94a3b8; pointer-events: none; }
        .setnav-search input[type="text"] {
            width: 100%; height: 38px; min-height: 38px;
            padding: 0 32px 0 33px; border-radius: 12px;
            font-size: 12.5px; font-weight: 500;
            background: #f8fafc; border: 1px solid rgba(226,232,240,.95); color: #334155;
            transition: all .3s ease;
        }
        .setnav-search input[type="text"]:focus {
            background: #fff; border-color: #10b981; border-width: 1px;
            box-shadow: 0 0 0 3px rgba(16,185,129,.12);
        }
        .setnav-clear {
            position: absolute; right: 8px; top: 50%; transform: translateY(-50%);
            width: 20px; height: 20px; border-radius: 9999px;
            display: flex; align-items: center; justify-content: center;
            color: #94a3b8; background: #e2e8f0; transition: all .2s ease;
        }
        .setnav-clear:hover { background: #cbd5e1; color: #475569; }

        .setnav-scroll { flex: 1; overflow-y: auto; padding: 10px 10px 14px; }
        .setnav-section + .setnav-section { margin-top: 14px; }

        /* Section rule drops to its own line instead of squeezing the caption. */
        .setnav-section-title {
            display: flex; align-items: center; flex-wrap: wrap; gap: 6px 8px;
            padding: 5px 8px 7px; line-height: 1.45;
            font-size: 9px; font-weight: 800; letter-spacing: .09em; text-transform: uppercase;
            color: #a8b3c4; overflow-wrap: anywhere;
        }
        .setnav-section-title::after {
            content: ''; flex: 1 0 28px; height: 1px;
            background: linear-gradient(90deg, rgba(148,163,184,.32), transparent);
        }

        .setnav-item {
            position: relative; width: 100%;
            display: flex; align-items: center; gap: 10px;
            padding: 8px 22px 8px 13px; border-radius: 14px;
            text-align: left; border: 1px solid transparent;
            font-size: 13px; font-weight: 600; color: #64748b;
            transition: all .38s var(--ease-out-expo);
        }
        .setnav-item::before {
            content: ''; position: absolute; left: 2px; top: 50%;
            transform: translateY(-50%) scaleY(0); transform-origin: center;
            width: 3px; height: 20px; border-radius: 9999px;
            background: linear-gradient(to bottom, var(--acc), var(--acc-ink));
            transition: transform .38s var(--ease-out-expo);
        }
        .setnav-item:hover { background: var(--acc-tint); color: var(--acc-ink); }
        .setnav-item.is-active {
            background: linear-gradient(100deg, rgba(var(--acc-rgb),.17), rgba(var(--acc-rgb),.04));
            color: var(--acc-ink); border-color: rgba(var(--acc-rgb),.22);
            box-shadow: 0 8px 20px -10px rgba(var(--acc-rgb),.65);
        }
        .setnav-item.is-active::before { transform: translateY(-50%) scaleY(1); }

        .setnav-icon {
            width: 32px; height: 32px; border-radius: 11px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            color: var(--acc-ink); background: rgba(var(--acc-rgb),.13);
            border: 1px solid rgba(var(--acc-rgb),.18);
            transition: all .38s var(--ease-out-expo);
        }
        .setnav-icon svg { width: 17px; height: 17px; }
        .setnav-item:hover .setnav-icon,
        .setnav-item.is-active .setnav-icon {
            background: linear-gradient(140deg, var(--acc), var(--acc-ink));
            color: #fff; border-color: transparent;
            box-shadow: 0 6px 14px rgba(var(--acc-rgb),.42);
        }
        .setnav-label { flex: 1; min-width: 0; line-height: 1.35; overflow-wrap: anywhere; }
        .setnav-count {
            flex-shrink: 0;
            padding: 2px 7px; border-radius: 9999px;
            font-size: 10px; font-weight: 700;
            background: rgba(148,163,184,.16); color: #64748b;
        }
        .setnav-item.is-active .setnav-count { background: rgba(var(--acc-rgb),.22); color: var(--acc-ink); }
        /* Chevrons are absolutely placed so inactive rows keep full label width. */
        .setnav-chevron {
            position: absolute; right: 8px; top: 50%;
            width: 13px; height: 13px; flex-shrink: 0; color: var(--acc);
            opacity: 0; transform: translate(-5px, -50%);
            transition: all .38s var(--ease-out-expo);
        }
        .setnav-item.is-active .setnav-chevron { opacity: 1; transform: translate(0, -50%); }

        .setnav-empty { padding: 26px 12px; text-align: center; }
        .setnav-empty svg { width: 34px; height: 34px; color: #cbd5e1; margin: 0 auto 8px; }
        .setnav-empty p { font-size: 12px; font-weight: 600; color: #94a3b8; }

        .setnav-foot {
            display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 4px 10px;
            padding: 10px 16px; font-size: 10.5px; font-weight: 600; color: #94a3b8;
            background: #fbfcfd; border-top: 1px solid rgba(226,232,240,.75);
        }
        .setnav-foot b { color: var(--acc-ink); font-weight: 800; }

        /* ─────────── MOBILE PILL TABS ─────────── */
        .setpill {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 8px 14px; border-radius: 9999px; white-space: nowrap;
            font-size: 12.5px; font-weight: 600; color: #64748b;
            background: #fff; border: 1px solid rgba(226,232,240,.95);
            box-shadow: 0 1px 2px rgba(15,23,42,.05);
            transition: all .32s var(--ease-out-expo);
        }
        .setpill svg { width: 15px; height: 15px; color: #94a3b8; transition: color .3s; }
        .setpill:hover { border-color: rgba(var(--acc-rgb),.35); color: var(--acc-ink); }
        .setpill.is-active {
            background: linear-gradient(100deg, var(--acc), var(--acc-ink));
            color: #fff; border-color: transparent;
            box-shadow: 0 10px 22px -8px rgba(var(--acc-rgb),.6);
        }
        .setpill.is-active svg { color: #fff; }

        /* ─────────── CARDS ─────────── */
        .setting-card {
            position: relative; overflow: hidden; background: #fff;
            border-radius: 24px; border: 1px solid rgba(226,232,240,.9);
            box-shadow: 0 1px 2px rgba(15,23,42,.04), 0 16px 36px -20px rgba(15,23,42,.24);
            transition: transform .5s var(--ease-out-expo), box-shadow .5s var(--ease-out-expo), border-color .5s ease;
        }
        .setting-card::before {
            content: ''; position: absolute; inset: 0 0 auto 0; height: 2px; z-index: 3;
            background: linear-gradient(90deg, var(--acc), rgba(var(--acc-rgb),0) 78%);
            opacity: .55; transition: opacity .5s ease;
        }
        .setting-card:hover {
            transform: translateY(-3px);
            border-color: rgba(var(--acc-rgb),.3);
            box-shadow: 0 2px 4px rgba(15,23,42,.04), 0 34px 66px -26px rgba(var(--acc-rgb),.42);
        }
        .setting-card:hover::before { opacity: 1; }

        .setting-head {
            position: relative; overflow: hidden;
            display: flex; align-items: center; gap: 14px;
            padding: 18px 22px;
            background: linear-gradient(135deg, var(--acc-tint) 0%, rgba(255,255,255,.92) 58%, #fff 100%);
            border-bottom: 1px solid rgba(var(--acc-rgb),.15);
        }
        .setting-head::after {
            content: ''; position: absolute; top: -64px; right: -44px;
            width: 190px; height: 190px; border-radius: 50%;
            background: radial-gradient(circle, rgba(var(--acc-rgb),.17), transparent 68%);
            pointer-events: none;
        }
        .setting-head > * { position: relative; z-index: 1; }
        .setting-head h2 { font-size: 15.5px !important; font-weight: 700 !important; letter-spacing: -.015em; color: #0f172a; }
        .setting-head p { font-size: 12.5px !important; font-weight: 500 !important; color: #64748b; }

        .setting-head-icon {
            position: relative; z-index: 1;
            width: 44px; height: 44px; border-radius: 14px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            color: var(--acc-ink);
            background: linear-gradient(140deg, rgba(var(--acc-rgb),.22), rgba(var(--acc-rgb),.07));
            border: 1px solid rgba(var(--acc-rgb),.24);
            box-shadow: inset 0 1px 0 rgba(255,255,255,.85), 0 6px 16px rgba(var(--acc-rgb),.18);
        }
        .setting-head-icon svg { width: 21px; height: 21px; }
        .setting-head-sm { padding: 13px 16px; gap: 11px; }
        .setting-head-sm .setting-head-icon { width: 36px; height: 36px; border-radius: 11px; }
        .setting-head-sm .setting-head-icon svg { width: 18px; height: 18px; }

        .setting-subhead {
            padding: 11px 22px;
            background: linear-gradient(90deg, rgba(245,158,11,.09), transparent);
            border-bottom: 1px solid rgba(var(--acc-rgb),.12);
        }

        .setting-foot {
            display: flex; align-items: center; justify-content: flex-end; gap: 12px;
            padding: 14px 22px;
            background: linear-gradient(180deg, #fff, var(--acc-tint));
            border-top: 1px solid rgba(var(--acc-rgb),.15);
        }

        /* ─────────── SAVE BUTTON ─────────── */
        .btn-save {
            display: inline-flex; align-items: center; gap: .5rem;
            padding: 11px 22px; border: 0; border-radius: 14px;
            font-size: 13px; font-weight: 600; color: #fff; cursor: pointer;
            background: linear-gradient(135deg, var(--acc), var(--acc-ink));
            box-shadow: 0 10px 24px -8px rgba(var(--acc-rgb),.65);
            transition: all .35s var(--ease-out-expo);
        }
        .btn-save:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 16px 32px -10px rgba(var(--acc-rgb),.8); }
        .btn-save:active:not(:disabled) { transform: scale(.97); }
        .btn-save:disabled { opacity: .55; cursor: not-allowed; }
        .btn-save svg { width: 16px; height: 16px; }

        /* ─────────── TOGGLE CARDS ─────────── */
        .setting-toggle {
            display: flex; align-items: flex-start; gap: 12px;
            padding: 13px 14px; border-radius: 16px; cursor: pointer;
            background: #fff; border: 1px solid rgba(226,232,240,.9);
            transition: all .35s var(--ease-out-expo);
        }
        .setting-toggle:hover {
            transform: translateY(-2px);
            border-color: rgba(var(--acc-rgb),.32);
            background: linear-gradient(135deg, var(--acc-tint), #fff 70%);
            box-shadow: 0 10px 22px -14px rgba(var(--acc-rgb),.7);
        }
        .setting-toggle p { font-size: 13px; font-weight: 600; color: #1e293b; }
        .setting-toggle p + p { margin-top: 2px; font-size: 11.5px; font-weight: 400; color: #64748b; }
        .setting-toggle-lg { padding: 16px; border-radius: 18px; }
        .setting-toggle-sm { gap: 10px; padding: 9px 11px; border-radius: 13px; }
        .setting-toggle-sm p { font-size: 12px; }
        .setting-toggle.is-disabled { opacity: .5; pointer-events: none; }

        /* ─────────── FORM FIELDS ─────────── */
        .setting-label {
            display: block; margin-bottom: 7px;
            font-size: 12px; font-weight: 700; letter-spacing: .01em; color: #334155;
        }
        .setting-input {
            width: 100%; min-height: 44px;
            padding: 11px 15px; border-radius: 13px;
            font-size: 13.5px; font-weight: 500; color: #0f172a;
            background: #fff;
            border: 1px solid rgba(203,213,225,.95);
            box-shadow: 0 1px 2px rgba(15,23,42,.04);
            transition: all .3s ease;
        }
        .setting-input:hover { border-color: rgba(var(--acc-rgb),.4); }
        .setting-input:focus {
            outline: none;
            border-color: var(--acc) !important;
            border-width: 1px !important;
            box-shadow: 0 0 0 4px rgba(var(--acc-rgb),.14) !important;
        }
        textarea.setting-input { min-height: 84px; line-height: 1.65; resize: vertical; }
        .setting-hint { margin-top: 6px; font-size: 11px; font-weight: 500; color: #94a3b8; }

        .setting-upload {
            display: flex; align-items: center; gap: 12px; padding: 12px;
            border-radius: 16px;
            background: linear-gradient(135deg, #f8fafc, #fff);
            border: 1px dashed rgba(203,213,225,.95);
            transition: all .35s var(--ease-out-expo);
        }
        .setting-upload:hover { border-color: rgba(var(--acc-rgb),.5); background: linear-gradient(135deg, var(--acc-tint), #fff); }
        .setting-upload-preview {
            width: 56px; height: 56px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center; padding: 7px;
            border-radius: 12px; background: #fff;
            border: 1px solid rgba(226,232,240,.95);
            box-shadow: 0 2px 6px rgba(15,23,42,.07);
        }
        .setting-upload-drop {
            flex: 1; min-width: 0;
            display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 2px;
            padding: 10px; border-radius: 12px; cursor: pointer;
            transition: background .3s ease;
        }
        .setting-upload-drop:hover { background: rgba(var(--acc-rgb),.08); }

        .accent-swatch {
            display: block; width: 32px; height: 32px; border-radius: 12px;
            border: 2px solid transparent; cursor: pointer;
            box-shadow: 0 2px 8px rgba(15,23,42,.14), inset 0 1px 0 rgba(255,255,255,.4);
            transition: all .3s var(--ease-out-expo);
        }
        .accent-swatch:hover { transform: scale(1.1); }
        .peer:checked + .accent-swatch {
            border-color: #fff;
            box-shadow: 0 0 0 2px #fff, 0 0 0 4px #cbd5e1, 0 4px 12px rgba(15,23,42,.2);
        }

        /* ─────────── LIVE PREVIEW PAPER ─────────── */
        .paper {
            position: relative;
            background: linear-gradient(180deg, #fff, #fdfdfb);
            border-radius: 4px;
            box-shadow: 0 1px 2px rgba(15,23,42,.06), 0 18px 40px -18px rgba(15,23,42,.35);
            border: 1px solid rgba(226,232,240,.9);
        }
        .paper::before, .paper::after {
            content: ''; position: absolute; top: 0; bottom: 0; width: 5px;
            background: repeating-linear-gradient(to bottom, transparent 0 6px, rgba(148,163,184,.32) 6px 12px);
        }
        .paper::before { left: -5px; }
        .paper::after { right: -5px; }
        .paper-tear { border-top: 1px dashed rgba(148,163,184,.5); }

        /* ─────────── TOAST ─────────── */
        .toast-enter { animation: toastIn .35s cubic-bezier(.16,1,.3,1); }
        @keyframes toastIn { 0% { opacity: 0; transform: translateY(-14px) scale(.94); } 100% { opacity: 1; transform: none; } }

        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* ─────────── DARK MODE ─────────── */
        .dark .hero { border-color: rgba(255,255,255,.1); }
        .dark .setting-card { background: #1e293b; border-color: rgba(51,65,85,.7); box-shadow: 0 1px 2px rgba(0,0,0,.35), 0 18px 40px -22px rgba(0,0,0,.7); }
        .dark .setting-head { background: linear-gradient(135deg, rgba(var(--acc-rgb),.18), rgba(30,41,59,.55) 60%, #1e293b); border-bottom-color: rgba(var(--acc-rgb),.25); }
        .dark .setting-head h2 { color: #f8fafc; }
        .dark .setting-head p { color: #94a3b8; }
        .dark .setting-head-icon { background: linear-gradient(140deg, rgba(var(--acc-rgb),.3), rgba(var(--acc-rgb),.12)); border-color: rgba(var(--acc-rgb),.32); color: var(--acc); }
        .dark .setting-subhead { background: linear-gradient(90deg, rgba(245,158,11,.12), transparent); }
        .dark .setting-foot { background: linear-gradient(180deg, #1e293b, rgba(var(--acc-rgb),.12)); border-top-color: rgba(var(--acc-rgb),.25); }
        .dark .setting-toggle { background: #0f172a; border-color: rgba(51,65,85,.7); }
        .dark .setting-toggle:hover { background: linear-gradient(135deg, rgba(var(--acc-rgb),.16), #0f172a 70%); }
        .dark .setting-toggle p { color: #e2e8f0; }
        .dark .setting-toggle p + p { color: #94a3b8; }
        .dark .setting-label { color: #cbd5e1; }
        .dark .setting-input { background: #0f172a; border-color: #334155; color: #f1f5f9; }
        .dark .setting-input:hover { border-color: rgba(var(--acc-rgb),.55); }
        .dark .setting-hint { color: #64748b; }
        .dark .setting-upload { background: linear-gradient(135deg, #0f172a, #1e293b); border-color: #334155; }
        .dark .setting-upload-preview { background: #1e293b; border-color: #334155; }
        .dark .setting-upload-drop:hover { background: rgba(var(--acc-rgb),.14); }
        .dark .setnav { background: #1e293b; border-color: rgba(51,65,85,.7); }
        .dark .setnav-top { background: linear-gradient(165deg, #1e293b, rgba(16,185,129,.1)); border-bottom-color: rgba(51,65,85,.6); }
        .dark .setnav-search input[type="text"] { background: #0f172a; border-color: #334155; color: #e2e8f0; }
        .dark .setnav-item { color: #94a3b8; }
        .dark .setnav-item:hover { color: var(--acc); }
        .dark .setnav-item.is-active { color: #fff; }
        .dark .setnav-icon { color: var(--acc); }
        .dark .setnav-foot { background: #172033; border-top-color: rgba(51,65,85,.6); }
        .dark .setpill { background: #1e293b; border-color: rgba(51,65,85,.7); color: #94a3b8; }
        .dark .paper { background: linear-gradient(180deg, #f8fafc, #f1f5f9); border-color: rgba(51,65,85,.5); }
    </style>
    @endpush

    <div class="set-root" x-data="settingApp()" x-init="initApp()">

        {{-- ═══ TOAST NOTIFICATION ═══ --}}
        <div x-show="showToast" x-cloak class="fixed top-4 right-4 z-50 toast-enter" x-transition>
            <div :class="toastType === 'success' ? 'bg-emerald-600' : 'bg-red-600'" class="flex items-center gap-3 px-5 py-3.5 rounded-2xl shadow-2xl text-white text-sm font-medium min-w-[300px]">
                <template x-if="toastType === 'success'">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </template>
                <template x-if="toastType === 'error'">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                </template>
                <span x-text="toastMessage" class="flex-1"></span>
                <button @click="showToast = false" class="text-white/70 hover:text-white transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        {{-- ═══ SESSION FLASH → TOAST ═══ --}}
        @if (session('success'))
        <div x-init="showToastMessage('success', '{{ session('success') }}')"></div>
        @endif
        @if (session('error'))
        <div x-init="showToastMessage('error', '{{ session('error') }}')"></div>
        @endif

        {{-- ═══ HERO — Desa Digital Command Center ═══ --}}
        @include('admin.setting.partials._hero')

        {{-- ═══ VALIDATION ERRORS ═══ --}}
        @if ($errors->any())
        <div class="mb-6 flex items-start gap-3 rounded-2xl border border-red-200 bg-gradient-to-r from-red-50 to-white px-5 py-4 animate-fade-in">
            <svg class="w-5 h-5 shrink-0 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
            <div class="flex-1">
                <p class="text-sm font-semibold text-red-800">Terdapat kesalahan pada input</p>
                <ul class="mt-1.5 ml-4 list-disc text-sm text-red-600 space-y-0.5">
                    @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        {{-- ═══ MOBILE PILL TABS ═══ --}}
        <div class="lg:hidden mb-5 -mx-1 px-1">
            <div class="flex gap-2 overflow-x-auto pb-2 hide-scrollbar">
                @foreach ($categories as $key => $menu)
                <button @click="switchTab('{{ $key }}')"
                        data-acc="{{ $menu['accent'] ?? 'emerald' }}"
                        :class="activeTab === '{{ $key }}' ? 'is-active' : ''"
                        class="setpill shrink-0">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $menu['icon'] }}"/>
                    </svg>
                    <span>{{ $menu['label'] }}</span>
                </button>
                @endforeach
            </div>
        </div>

        {{-- ═══ THREE-COLUMN LAYOUT ═══ --}}
        <div class="flex flex-wrap items-start gap-5 lg:gap-6">

            {{-- ═══ LEFT SIDEBAR ═══ --}}
            <aside class="order-1 w-full lg:w-[238px] xl:w-[254px] shrink-0 hidden lg:block">
                <div class="lg:sticky lg:top-8">
                    <nav class="setnav">
                        <div class="setnav-top">
                            <div class="flex items-center justify-between gap-2">
                                <p class="setnav-kicker">Modul Konfigurasi</p>
                                <span class="chip chip-brand">{{ count($categories) }}</span>
                            </div>
                            <div class="setnav-search">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                                </svg>
                                <input type="text" x-model="menuQuery" placeholder="Cari pengaturan…" aria-label="Cari pengaturan">
                                <button x-show="menuQuery" x-cloak @click="menuQuery = ''" class="setnav-clear" aria-label="Bersihkan pencarian">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        </div>

                        <div class="setnav-scroll hide-scrollbar">
                            @foreach ($categoriesBySection as $section => $items)
                            <div class="setnav-section" x-show="sectionVisible(@js($section))" x-cloak>
                                <p class="setnav-section-title">{{ $section }}</p>
                                @foreach ($items as $key => $menu)
                                <button @click="switchTab('{{ $key }}')"
                                        data-acc="{{ $menu['accent'] ?? 'emerald' }}"
                                        :class="activeTab === '{{ $key }}' ? 'is-active' : ''"
                                        class="setnav-item">
                                    <span class="setnav-icon">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $menu['icon'] }}"/>
                                        </svg>
                                    </span>
                                    <span class="setnav-label">{{ $menu['label'] }}</span>
                                    @if ($key === 'audit-log')
                                    <span class="setnav-count">{{ $auditLogs->count() }}</span>
                                    @endif
                                    <svg class="setnav-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                                </button>
                                @endforeach
                            </div>
                            @endforeach

                            <div class="setnav-empty" x-show="!hasMenuResults()" x-cloak>
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                                <p>Tidak ada pengaturan yang cocok</p>
                            </div>
                        </div>

                        <div class="setnav-foot">
                            <span><b data-acc="emerald" class="inline-block">{{ count($categories) }}</b> modul aktif</span>
                            <span>Konfigurasi <b data-acc="emerald" class="inline-block">v{{ $currentVersion ?? 0 }}</b></span>
                        </div>
                    </nav>
                </div>
            </aside>

            {{-- ═══ CENTER CONTENT ═══ --}}
            <div class="order-2 flex-1 min-w-[340px]">
                {{-- Skeleton --}}
                @include('admin.setting.partials._skeleton')

                {{-- Tab Panels --}}
                <div class="space-y-5" x-show="!loading">
                    @include('admin.setting.partials._profil_desa')
                    @include('admin.setting.partials._pemerintahan')
                    @include('admin.setting.partials._ttd_digital')
                    @include('admin.setting.partials._template_surat')
                    @include('admin.setting.partials._nomor_surat')
                    @include('admin.setting.partials._workflow')
                    @include('admin.setting.partials._queue_driver')
                    @include('admin.setting.partials._antrean')
                    @include('admin.setting.partials._notifikasi')
                    @include('admin.setting.partials._analytics')
                    @include('admin.setting.partials._backup')
                    @include('admin.setting.partials._keamanan')
                    @include('admin.setting.partials._integrasi')
                    @include('admin.setting.partials._tampilan')
                    @include('admin.setting.partials._maintenance')
                    @include('admin.setting.partials._audit_log')
                </div>
            </div>

            {{-- ═══ RIGHT PREVIEW PANEL ═══
                 Side-by-side only when there is genuinely room (≥1280px).
                 Below that it wraps onto its own row under the forms. ═══ --}}
            <aside class="order-3 w-full max-w-[400px] shrink-0 ml-auto lg:mt-2 xl:w-[330px] xl:max-w-none xl:ml-0">
                <div class="lg:sticky lg:top-8">
                    @include('admin.setting.partials._preview_panel')
                </div>
            </aside>

        </div>
    </div>

    @push('scripts')
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script>
        function updateWidgetAktif(el) {
            const checks = document.querySelectorAll('input[type="checkbox"][value]');
            const vals = [];
            checks.forEach(c => { if (c.checked && c.value) vals.push(c.value); });
            document.getElementById('analytics_widget_aktif').value = vals.join(',');
        }

        function settingApp() {
            const urlParams = new URLSearchParams(window.location.search);
            const tabFromUrl = urlParams.get('tab') || 'profil-desa';

            return {
                activeTab: tabFromUrl,
                saving: false,
                savingBackup: false,
                loading: true,
                showToast: false,
                toastMessage: '',
                toastType: 'success',
                previewNumber: '',
                menuQuery: '',

                // label + description per category key, used by the nav search filter
                menuIndex: @json(collect($categories)->map(fn ($m, $k) => $k . ' ' . $m['label'] . ' ' . ($m['description'] ?? ''))->all()),
                menuSections: @json(collect($categoriesBySection)->map(fn ($items) => array_keys($items))->all()),

                preview: Object.assign({
                    logoPreview: null,
                    logoPemdaPreview: null,
                    stempelPreview: null,
                    ttdKadesPreview: null,
                    ttd_digital_aktif: {{ ($settings['ttd_digital_aktif'] ?? '1') == '1' ? 'true' : 'false' }},
                    qr_verifikasi_aktif: {{ ($settings['qr_verifikasi_aktif'] ?? '1') == '1' ? 'true' : 'false' }},
                }, @json($previewDefaults)),

                initApp() {
                    this.updatePreviewNumber();
                    const self = this;
                    this.loading = false;

                    const watchFields = ['format_nomor_surat', 'nomor_prefix', 'nomor_padding', 'nomor_suffix'];
                    watchFields.forEach(field => {
                        this.$watch('preview.' + field, () => self.updatePreviewNumber());
                    });
                },

                matches(key) {
                    const q = this.menuQuery.trim().toLowerCase();
                    if (!q) return true;
                    return (this.menuIndex[key] || '').toLowerCase().includes(q);
                },

                sectionVisible(section) {
                    const keys = this.menuSections[section] || [];
                    return keys.some(key => this.matches(key));
                },

                hasMenuResults() {
                    return Object.keys(this.menuSections).some(section => this.sectionVisible(section));
                },

                switchTab(tab) {
                    this.activeTab = tab;
                    history.replaceState(null, '', '?tab=' + tab);
                    document.querySelector('main')?.scrollTo({ top: 0, behavior: 'smooth' });
                },

                showToastMessage(type, message) {
                    this.toastType = type;
                    this.toastMessage = message;
                    this.showToast = true;
                    setTimeout(() => { this.showToast = false; }, 4000);
                },

                async asyncNotifyTest() {
                    try {
                        const res = await fetch('{{ route('admin.setting.notifyTest') }}', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                            },
                            body: '{}',
                        });
                        const data = await res.json();
                        this.showToastMessage(data.success ? 'success' : 'error', data.message || (data.success ? 'Pesan uji terkirim.' : 'Gagal mengirim pesan uji.'));
                    } catch (e) {
                        this.showToastMessage('error', 'Terjadi kesalahan jaringan saat mengirim pesan uji.');
                    }
                },

                updatePreviewNumber() {
                    const format = this.preview.format_nomor_surat || '{prefix} / {no} / {suffix} / {tahun}';
                    const padding = parseInt(this.preview.nomor_padding) || 4;
                    const now = new Date();
                    const year = now.getFullYear();
                    const month = String(now.getMonth() + 1).padStart(2, '0');
                    const day = String(now.getDate()).padStart(2, '0');
                    const id = '1';
                    const no = '1';
                    const paddedNo = String(no).padStart(padding, '0');
                    const paddedId = String(id).padStart(padding, '0');
                    this.previewNumber = format
                        .replace('{kode_surat}', 'SKTM')
                        .replace('{kode}', 'SKTM')
                        .replace('{id}', paddedId)
                        .replace('{no}', paddedNo)
                        .replace('{prefix}', this.preview.nomor_prefix || '470')
                        .replace('{suffix}', this.preview.nomor_suffix || 'DS-KP')
                        .replace('{tahun}', year)
                        .replace('{bulan}', month)
                        .replace('{hari}', day);
                },

                updatePreviewLogo(ref) {
                    if (ref && ref.files && ref.files[0]) {
                        const reader = new FileReader();
                        reader.onload = (e) => { this.preview.logoPreview = e.target.result; };
                        reader.readAsDataURL(ref.files[0]);
                    }
                },

                updatePreviewLogoPemda(ref) {
                    if (ref && ref.files && ref.files[0]) {
                        const reader = new FileReader();
                        reader.onload = (e) => { this.preview.logoPemdaPreview = e.target.result; };
                        reader.readAsDataURL(ref.files[0]);
                    }
                },

                updatePreviewStempel(ref) {
                    if (ref && ref.files && ref.files[0]) {
                        const reader = new FileReader();
                        reader.onload = (e) => { this.preview.stempelPreview = e.target.result; };
                        reader.readAsDataURL(ref.files[0]);
                    }
                },

                updatePreviewTtdKades(ref) {
                    if (ref && ref.files && ref.files[0]) {
                        const reader = new FileReader();
                        reader.onload = (e) => { this.preview.ttdKadesPreview = e.target.result; };
                        reader.readAsDataURL(ref.files[0]);
                    }
                },
            }
        }

        function updateApp() {
            return {
                busy: false,
                checking: false,
                updating: false,
                statusLoaded: false,
                hasUpdate: false,
                isUpToDate: false,
                statusError: '',
                current: {},
                behindCount: 0,
                latestHash: '',
                latestMessage: '',
                latestDate: '',
                logVisible: false,
                logText: '',

                initUpdate() {
                    this.check();
                },

                formatDate(iso) {
                    try {
                        return new Date(iso).toLocaleString('id-ID', { dateStyle: 'medium', timeStyle: 'short' });
                    } catch (e) {
                        return iso;
                    }
                },

                async check() {
                    if (this.busy) return;
                    this.busy = true;
                    this.checking = true;
                    this.statusError = '';
                    this.hasUpdate = false;
                    this.isUpToDate = false;
                    this.statusLoaded = false;

                    try {
                        const res = await fetch('{{ route('admin.setting.updateStatus') }}', {
                            headers: { 'Accept': 'application/json' },
                        });
                        const data = await res.json();

                        if (!data.success) {
                            this.statusError = data.message || 'Gagal memeriksa update.';
                            this.statusLoaded = true;
                            return;
                        }

                        this.current = data.current || {};
                        const update = data.update || {};
                        this.behindCount = update.behindCount || 0;
                        this.latestHash = update.latestHash || '';
                        this.latestMessage = update.latestMessage || '';
                        this.latestDate = update.latestDate || '';
                        this.hasUpdate = !!update.hasUpdate;
                        if (update.error) {
                            this.statusError = update.error;
                            this.isUpToDate = false;
                        } else {
                            this.isUpToDate = !this.hasUpdate;
                        }
                        this.statusLoaded = true;
                    } catch (e) {
                        this.statusError = 'Terjadi kesalahan jaringan saat memeriksa update.';
                        this.statusLoaded = true;
                    } finally {
                        this.busy = false;
                        this.checking = false;
                    }
                },

                async updateNow() {
                    if (this.busy) return;

                    if (!confirm('Yakin ingin memperbarui aplikasi ke versi terbaru?\n\nProses berjalan beberapa menit (pull, composer, migrate, npm build).')) {
                        return;
                    }

                    this.busy = true;
                    this.updating = true;
                    this.logVisible = true;
                    this.logText = 'Memulai update...\n';

                    try {
                        const res = await fetch('{{ route('admin.setting.updateApp') }}', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                            },
                            body: '{}',
                        });
                        const data = await res.json();

                        if (!data.success) {
                            this.logText += 'Update gagal.\n';
                        } else {
                            this.logText += 'Update berhasil.\n';
                        }

                        if (data.steps && data.steps.length) {
                            data.steps.forEach(step => {
                                this.logText += `\n── [${step.step}] ${step.success ? 'OK' : 'GAGAL'}\n`;
                                if (step.output) this.logText += step.output + '\n';
                            });
                        } else if (data.message) {
                            this.logText += data.message + '\n';
                        }

                        if (data.success) {
                            setTimeout(() => this.check(), 500);
                        }
                    } catch (e) {
                        this.logText += 'Terjadi kesalahan jaringan saat update.\n';
                    } finally {
                        this.busy = false;
                        this.updating = false;
                    }
                },
            }
        }
    </script>
    @endpush
</x-admin-layout>
