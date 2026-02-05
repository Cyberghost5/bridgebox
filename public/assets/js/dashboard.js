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

        const clearTimer = () => {
            if (timeoutId) {
                window.clearTimeout(timeoutId);
                timeoutId = null;
            }
            alert.classList.remove('is-fading');
        };

        const hideAlert = () => {
            clearTimer();
            alert.classList.add('is-fading');
            window.setTimeout(() => {
                alert.hidden = true;
                alert.classList.remove('is-fading');
            }, 350);
        };

        const schedule = () => {
            clearTimer();
            if (alert.hidden) {
                return;
            }
            const delay = Number.parseInt(alert.dataset.autoDismiss || '0', 10);
            if (delay > 0) {
                timeoutId = window.setTimeout(hideAlert, delay);
            }
        };

        if (closeButton) {
            closeButton.addEventListener('click', hideAlert);
        }

        alert.addEventListener('alert:show', schedule);

        if (!alert.hidden) {
            schedule();
        }
    });
};

document.addEventListener('DOMContentLoaded', () => {
    setBarAnimations();
    setMeterAnimations();
    enableNavHover();
    enableConfirmations();
    enableAlerts();
});

