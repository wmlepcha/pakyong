// Site behaviour: input guard, trip planner, contact form, photo mosaic, scroll effects.
// Data from the server arrives as data attributes on <body> (wa, dest, regions), so no code is written into the page.
    // No backend yet: the final step opens WhatsApp with the enquiry prefilled.
    // Input hygiene for every form. Forms hand off to WhatsApp, so this is client-side only.
    // If a server endpoint is ever added, repeat these rules there: never trust the browser.
    const Guard = (() => {
        const INVISIBLE = /[\u200B-\u200F\u202A-\u202E\u2060-\u206F\uFEFF]/g;      // zero-width and bidi tricks
        const CONTROL = /[\u0000-\u0008\u000B\u000C\u000E-\u001F\u007F-\u009F]/g; // control chars (keeps tab and newline)
        const base = s => String(s ?? '').normalize('NFKC').replace(INVISIBLE, '').replace(CONTROL, '');
        const squash = (s, n) => s.replace(new RegExp('(.)\\1{' + n + ',}', 'gsu'), (m, c) => c.repeat(n));
        const DEST = JSON.parse(document.body.dataset.dest); // generated from the destination list, so new places are allowed automatically
        const DAYS = [3, 4, 5, 6, 7, 8, 10];
        const WHO = ['Sikkim resident', 'Indian visitor', 'Foreign national'];
        const SEASON = ['Peak season', 'Shoulder season', 'Off-season', 'Not sure yet'];
        const STAY = ['Flexible, suggest for me', 'Homestays', 'Hotels', 'Resorts'];
        const TIER = ['Base', 'Standard', 'Premium'];
        return {
            DEST, DAYS, WHO, SEASON, STAY, TIER,
            budget: s => base(s).replace(/\D/g, '').replace(/^0+/, '').slice(0, 7),
            pick: (list, v, d) => list.includes(v) ? v : d,
            name: s => squash(base(s).replace(/<[^>]*>?/g, '').replace(/[^\p{L}\p{M}\s.'’-]/gu, '').replace(/\s+/g, ' ').replace(/([.'’-])\1+/gu, '$1').replace(/^\s+/, ''), 3).slice(0, 60),
            phone: s => base(s).replace(/[^\d+\s()-]/g, '').replace(/^\s+/, '').replace(/(?!^)\+/g, '').replace(/\s{2,}/g, ' ').slice(0, 20),
            text: (s, max = 500) => squash(base(s).replace(/<[^>]*>?/g, '').replace(/[<>]/g, '').replace(/\r\n?/g, '\n').replace(/[ \t]{2,}/g, ' ').replace(/\n{3,}/g, '\n\n'), 5).slice(0, max),
            line: (s, max = 60) => squash(base(s).replace(/<[^>]*>?/g, '').replace(/[<>]/g, '').replace(/\s+/g, ' ').replace(/^\s+/, ''), 5).slice(0, max),
            people: n => Math.min(50, Math.max(1, parseInt(n, 10) || 1)),
            days: n => DAYS.includes(+n) ? +n : 5,
            vName: s => { const v = s.trim(); return v.length < 2 ? 'Please enter your name.' : (/\p{L}{2}/u.test(v) ? '' : 'Your name should contain letters.'); },
            vPhone: s => { const d = s.replace(/\D/g, ''); return d.length >= 10 && d.length <= 15 ? '' : 'Enter a valid phone number (10 to 15 digits).'; },
            vMsg: s => { const v = s.trim(); return v.length < 10 ? 'Please write a little more (at least 10 characters).' : ((v.match(/\p{L}/gu) || []).length < 5 ? 'Please write your message in words.' : ''); },
            vDate: s => {
                if (!/^\d{4}-\d{2}-\d{2}$/.test(s || '')) return 'Please pick a travel date.';
                const d = new Date(s + 'T00:00'), today = new Date(); today.setHours(0, 0, 0, 0);
                const limit = new Date(today); limit.setFullYear(limit.getFullYear() + 3);
                return isNaN(d) || d < today || d > limit ? 'Please pick a date within the next 3 years.' : '';
            },
        };
    })();

    // Records the lead on the server. Fire and forget: WhatsApp must open in the same tap (iOS blocks popups opened after a wait).
    function record(url, payload) {
        const token = document.querySelector('meta[name="csrf-token"]')?.content;
        try {
            fetch(url, { method: 'POST', keepalive: true, headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': token || '' }, body: JSON.stringify(payload) }).catch(() => {});
        } catch (e) { /* the WhatsApp message still goes out */ }
    }

    function trip() {
        const iso = d => `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}-${String(d.getDate()).padStart(2, '0')}`;
        return {
            openedAt: 0, open: false, wide: true, mexp: true, mexpEdit: false, step: 1, review: false, editing: false, err: '', buildErr: '', errs: {}, busy: false, dy: 0, ty: null, today: iso(new Date()),
                        titles: ['Where would you like to go?', 'Who is travelling?', 'Dates and group size', 'Budget and stay'],
            mlabels: ['Experience', 'Destinations', 'Traveller and season', 'Dates and group', 'Budget and stay', 'Review and send'],
            init() {
                const mq = matchMedia('(min-width: 64rem)'); this.wide = mq.matches; mq.addEventListener('change', e => this.wide = e.matches);
                // iOS keeps the layout viewport under the keyboard: size the overlay to the visual viewport so the sheet and its buttons stay visible.
                const vv = window.visualViewport;
                if (vv) {
                    const sync = () => { const r = document.documentElement.style; r.setProperty('--vvh', vv.height + 'px'); r.setProperty('--vvt', vv.offsetTop + 'px'); };
                    vv.addEventListener('resize', sync); vv.addEventListener('scroll', sync); sync();
                }
            },
            // Small screens: Next stays disabled until the current step has what it needs; hint says what is missing.
            get hint() {
                const f = this.f;
                if (this.mexp) return f.tier ? '' : 'Choose an experience to continue.';
                if (this.review) return Guard.vName(f.name) ? 'Enter your name to continue.' : (Guard.vPhone(f.phone) ? 'Enter a valid phone number to continue.' : '');
                return this.missing(this.step);
            },
            // First thing still missing on a build step (1 to 4), or an empty string.
            missing(n) {
                const f = this.f;
                if (n === 1) return f.dests.length && f.dests.every(d => Guard.DEST.includes(d)) ? '' : 'Choose at least one destination.';
                if (n === 2) return !f.who ? 'Choose a traveller category.' : (!f.season ? 'Choose a travel season.' : '');
                if (n === 3) return Guard.vDate(f.date) ? 'Pick a start date to continue.' : (!f.days ? 'Choose how many days.' : (+f.people >= 1 ? '' : 'Add the number of travellers.'));
                if (n === 4) {
                    if (f.budget !== '' && (+f.budget < 500 || +f.budget > 1000000)) return 'Budget should be between ₹500 and ₹10,00,000.';
                    return f.stay ? '' : 'Choose a stay preference.';
                }
                return '';
            },
            get ready() { return !this.hint; },
            get mnum() { return this.mexp ? 1 : (this.review ? 6 : this.step + 1); },
            regions: JSON.parse(document.body.dataset.regions),
            tiers: [
                { name: 'Base', tag: 'Essentials', line: 'Explore more while keeping your travel spend in check.', items: ['Economical stays or homestays', 'Shared or value transport, if available', 'Essential sightseeing', 'Travel assistance'] },
                { name: 'Standard', tag: 'Comfort', line: 'A thoughtful balance of comfort, convenience and value.', items: ['Comfortable hotels', 'Improved transport options', 'Planned sightseeing', 'Meal options as listed'] },
                { name: 'Premium', tag: 'Signature', line: 'More privacy, added comfort and a personalised experience.', items: ['Premium stays or resorts', 'Private vehicle', 'Personalised itinerary', 'Priority trip assistance'] },
            ],
            f: { dests: [], pkg: '', tier: '', who: '', season: '', stay: '', date: '', days: '', people: '', budget: '', name: '', phone: '' },
            fmtShort(v) { return v ? new Date(v + 'T00:00').toLocaleDateString('en-IN', { day: 'numeric', month: 'short' }) : ''; },
            get endDate() { if (!this.f.date || !this.f.days) return ''; const d = new Date(this.f.date + 'T00:00'); d.setDate(d.getDate() + (+this.f.days) - 1); return iso(d); },
            bump(n) { this.f.people = Guard.people((+this.f.people || 0) + n); },
            fmtDate(v) { return v ? new Date(v + 'T00:00').toLocaleDateString('en-IN', { day: 'numeric', month: 'short', year: 'numeric' }) : ''; },
            get summary() {
                const f = this.f;
                return [
                    ...(this.wide ? [] : [{ step: 0, label: 'Experience', value: f.tier }]),
                    { step: 1, label: 'Destinations', value: f.dests.join(', ') || 'Not chosen' },
                    { step: 2, label: 'Traveller and season', value: `${f.who}, ${f.season}` },
                    { step: 3, label: 'Dates and group', value: `From ${this.fmtDate(f.date) || 'no date'}, ${f.days} days, ${f.people} traveller${f.people == 1 ? '' : 's'}` },
                    { step: 4, label: 'Budget and stay', value: `${f.budget ? '₹' + Number(f.budget).toLocaleString('en-IN') + ' per person' : 'Budget not set'}, ${f.stay}` },
                ];
            },
            // Region card pre-fills the destination; a package pre-fills the package name.
            pick(name, isPackage = false) {
                this.f.pkg = isPackage ? Guard.line(name, 60) : '';
                Object.assign(this.f, { tier: '', who: '', season: '', stay: '', date: '', days: '', people: '', budget: '', dests: !isPackage && Guard.DEST.includes(name) ? [name] : [] });
                this.step = 1; this.review = false; this.editing = false; this.mexp = true; this.mexpEdit = false;
                this.err = ''; this.buildErr = ''; this.errs = {};
                this.open = true; this.openedAt = Date.now();
            },
            toggleDest(d) {
                const on = this.f.dests.includes(d);
                this.f.dests = d === 'Not sure yet' ? (on ? [] : [d]) : (on ? this.f.dests.filter(x => x !== d) : [...this.f.dests.filter(x => x !== 'Not sure yet'), d]);
                this.buildErr = '';
            },
            close() { this.open = false; this.dy = 0; this.err = ''; this.buildErr = ''; this.errs = {}; },
            top() { this.$nextTick(() => this.$refs.build && this.$refs.build.scrollIntoView({ behavior: 'smooth', block: 'nearest' })); },
            edit(n) {
                this.buildErr = '';
                if (n === 0) { this.mexp = true; this.mexpEdit = true; this.scrollTop(); return; }
                this.review = false; this.editing = true; this.step = n; this.top();
            },
            scrollTop() { this.$nextTick(() => this.$refs.body && this.$refs.body.scrollTo({ top: 0, behavior: 'smooth' })); },
            // Small-screen wizard: experience, four build steps, then review and send.
            mnext() {
                this.err = '';
                if (this.mexp) { const e0 = this.check(0); if (e0) return this.err = e0; this.mexp = false; this.mexpEdit = false; return this.scrollTop(); }
                const e = this.check(this.step);
                if (e) return this.buildErr = e;
                this.buildErr = '';
                if (this.editing) { this.editing = false; this.review = true; }
                else if (this.step < 4) this.step++;
                else this.review = true;
                this.scrollTop();
            },
            mback() {
                this.err = ''; this.buildErr = '';
                if (this.mexp) { this.mexp = false; this.mexpEdit = false; }
                else if (this.review) { this.review = false; this.step = 4; }
                else if (this.editing) { this.editing = false; this.review = true; }
                else if (this.step > 1) this.step--;
                else this.mexp = true;
                this.scrollTop();
            },
            back() {
                this.buildErr = '';
                if (this.editing) { this.editing = false; this.review = true; } else this.step--;
            },
            // Each step checks only its own fields; allowlists are enforced again at send time.
            check(n) {
                const f = this.f; this.errs = {};
                if (n === 3) f.people = f.people === '' ? '' : Guard.people(f.people);
                const m = n === 0 ? (f.tier ? '' : 'Please choose an experience.') : this.missing(n);
                if (m) { const k = { 1: 'dests', 3: Guard.vDate(f.date) ? 'date' : 'misc', 4: f.budget !== '' && !f.stay ? 'misc' : 'budget' }[n]; this.errs[k || 'misc'] = m; }
                return m;
            },
            next() {
                const e = this.check(this.step);
                if (e) return this.buildErr = e;
                this.buildErr = '';
                if (this.editing) { this.editing = false; this.review = true; }
                else if (this.step < 4) this.step++;
                else this.review = true;
                this.top();
            },
            send() {
                const f = this.f;
                f.name = Guard.name(f.name).trim(); f.phone = Guard.phone(f.phone).trim();
                if (!this.review) {                                      // Enter pressed before the trip was saved: treat it as Next
                    if (!this.wide) return this.mnext();
                    this.err = 'Please finish and save your trip details first.';
                    return this.next();
                }
                const bad = [0, 1, 2, 3, 4].map(n => this.check(n)).find(Boolean)
                    || (![[Guard.TIER, f.tier], [Guard.WHO, f.who], [Guard.SEASON, f.season], [Guard.STAY, f.stay], [Guard.DAYS, +f.days]].every(([l, v]) => l.includes(v)) && 'Something looks wrong with your selection. Please reopen the form.');
                if (bad) return this.err = bad;
                this.errs = { name: Guard.vName(f.name), phone: Guard.vPhone(f.phone) };
                if (this.errs.name || this.errs.phone) return this.err = this.errs.name || this.errs.phone;
                this.err = '';
                if (this.busy) return;                                  // stop double-taps opening many tabs
                this.busy = true; setTimeout(() => this.busy = false, 3000);
                const lines = [
                    `Hi, I'm ${f.name} (${f.phone}). I'd like to plan a trip.`,
                    f.pkg && `Package: ${f.pkg}`,
                    `Destinations: ${f.dests.join(', ')}`,
                    `Experience: ${f.tier}`,
                    `Traveller: ${f.who}, ${f.people} traveller(s)`,
                    `Dates: from ${f.date}, ${f.days} days (${f.season})`,
                    f.budget && `Budget: about ₹${f.budget} per person`,
                    `Stay: ${f.stay}`,
                ].filter(Boolean).map(l => String(l).replace(/[\r\n]+/g, ' ')).join('\n');
                record('/enquiries', {
                    name: f.name, phone: f.phone, destinations: f.dests, tier: f.tier, traveller: f.who, season: f.season, stay: f.stay,
                    start_date: f.date, days: +f.days, people: +f.people, budget: f.budget === '' ? null : +f.budget, package: f.pkg || null,
                    elapsed: Date.now() - this.openedAt,
                });
                window.open('https://wa.me/' + document.body.dataset.wa + '?text=' + encodeURIComponent(lines), '_blank');
                this.close();
            },
        };
    }

    // Shared by both contact forms (desktop and phone).
    function contactForm(wa, phoneShown) {
        return {
            name: '', phone: '', msg: '', errs: {}, busy: false, toast: '', startedAt: Date.now(),
            say(t) { this.toast = t; setTimeout(() => this.toast = '', 2000); },
            check() {
                this.name = Guard.name(this.name).trim(); this.phone = Guard.phone(this.phone).trim(); this.msg = Guard.text(this.msg, 500).trim();
                this.errs = { name: Guard.vName(this.name), phone: Guard.vPhone(this.phone), msg: Guard.vMsg(this.msg) };
                return !Object.values(this.errs).some(Boolean);
            },
            send() {
                if (this.busy || !this.check()) return;
                this.busy = true; setTimeout(() => this.busy = false, 3000);
                this.say('Opening WhatsApp…');
                record('/contact-messages', { name: this.name, phone: this.phone, message: this.msg, elapsed: Date.now() - this.startedAt });
                window.open('https://wa.me/' + wa + '?text=' + encodeURIComponent(`Hi, I'm ${this.name} (${this.phone}). ${this.msg}`), '_blank');
            },
            copy() {
                const fallback = () => { const el = document.createElement('textarea'); el.value = phoneShown; el.style.position = 'fixed'; el.style.opacity = '0'; document.body.appendChild(el); el.select(); const ok = document.execCommand('copy'); el.remove(); this.say(ok ? 'Number copied' : 'Could not copy'); };
                if (navigator.clipboard && window.isSecureContext) { navigator.clipboard.writeText(phoneShown).then(() => this.say('Number copied'), fallback); } else { fallback(); }
            },
        };
    }

    // Hero photo mosaic: five tiles, one swaps to a new photo every few seconds with a slow crossfade.
    function mosaic(pool) {
        const n = 5;
        const still = matchMedia('(prefers-reduced-motion: reduce)').matches;
        const layer = i => ({ a: pool[i % pool.length], b: pool[i % pool.length], front: 'a' });
        return {
            tiles: Array.from({ length: n }, (_, i) => layer(i)),
            cursor: n % pool.length, turn: 0,
            init() { if (!still && pool.length > n) setInterval(() => this.swap(), 3400); },
            swap() {
                if (document.hidden) return;
                const shown = this.tiles.map(t => t[t.front].img);
                let next = null;
                for (let k = 0; k < pool.length; k++) {
                    const cand = pool[(this.cursor + k) % pool.length];
                    if (!shown.includes(cand.img)) { next = cand; this.cursor = (this.cursor + k + 1) % pool.length; break; }
                }
                if (!next) return;
                const tile = this.tiles[this.turn]; this.turn = (this.turn + 1) % n;
                const pre = new Image();
                pre.onload = () => { const back = tile.front === 'a' ? 'b' : 'a'; tile[back] = next; tile.front = back; };
                pre.src = next.img;
            },
        };
    }

    // Scroll motion. Elements get a gentle fade and rise as they enter the viewport.
    // Added by script only (nothing is hidden without JS), skipped for reduced motion,
    // and the classes are removed afterwards so hover and press effects are untouched.
    (() => {
        const header = document.querySelector('header');
        const bar = document.getElementById('scroll-progress');
        const onScroll = () => {
            const max = document.documentElement.scrollHeight - innerHeight;
            if (bar) bar.style.transform = 'scaleX(' + (max > 0 ? Math.min(1, scrollY / max) : 0) + ')';
            if (header) header.dataset.scrolled = scrollY > 8;
        };
        addEventListener('scroll', onScroll, { passive: true }); onScroll();

        const main = document.querySelector('main');
        if (!main || !('IntersectionObserver' in window) || matchMedia('(prefers-reduced-motion: reduce)').matches || !matchMedia('(min-width: 64rem)').matches) return; // phones skip the fade-in: no flash, no lag on long pages

        const skip = el => /^(A|BUTTON|SCRIPT|STYLE|TEMPLATE|NAV|FORM)$/.test(el.tagName) || el.hasAttribute('x-show') || el.hasAttribute(':class') || el.hasAttribute('x-cloak') || ['sticky', 'fixed'].includes(getComputedStyle(el).position);
        const targets = new Map(); // element -> stagger index
        main.querySelectorAll('section').forEach(sec => [...sec.children].forEach(c => { if (!skip(c)) targets.set(c, 0); }));
        main.querySelectorAll('section [class*="grid"]').forEach(g => {
            if (getComputedStyle(g).display !== 'grid') return;
            const items = [...g.children].filter(c => !skip(c));
            if (items.length < 2 || items.length > 12) return;
            targets.delete(g);
            items.forEach((c, i) => targets.set(c, i));
        });

        let observing = false;
        const settle = el => { el.classList.remove('reveal', 'is-in'); el.removeAttribute('data-reveal'); el.style.removeProperty('--d'); };
        const io = new IntersectionObserver(entries => entries.forEach(e => {
            observing = true;
            if (!e.isIntersecting) return;
            const el = e.target; io.unobserve(el);
            el.classList.add('is-in');
            setTimeout(() => settle(el), 1700);
        }), { threshold: 0, rootMargin: '0px 0px -8% 0px' });

        targets.forEach((i, el) => {
            el.classList.add('reveal');
            if (el.tagName === 'ARTICLE' || (el.querySelector('img') && /rounded-(3xl|\[2rem\])/.test(el.className))) el.dataset.reveal = 'scale';
            if (i) el.style.setProperty('--d', Math.min(i, 5) * 80 + 'ms');
            io.observe(el);
        });

        // Safety net: if observation never starts, or an element in view is still hidden, show everything.
        setTimeout(() => {
            if (!observing) { document.querySelectorAll('.reveal').forEach(settle); return; }
            document.querySelectorAll('.reveal:not(.is-in)').forEach(el => {
                const r = el.getBoundingClientRect();
                if (r.top < innerHeight && r.bottom > 0) el.classList.add('is-in');
            });
        }, 2500);
    })();
    

// Alpine reads these by name from the HTML (x-data="trip()", Guard.name(...)).
Object.assign(window, { Guard, trip, contactForm, mosaic });
