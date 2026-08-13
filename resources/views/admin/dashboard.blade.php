<x-admin-layout title="Dashboard" maxWidth="max-w-[1440px]">
    @php
        $widgetManager = app(\App\Dashboard\WidgetManager::class);
        $widgetManager->init();
        $layout = $widgetManager->factory()->buildLayout();
    @endphp

    <div x-data="dashboardApp()" x-init="initApp()">

        {{-- Bento Grid --}}
        <div class="bento-grid">
            @foreach ($layout as $widget)
                @php $span = $widget['grid_span'] ?? 12; @endphp
                @if ($widget['lazy'])
                    {{-- Lazy-loaded widget via AJAX --}}
                    <div
                        x-data="lazyWidget('{{ $widget['key'] }}')"
                        x-intersect.once="load()"
                        data-span="{{ $span }}"
                        class="a-fade-up d{{ min($loop->index + 1, 10) }}"
                    >
                        {{-- Skeleton placeholder --}}
                        <template x-if="loading">
                            <div class="bento-card bg-white rounded-2xl overflow-hidden">
                                <div class="p-5 space-y-4">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="w-10 h-10 rounded-xl skeleton-shimmer"></div>
                                        <div class="space-y-2">
                                            <div class="h-3 skeleton-shimmer rounded-full w-32"></div>
                                            <div class="h-2 skeleton-shimmer rounded-full w-20"></div>
                                        </div>
                                    </div>
                                    @if(in_array($widget['key'], ['stats']))
                                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                            @foreach(range(1, 4) as $i)
                                                <div class="bg-gradient-to-br from-slate-50 to-slate-100 rounded-xl p-4 space-y-2">
                                                    <div class="h-2 skeleton-shimmer rounded-full w-16"></div>
                                                    <div class="h-7 skeleton-shimmer rounded-lg w-12"></div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @elseif(in_array($widget['key'], ['submissions', 'sla']))
                                        @foreach(range(1, 5) as $i)
                                        <div class="flex items-center gap-3 py-3 {{ $i < 5 ? 'border-b border-slate-50' : '' }}">
                                            <div class="w-9 h-9 rounded-full skeleton-shimmer"></div>
                                            <div class="flex-1 space-y-2">
                                                <div class="h-3 skeleton-shimmer rounded-full w-1/4"></div>
                                                <div class="h-2 skeleton-shimmer rounded-full w-1/6"></div>
                                            </div>
                                            <div class="h-6 skeleton-shimmer rounded-full w-16"></div>
                                        </div>
                                        @endforeach
                                    @else
                                        @foreach(range(1, 3) as $i)
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full skeleton-shimmer shrink-0"></div>
                                            <div class="flex-1 space-y-2">
                                                <div class="h-3 skeleton-shimmer rounded-full w-3/4"></div>
                                                <div class="h-2 skeleton-shimmer rounded-full w-1/2"></div>
                                            </div>
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </template>

                        {{-- Actual widget content --}}
                        <template x-if="!loading && html">
                            <div x-html="html" class="a-fade-in"></div>
                        </template>

                        {{-- Error state --}}
                        <template x-if="!loading && error">
                            <div class="bento-card bg-white rounded-2xl p-8 text-center">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-50 to-orange-50 flex items-center justify-center mx-auto mb-4 border border-amber-100/60 shadow-sm">
                                    <svg class="w-7 h-7 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                                </div>
                                <p class="text-sm font-semibold text-slate-700 mb-1" x-text="errorMessage"></p>
                                <p class="text-xs text-slate-400 mb-5">Error setelah <span x-text="maxRetries"></span>x percobaan ulang</p>
                                <button @click="retries = 0; error = false; load()" class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#10b981] text-white text-sm font-semibold shadow-lg shadow-brand-500/25 hover:shadow-xl hover:shadow-brand-500/30 hover:-translate-y-0.5 transition-all duration-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.992 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182"/></svg>
                                    Muat Ulang
                                </button>
                            </div>
                        </template>
                    </div>
                @else
                    {{-- Eager-loaded widget (rendered server-side) --}}
                    <div data-span="{{ $span }}" class="a-fade-up d{{ min($widget['position'], 10) }}">
                        @include($widget['component'], $widget['data'])
                    </div>
                @endif
            @endforeach
        </div>

        {{-- Footer --}}
        <div class="border-t border-slate-200/60 pt-5 pb-2 mt-8 a-fade-in d10">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-[11px] text-slate-400">
                <div class="flex items-center gap-3">
                    <span class="font-semibold text-slate-500">Prodesa v1.0</span>
                    <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                    <span class="px-2 py-0.5 rounded-full {{ config('app.env') === 'production' ? 'bg-emerald-50 text-emerald-600 font-semibold border border-emerald-100' : 'bg-amber-50 text-amber-600 font-semibold border border-amber-100' }}">{{ ucfirst(config('app.env')) }}</span>
                </div>
                <span>&copy; {{ date('Y') }} {{ config('village.nama_desa', 'Desa') }} &middot; IG <a href="https://instagram.com/rangga.mrw" target="_blank" class="text-slate-500 hover:text-brand-600 transition font-medium">@rangga.mrw</a></span>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        /* ── Bento Grid System ── */
        .bento-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        @media (min-width: 640px) {
            .bento-grid { grid-template-columns: repeat(2, 1fr); gap: 1.25rem; }
        }
        @media (min-width: 1024px) {
            .bento-grid { grid-template-columns: repeat(12, 1fr); gap: 1.25rem; }
        }

        .bento-grid > [data-span="12"] { grid-column: span 1 / -1; }
        .bento-grid > [data-span="8"] { grid-column: span 1 / -1; }
        .bento-grid > [data-span="6"] { grid-column: span 1; }
        .bento-grid > [data-span="4"] { grid-column: span 1; }
        @media (min-width: 640px) {
            .bento-grid > [data-span="6"] { grid-column: span 2; }
            .bento-grid > [data-span="4"] { grid-column: span 2; }
            .bento-grid > [data-span="8"] { grid-column: span 2; }
        }
        @media (min-width: 1024px) {
            .bento-grid > [data-span="12"] { grid-column: span 12; }
            .bento-grid > [data-span="8"] { grid-column: span 8; }
            .bento-grid > [data-span="6"] { grid-column: span 6; }
            .bento-grid > [data-span="4"] { grid-column: span 4; }
        }

        /* ── Scroll Reveal ── */
        .a-fade-up, .a-fade-in, .a-scale {
            opacity: 0; transform: translateY(16px);
            transition: opacity .6s cubic-bezier(.22,1,.36,1), transform .6s cubic-bezier(.22,1,.36,1);
        }
        .a-fade-in { transform: none; }
        .a-scale { transform: scale(.97); }
        .a-fade-up.v, .a-fade-in.v, .a-scale.v { opacity: 1; transform: none; }

        /* ── Stagger Delays ── */
        .d1 { transition-delay: .05s } .d2 { transition-delay: .1s } .d3 { transition-delay: .15s }
        .d4 { transition-delay: .2s } .d5 { transition-delay: .25s } .d6 { transition-delay: .3s }
        .d7 { transition-delay: .35s } .d8 { transition-delay: .4s } .d9 { transition-delay: .45s }
        .d10 { transition-delay: .5s }

        /* ── Skeleton Enhancements ── */
        .skeleton-shimmer {
            background: linear-gradient(90deg, rgba(226,232,240,.4) 25%, rgba(226,232,240,.8) 50%, rgba(226,232,240,.4) 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s ease-in-out infinite;
        }
        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        function dashboardApp() {
            return {
                clock: '',
                currentDate: '',
                greeting: '',
                searchQuery: '',
                initApp() {
                    this.updateClock();
                    this.updateGreeting();
                    setInterval(() => this.updateClock(), 1000);
                    this.initReveal();
                },
                updateClock() {
                    const now = new Date();
                    this.clock = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
                    this.currentDate = now.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
                },
                updateGreeting() {
                    const h = new Date().getHours();
                    if (h < 12) this.greeting = 'Selamat Pagi';
                    else if (h < 15) this.greeting = 'Selamat Siang';
                    else if (h < 18) this.greeting = 'Selamat Sore';
                    else this.greeting = 'Selamat Malam';
                },
                search() {
                    if (this.searchQuery.trim()) {
                        window.location.href = '/admin/search?q=' + encodeURIComponent(this.searchQuery);
                    }
                },
                initReveal() {
                    const obs = new IntersectionObserver((entries) => {
                        entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('v'); obs.unobserve(e.target); } });
                    }, { threshold: 0.1 });
                    document.querySelectorAll('.a-fade-up, .a-fade-in, .a-scale').forEach(el => obs.observe(el));
                }
            }
        }

        function animateNumber(el, target) {
            let current = 0;
            const duration = 1200;
            const start = performance.now();
            function update(now) {
                const t = Math.min((now - start) / duration, 1);
                const ease = 1 - Math.pow(1 - t, 4);
                el.textContent = Math.floor(ease * target).toLocaleString('id-ID');
                if (t < 1) requestAnimationFrame(update);
                else el.textContent = target.toLocaleString('id-ID');
            }
            requestAnimationFrame(update);
        }

        function chartSection() {
            return {
                mainChart: null,
                donutChart: null,
                mainChartDays: 30,
                trendData: [],
                letterData: [],
                initCharts() {
                    try {
                        const trendEl = document.getElementById('trend-data');
                        const letterEl = document.getElementById('letter-data');
                        if (trendEl) this.trendData = JSON.parse(trendEl.textContent);
                        if (letterEl) this.letterData = JSON.parse(letterEl.textContent);
                    } catch (e) { return; }
                    this.renderMainChart(this.mainChartDays);
                    this.renderDonutChart();
                },
                renderMainChart(days) {
                    const filtered = days >= 365 ? this.trendData : this.trendData.slice(-days);
                    const mainCtx = document.getElementById('mainChart');
                    if (!mainCtx) return;
                    if (this.mainChart) this.mainChart.destroy();
                    const ctx = mainCtx.getContext('2d');
                    const grad1 = ctx.createLinearGradient(0, 0, 0, 300);
                    grad1.addColorStop(0, 'rgba(99,102,241,0.12)');
                    grad1.addColorStop(1, 'rgba(99,102,241,0.01)');
                    const grad2 = ctx.createLinearGradient(0, 0, 0, 300);
                    grad2.addColorStop(0, 'rgba(16,185,129,0.12)');
                    grad2.addColorStop(1, 'rgba(16,185,129,0.01)');
                    this.mainChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: filtered.map(d => d.label.substring(0, 6)),
                            datasets: [
                                { label: 'Total', data: filtered.map(d => d.total), borderColor: '#6366f1', backgroundColor: grad1, tension: 0.4, fill: true, pointRadius: 3, pointHoverRadius: 7, pointBackgroundColor: '#6366f1', borderWidth: 2.5, pointBorderColor: '#fff', pointBorderWidth: 2 },
                                { label: 'Selesai', data: filtered.map(d => d.selesai), borderColor: '#10b981', backgroundColor: grad2, tension: 0.4, fill: true, pointRadius: 3, pointHoverRadius: 7, pointBackgroundColor: '#10b981', borderWidth: 2.5, pointBorderColor: '#fff', pointBorderWidth: 2 }
                            ]
                        },
                        options: {
                            responsive: true, maintainAspectRatio: false,
                            interaction: { intersect: false, mode: 'index' },
                            animation: { duration: 800, easing: 'easeOutQuart' },
                            plugins: { legend: { position: 'top', labels: { boxWidth: 10, padding: 16, font: { size: 11, family: 'Montserrat' }, usePointStyle: true, pointStyle: 'circle' } }, tooltip: { backgroundColor: '#0f172a', padding: 14, cornerRadius: 12, titleFont: { family: 'Montserrat', weight: '600' }, bodyFont: { family: 'Montserrat' } } },
                            scales: { y: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 10, family: 'Montserrat' } }, grid: { color: 'rgba(0,0,0,0.03)' } }, x: { ticks: { font: { size: 10, family: 'Montserrat' } }, grid: { display: false } } }
                        }
                    });
                },
                renderDonutChart() {
                    if (!this.letterData.length) return;
                    const totalLetters = this.letterData.reduce((sum, d) => sum + d.total, 0);
                    const donutCtx = document.getElementById('donutChart');
                    if (!donutCtx) return;
                    if (this.donutChart) this.donutChart.destroy();
                    this.donutChart = new Chart(donutCtx.getContext('2d'), {
                        type: 'doughnut',
                        data: { labels: this.letterData.map(d => d.label), datasets: [{ data: this.letterData.map(d => d.total), backgroundColor: this.letterData.map(d => d.color), borderWidth: 0, hoverOffset: 12, borderRadius: 4 }] },
                        options: { responsive: true, maintainAspectRatio: false, cutout: '72%', animation: { duration: 1000, easing: 'easeOutQuart' }, plugins: { legend: { display: false }, tooltip: { backgroundColor: '#0f172a', padding: 12, cornerRadius: 10, titleFont: { family: 'Montserrat', weight: '600' }, bodyFont: { family: 'Montserrat' }, callbacks: { label: ctx => ctx.label + ': ' + ctx.parsed + ' (' + (totalLetters > 0 ? ((ctx.parsed / totalLetters) * 100).toFixed(1) : 0) + '%)' } } } },
                        plugins: [{ id: 'centerText', beforeDraw(chart) { const { width, height, ctx } = chart; ctx.save(); ctx.font = 'bold 28px Montserrat, sans-serif'; ctx.textAlign = 'center'; ctx.textBaseline = 'middle'; ctx.fillStyle = '#0f172a'; ctx.fillText(totalLetters.toString(), width / 2, height / 2 - 8); ctx.font = '500 11px Montserrat, sans-serif'; ctx.fillStyle = '#94a3b8'; ctx.fillText('Total Surat', width / 2, height / 2 + 16); ctx.restore(); } }]
                    });
                },
                filterMainChart(days) {
                    this.mainChartDays = days;
                    this.renderMainChart(days);
                }
            }
        }

        function lazyWidget(key) {
            return {
                loading: true,
                html: '',
                error: false,
                errorMessage: '',
                retries: 0,
                maxRetries: 2,
                async load() {
                    this.loading = true;
                    this.error = false;
                    this.errorMessage = '';
                    try {
                        const resp = await fetch(`/admin/widgets/${key}`, {
                            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                            credentials: 'same-origin',
                        });
                        if (!resp.ok) {
                            const errData = await resp.json().catch(() => ({}));
                            throw new Error(errData.message || `HTTP ${resp.status}`);
                        }
                        const data = await resp.json();
                        if (data.error) throw new Error(data.message || 'Widget error');
                        this.html = data.html;
                        this.loading = false;
                        this.retries = 0;
                        this.$nextTick(() => { this.initWidgetScripts(key); });
                    } catch (e) {
                        if (this.retries < this.maxRetries) {
                            this.retries++;
                            setTimeout(() => this.load(), this.retries * 1500);
                        } else {
                            this.loading = false;
                            this.error = true;
                            this.errorMessage = e.message || 'Gagal memuat widget';
                        }
                    }
                },
                initWidgetScripts(key) {
                    this.$nextTick(() => {
                        Alpine.initTree(this.$el);
                        if (key === 'charts') {
                            this.$nextTick(() => {
                                const el = document.getElementById('mainChart');
                                if (el && el.closest('[x-data*="chartSection"]')) {
                                    Alpine.$data(el.closest('[x-data*="chartSection"]')).initCharts();
                                }
                            });
                        }
                    });
                }
            };
        }
    </script>
    @endpush
</x-admin-layout>
