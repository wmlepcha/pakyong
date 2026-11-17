// Animation for the 404 page. Everything is visible without JavaScript; GSAP only adds the motion.
import gsap from 'gsap';

const root = document.querySelector('[data-lost]');

if (root && !matchMedia('(prefers-reduced-motion: reduce)').matches) {
    const q = (s) => root.querySelectorAll(s);

    // Entrance: digits drop in, the zero rolls in like a loose boulder, text and buttons follow.
    const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });
    tl.from(q('[data-digit]'), { y: -220, opacity: 0, duration: 0.9, ease: 'bounce.out', stagger: 0.12 })
        .from('[data-rock]', { x: () => innerWidth * 0.7, rotation: 540, duration: 1.4, ease: 'power3.out' }, 0.1)
        .to('[data-rock]', { rotation: '+=14', duration: 0.18, yoyo: true, repeat: 3, ease: 'sine.inOut' }, '>-0.2')
        .from(q('[data-line]'), { y: 24, opacity: 0, duration: 0.7, stagger: 0.12 }, '-=0.6')
        .from(q('[data-cta] > *'), { y: 16, opacity: 0, duration: 0.5, stagger: 0.08 }, '-=0.3');

    // Prayer flags sway in a slow wave.
    gsap.to(q('[data-flag]'), { rotation: 9, transformOrigin: '50% 0', duration: 1.6, ease: 'sine.inOut', yoyo: true, repeat: -1, stagger: { each: 0.18, from: 'start' } });

    // Clouds drift across and wrap around.
    q('[data-cloud]').forEach((el, i) => {
        gsap.fromTo(el, { x: -el.offsetWidth }, { x: () => innerWidth, duration: 48 + i * 14, ease: 'none', repeat: -1, delay: -i * 18 });
    });

    // The zero wobbles if you poke it.
    const rock = root.querySelector('[data-rock]');
    rock?.addEventListener('pointerenter', () => gsap.fromTo(rock, { rotation: 0 }, { rotation: 360, duration: 0.9, ease: 'back.out(1.6)' }));
}
