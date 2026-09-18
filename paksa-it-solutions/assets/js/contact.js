(function () {
    'use strict';

    /* ── Interest selector ── */
    document.querySelectorAll('.pk-contact-interest-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            this.classList.toggle('is-active');
            var active = Array.from(document.querySelectorAll('.pk-contact-interest-btn.is-active'))
                .map(function (b) { return b.dataset.value; }).join(', ');
            var hidden = document.getElementById('pk-cf-interests-val');
            if (hidden) hidden.value = active;
        });
    });

    /* ── Budget slider ── */
    var range = document.getElementById('pk-cf-budget');
    var display = document.getElementById('pk-cf-budget-display');
    if (range && display) {
        function updateBudget() {
            var v = parseInt(range.value, 10);
            display.textContent = v >= 100000 ? '$100k+' : '$' + v.toLocaleString();
            var pct = ((v - range.min) / (range.max - range.min)) * 100;
            range.style.background = 'linear-gradient(to right, #6192F8 ' + pct + '%, #e2e8f0 ' + pct + '%)';
        }
        range.addEventListener('input', updateBudget);
        updateBudget();
    }

    /* ── AJAX form submit ── */
    var form = document.getElementById('pk-contact-form');
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            var btn = form.querySelector('.pk-cf-submit');
            var successNotice = document.getElementById('pk-cf-success');
            var errorNotice = document.getElementById('pk-cf-error');

            /* Honeypot check */
            if (form.querySelector('[name="pk_hp"]') && form.querySelector('[name="pk_hp"]').value) return;

            btn.classList.add('is-loading');
            btn.disabled = true;
            successNotice.classList.remove('is-visible');
            errorNotice.classList.remove('is-visible');

            var data = new FormData(form);
            data.append('action', 'paksa_contact_submit');
            data.append('nonce', (window.paksaContact && window.paksaContact.nonce) || '');

            fetch((window.paksaContact && window.paksaContact.ajaxUrl) || '/wp-admin/admin-ajax.php', {
                method: 'POST',
                body: data,
            })
            .then(function (r) { return r.json(); })
            .then(function (res) {
                btn.classList.remove('is-loading');
                btn.disabled = false;
                if (res.success) {
                    successNotice.classList.add('is-visible');
                    form.reset();
                    document.querySelectorAll('.pk-contact-interest-btn').forEach(function (b) {
                        b.classList.remove('is-active');
                    });
                    if (range) { range.value = range.min; updateBudget && updateBudget(); }
                } else {
                    errorNotice.classList.add('is-visible');
                }
            })
            .catch(function () {
                btn.classList.remove('is-loading');
                btn.disabled = false;
                errorNotice.classList.add('is-visible');
            });
        });
    }

    /* ── Scroll animations ── */
    if (!window.IntersectionObserver) return;
    var obs = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                var el = entry.target;
                var delay = el.dataset.delay ? parseInt(el.dataset.delay, 10) : 0;
                setTimeout(function () { el.classList.add('is-visible'); }, delay);
                obs.unobserve(el);
            }
        });
    }, { threshold: 0.1 });
    document.querySelectorAll('.pk-ct-fade').forEach(function (el) { obs.observe(el); });
}());
