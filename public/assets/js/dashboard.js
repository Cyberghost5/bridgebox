const setBarAnimations = () => {
    const bars = document.querySelectorAll('.bar');
    bars.forEach((bar, index) => {
        const value = Number.parseInt(bar.dataset.value || '0', 10);
        const scale = Math.max(0, Math.min(value, 100)) / 100;
        bar.style.setProperty('--bar-scale', scale.toString());
        setTimeout(() => {
            bar.classList.add('is-ready');
        }, 200 + index * 110);
    });
};

const setMeterAnimations = () => {
    const meters = document.querySelectorAll('.meter-fill');
    meters.forEach((meter, index) => {
        const value = Number.parseInt(meter.dataset.progress || '0', 10);
        setTimeout(() => {
            meter.style.width = `${Math.max(0, Math.min(value, 100))}%`;
        }, 250 + index * 120);
    });
};

const enableNavHover = () => {
    const items = document.querySelectorAll('.nav-item');
    items.forEach((item) => {
        item.addEventListener('click', () => {
            items.forEach((other) => other.classList.remove('active'));
            item.classList.add('active');
        });
    });
};

const enableConfirmations = () => {
    const forms = document.querySelectorAll('form[data-confirm]');
    forms.forEach((form) => {
        form.addEventListener('submit', (event) => {
            const message = form.getAttribute('data-confirm');
            if (message && !window.confirm(message)) {
                event.preventDefault();
            }
        });
    });
};

const enableAlerts = () => {
    const alerts = document.querySelectorAll('.alert[data-auto-dismiss]');
    alerts.forEach((alert) => {
        let timeoutId = null;
        const closeButton = alert.querySelector('[data-alert-close]');
        const bsClose = alert.querySelector('[data-bs-dismiss="alert"]');

        const clearTimer = () => {
            if (timeoutId !== null) {
                window.clearTimeout(timeoutId);
                timeoutId = null;
            }
            alert.classList.remove('is-fading');
        };

        const hideAlert = () => {
            clearTimer();
            alert.classList.add('is-fading');
            window.setTimeout(() => {
                try {
                    alert.hidden = true;
                } catch (e) {
                    // ignore
                }
                alert.classList.remove('is-fading');
            }, 350);
        };

        const schedule = () => {
            clearTimer();

            // If element is not visible, don't schedule.
            const isHiddenAttr = alert.hidden === true;
            const computed = window.getComputedStyle ? window.getComputedStyle(alert) : null;
            const isDisplayNone = computed ? computed.display === 'none' : false;
            if (isHiddenAttr || isDisplayNone) {
                return;
            }

            // Prefer explicit attribute read to avoid possible dataset camelCase issues.
            const raw = alert.getAttribute('data-auto-dismiss');
            const delay = Number.parseInt(String(raw || '0').trim(), 10);
            if (delay > 0) {
                timeoutId = window.setTimeout(hideAlert, delay);
            }
        };

        if (closeButton) {
            closeButton.addEventListener('click', hideAlert);
        }
        if (bsClose) {
            bsClose.addEventListener('click', hideAlert);
        }

        alert.addEventListener('alert:show', schedule);

        // Try to schedule now if element is visible.
        schedule();
    });
};

const enableRealtimeFilters = () => {
    const forms = document.querySelectorAll('form.search-form');
    forms.forEach((form) => {
        const textInputs = form.querySelectorAll('input[type="text"], input[type="search"]');
        const selects = form.querySelectorAll('select');

        const submitForm = () => {
            if (typeof form.requestSubmit === 'function') {
                form.requestSubmit();
            } else {
                form.submit();
            }
        };

        textInputs.forEach((input) => {
            let timeoutId = null;
            let lastValue = input.value;
            const handler = () => {
                if (timeoutId !== null) {
                    window.clearTimeout(timeoutId);
                }
                timeoutId = window.setTimeout(() => {
                    if (input.value === lastValue) {
                        return;
                    }
                    lastValue = input.value;
                    submitForm();
                }, 350);
            };

            input.addEventListener('input', handler);
            input.addEventListener('search', handler);
        });

        selects.forEach((select) => {
            select.addEventListener('change', submitForm);
        });
    });
};

const enableRowLinks = () => {
    const rows = document.querySelectorAll('tr[data-row-href]');
    rows.forEach((row) => {
        const href = row.getAttribute('data-row-href');
        if (!href) {
            return;
        }

        const navigate = () => {
            window.location.href = href;
        };

        row.addEventListener('click', (event) => {
            const interactive = event.target.closest('a,button,form,input,select,textarea,label');
            if (interactive) {
                return;
            }
            navigate();
        });

        row.addEventListener('keydown', (event) => {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                navigate();
            }
        });
    });
};

document.addEventListener('DOMContentLoaded', () => {
    setBarAnimations();
    setMeterAnimations();
    enableNavHover();
    enableConfirmations();
    enableAlerts();
    enableRealtimeFilters();
    enableRowLinks();
});
