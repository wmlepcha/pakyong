<style>
    .rs { position: relative; overflow: hidden; background: var(--himalio-mist); border: 1px solid rgb(45 58 34 / .15); }
    .rs::before { content: ''; position: absolute; inset: 0; pointer-events: none; opacity: .7; background-image: linear-gradient(rgb(45 58 34 / .07) 1px, transparent 1px), linear-gradient(90deg, rgb(45 58 34 / .07) 1px, transparent 1px); background-size: 28px 28px; }
    .rs-body { position: relative; padding: 1.5rem 2rem 0; }
    .rs-road { position: relative; height: 6rem; }
    .rs-arch { position: absolute; inset: 12px 14px 14px; border-top: 3px dashed rgb(185 130 47 / .8); border-radius: 50% 50% 0 0 / 100% 100% 0 0; }
    .rs-car { position: absolute; left: 50%; top: 12px; transform: translate(-50%, -50%); display: grid; place-items: center; width: 2.25rem; height: 2.25rem; border-radius: 999px; background: var(--himalio-ink); color: #fff; }
    .rs-car-name { position: absolute; left: 50%; top: 34px; transform: translateX(-50%); font-size: 11px; font-weight: 600; white-space: nowrap; color: var(--himalio-green); }
    .rs-pin { position: absolute; bottom: 0; display: grid; place-items: center; width: 1.75rem; height: 1.75rem; }
    .rs-pin i { width: .65rem; height: .65rem; border-radius: 999px; background: #fff; }
    .rs-from { left: 0; border-radius: 999px; background: var(--himalio-gold); }
    .rs-to { right: 0; border-radius: 999px 999px 999px 0; transform: rotate(-45deg); background: var(--himalio-ink); }
    .rs-to i { transform: rotate(45deg); }
    .rs-ends { display: grid; grid-template-columns: 1fr 1fr; gap: 0 1rem; margin-top: .75rem; }
    .rs-label { font-size: 10px; letter-spacing: .14em; text-transform: uppercase; color: rgb(45 58 34 / .6); }
    .rs-place { margin: .1rem 0 0; font-family: var(--font-serif); font-size: 1.05rem; line-height: 1.3; color: var(--himalio-ink); }
    .rs-sub { margin: 0; font-size: 12px; color: rgb(45 58 34 / .6); }
    .rs-strip { position: relative; display: block; gap: 1rem; margin: 1.25rem -2rem 0; padding: .9rem 2rem; background: rgb(255 255 255 / .75); border-top: 1px solid rgb(45 58 34 / .1); }
    .rs-date { margin: .15rem 0 0; font-family: var(--font-serif); font-size: 1.6rem; line-height: 1.15; color: var(--himalio-green); }
    .rs-who { position: relative; display: flex; align-items: flex-end; flex-wrap: wrap; gap: .5rem 2.5rem; padding: .85rem 2rem; background: #fff; border-top: 1px solid rgb(45 58 34 / .1); }
    .rs-district { margin: 0 0 0 auto; font-size: 13px; color: rgb(45 58 34 / .7); }
    .rs-district strong { display: inline; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; }
    .rs-who strong { display: block; font-size: 14px; font-weight: 600; color: var(--himalio-ink); }
    @media (max-width: 640px) { .rs-body { padding: 1rem 1rem 0; } .rs-strip { margin: 1rem -1rem 0; padding: .75rem 1rem; } .rs-who { padding: .75rem 1rem; } .rs-date { font-size: 1.25rem; } }
</style>
