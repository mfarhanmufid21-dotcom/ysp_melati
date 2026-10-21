<script>
(function () {
    var els = document.querySelectorAll('.mf-reveal');
    if (!('IntersectionObserver' in window)) { els.forEach(function (e) { e.classList.add('visible'); }); return; }
    var io = new IntersectionObserver(function (en) {
        en.forEach(function (x) { if (x.isIntersecting) { x.target.classList.add('visible'); io.unobserve(x.target); } });
    }, { threshold: 0.1 });
    els.forEach(function (e) { io.observe(e); });
})();
</script>
