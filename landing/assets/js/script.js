        const menuToggle = document.getElementById('menuToggle');
        const mobileNav = document.getElementById('mobile-nav');

        if (menuToggle && mobileNav) {
            menuToggle.addEventListener('click', () => {
                const isOpen = mobileNav.classList.toggle('open');
                menuToggle.setAttribute('aria-expanded', String(isOpen));
            });

            mobileNav.querySelectorAll('a').forEach((link) => {
                link.addEventListener('click', () => {
                    mobileNav.classList.remove('open');
                    menuToggle.setAttribute('aria-expanded', 'false');
                });
            });
        }

        const revealItems = document.querySelectorAll('.reveal');
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries, obs) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        obs.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12 });

            revealItems.forEach((el) => observer.observe(el));
        } else {
            revealItems.forEach((el) => el.classList.add('is-visible'));
        }