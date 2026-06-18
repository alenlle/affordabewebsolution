/**
 * Affordable Web Solution Theme - Main JavaScript
 * Handles: sticky header, mobile nav, FAQ accordion, scroll reveal, contact form AJAX, smooth scroll
 */

(function () {
  'use strict';

  /* ============================================================
     STICKY HEADER SCROLL BEHAVIOR
     ============================================================ */
  const header = document.getElementById('site-header');

  function handleHeaderScroll() {
    if (!header) return;
    if (window.scrollY > 60) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }
  }

  window.addEventListener('scroll', handleHeaderScroll, { passive: true });
  handleHeaderScroll(); // run on load

  /* ============================================================
     MOBILE NAV TOGGLE
     ============================================================ */
  const hamburger  = document.getElementById('hamburger');
  const mobileNav  = document.getElementById('mobile-nav');
  let   navOpen    = false;

  function openNav() {
    navOpen = true;
    hamburger.classList.add('open');
    hamburger.setAttribute('aria-expanded', 'true');
    mobileNav.classList.add('open');
    mobileNav.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
  }

  function closeNav() {
    navOpen = false;
    hamburger.classList.remove('open');
    hamburger.setAttribute('aria-expanded', 'false');
    mobileNav.classList.remove('open');
    mobileNav.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
  }

  if (hamburger && mobileNav) {
    hamburger.addEventListener('click', function () {
      navOpen ? closeNav() : openNav();
    });

    // Close on escape key
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && navOpen) closeNav();
    });

    // Close when a mobile nav link is clicked
    mobileNav.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', closeNav);
    });
  }

  /* ============================================================
     FAQ ACCORDION
     ============================================================ */
  window.awsToggleFaq = function (btn) {
    const faqItem = btn.closest('.faq-item');
    const answer  = faqItem.querySelector('.faq-answer');
    const icon    = faqItem.querySelector('.faq-icon');
    const isOpen  = faqItem.classList.contains('open');

    // Close all other open items
    document.querySelectorAll('.faq-item.open').forEach(function (item) {
      if (item !== faqItem) {
        item.classList.remove('open');
        item.querySelector('.faq-question').setAttribute('aria-expanded', 'false');
      }
    });

    // Toggle current
    if (isOpen) {
      faqItem.classList.remove('open');
      btn.setAttribute('aria-expanded', 'false');
    } else {
      faqItem.classList.add('open');
      btn.setAttribute('aria-expanded', 'true');
    }
  };

  // Support keyboard navigation on FAQ
  document.querySelectorAll('.faq-question').forEach(function (btn) {
    btn.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        awsToggleFaq(btn);
      }
    });
  });

  /* ============================================================
     SCROLL REVEAL ANIMATION
     ============================================================ */
  const revealEls = document.querySelectorAll('.reveal');

  if (revealEls.length > 0 && 'IntersectionObserver' in window) {
    const revealObserver = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            revealObserver.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
    );

    revealEls.forEach(function (el) {
      revealObserver.observe(el);
    });
  } else {
    // Fallback: show all immediately
    revealEls.forEach(function (el) {
      el.classList.add('visible');
    });
  }

  /* ============================================================
     SMOOTH SCROLL FOR ANCHOR LINKS
     ============================================================ */
  document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
    anchor.addEventListener('click', function (e) {
      const targetId = this.getAttribute('href').slice(1);
      if (!targetId) return;

      const target = document.getElementById(targetId);
      if (!target) return;

      e.preventDefault();
      const headerH = header ? header.offsetHeight + 20 : 80;
      const top     = target.getBoundingClientRect().top + window.scrollY - headerH;

      window.scrollTo({ top: top, behavior: 'smooth' });
    });
  });

  /* ============================================================
     CONTACT FORM AJAX SUBMISSION
     ============================================================ */
  const contactForm   = document.getElementById('aws-contact-form');
  const formSuccess   = document.getElementById('form-success');
  const formError     = document.getElementById('form-error');
  const submitBtn     = document.getElementById('contact-submit');
  const submitText    = document.getElementById('submit-text');

  if (contactForm) {
    contactForm.addEventListener('submit', function (e) {
      e.preventDefault();

      // Reset messages
      if (formSuccess) { formSuccess.style.display = 'none'; formSuccess.textContent = ''; }
      if (formError)   { formError.style.display   = 'none'; formError.textContent   = ''; }

      // Basic validation
      const name    = contactForm.querySelector('[name="name"]').value.trim();
      const email   = contactForm.querySelector('[name="email"]').value.trim();
      const message = contactForm.querySelector('[name="message"]').value.trim();

      if (!name || !email || !message) {
        showFormError('Please fill in all required fields.');
        return;
      }

      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(email)) {
        showFormError('Please enter a valid email address.');
        return;
      }

      // Set loading state
      if (submitBtn)  submitBtn.disabled = true;
      if (submitText) submitText.textContent = 'Sending…';

      // Build form data
      const formData = new FormData(contactForm);
      formData.append('action', 'nexagen_contact');

      // Add nonce if available
      const nonceField = contactForm.querySelector('[name="nexagen_nonce"]');
      if (nonceField) {
        formData.set('nonce', nonceField.value);
      } else if (window.awsData && window.awsData.nonce) {
        formData.append('nonce', window.awsData.nonce);
      }

      const ajaxUrl = (window.awsData && window.awsData.ajaxUrl)
        ? window.awsData.ajaxUrl
        : '/wp-admin/admin-ajax.php';

      fetch(ajaxUrl, {
        method:  'POST',
        body:    formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
      })
        .then(function (res) {
          if (!res.ok) throw new Error('Network error: ' + res.status);
          return res.json();
        })
        .then(function (data) {
          if (data.success) {
            showFormSuccess(data.data.message || 'Your message has been sent! We\'ll be in touch within 24 hours.');
            contactForm.reset();
          } else {
            showFormError(data.data.message || 'Something went wrong. Please try again.');
          }
        })
        .catch(function (err) {
          console.error('Contact form error:', err);
          showFormError('An unexpected error occurred. Please call us directly or try again later.');
        })
        .finally(function () {
          if (submitBtn)  submitBtn.disabled = false;
          if (submitText) submitText.textContent = 'Send Message';
        });
    });
  }

  function showFormSuccess(msg) {
    if (!formSuccess) return;
    formSuccess.textContent = '✓ ' + msg;
    formSuccess.style.display = 'block';
    formSuccess.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
  }

  function showFormError(msg) {
    if (!formError) return;
    formError.textContent = '⚠ ' + msg;
    formError.style.display = 'block';
    formError.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
  }

  /* ============================================================
     ACTIVE NAV LINK HIGHLIGHTING
     ============================================================ */
  const currentPath = window.location.pathname;
  document.querySelectorAll('.nav-link, .mobile-nav-link').forEach(function (link) {
    const href = link.getAttribute('href') || '';
    if (href && href !== '/' && currentPath.startsWith(href)) {
      link.classList.add('active');
    }
  });

  /* ============================================================
     HEADER DROPDOWN KEYBOARD NAVIGATION
     ============================================================ */
  document.querySelectorAll('.nav-item').forEach(function (item) {
    const link     = item.querySelector('.nav-link');
    const dropdown = item.querySelector('.dropdown');
    if (!link || !dropdown) return;

    link.addEventListener('focus', function () {
      dropdown.style.opacity    = '1';
      dropdown.style.visibility = 'visible';
      dropdown.style.transform  = 'translateX(-50%) translateY(0)';
      dropdown.style.pointerEvents = 'all';
    });

    item.addEventListener('focusout', function (e) {
      if (!item.contains(e.relatedTarget)) {
        dropdown.style.opacity    = '';
        dropdown.style.visibility = '';
        dropdown.style.transform  = '';
        dropdown.style.pointerEvents = '';
      }
    });
  });

  /* ============================================================
     ANIMATE HERO STATS COUNTER (optional enhancement)
     ============================================================ */
  function animateCounter(el, target, duration) {
    const startTime = performance.now();
    const isDecimal = String(target).includes('.');

    function update(currentTime) {
      const elapsed  = currentTime - startTime;
      const progress = Math.min(elapsed / duration, 1);
      const eased    = 1 - Math.pow(1 - progress, 3); // ease-out cubic
      const current  = Math.round(eased * target);

      el.textContent = current.toLocaleString() + (el.dataset.suffix || '');

      if (progress < 1) requestAnimationFrame(update);
    }

    requestAnimationFrame(update);
  }

  // Run counter animation when stats come into view
  const statValues = document.querySelectorAll('.stat-value');
  if (statValues.length > 0 && 'IntersectionObserver' in window) {
    const counterObserver = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            const el       = entry.target;
            const rawText  = el.textContent;
            const numMatch = rawText.match(/[\d,]+/);
            if (numMatch) {
              const target = parseInt(numMatch[0].replace(/,/g, ''), 10);
              const suffix = rawText.replace(/[\d,]/g, '').trim();
              el.dataset.suffix = suffix;
              animateCounter(el, target, 1500);
            }
            counterObserver.unobserve(el);
          }
        });
      },
      { threshold: 0.5 }
    );

    statValues.forEach(function (el) {
      counterObserver.observe(el);
    });
  }

  /* ============================================================
     SERVICE CARDS STAGGER ANIMATION ON LOAD
     ============================================================ */
  const serviceCards = document.querySelectorAll('.service-card');
  serviceCards.forEach(function (card, i) {
    card.style.animationDelay = (i * 0.08) + 's';
    card.classList.add('reveal');
  });

  /* ============================================================
     BACK TO TOP (inject if needed)
     ============================================================ */
  const bttBtn = document.createElement('button');
  bttBtn.setAttribute('aria-label', 'Back to top');
  bttBtn.innerHTML = '↑';
  bttBtn.style.cssText = [
    'position:fixed', 'bottom:2rem', 'right:2rem', 'z-index:900',
    'width:44px', 'height:44px', 'border-radius:50%',
    'background:var(--color-primary)', 'color:var(--color-white)',
    'font-size:1.25rem', 'font-weight:700',
    'border:none', 'cursor:pointer',
    'display:flex', 'align-items:center', 'justify-content:center',
    'box-shadow:0 4px 16px rgba(16,81,42,0.3)',
    'opacity:0', 'transform:translateY(10px)',
    'transition:opacity 0.3s,transform 0.3s',
    'pointer-events:none',
  ].join(';');

  document.body.appendChild(bttBtn);

  window.addEventListener('scroll', function () {
    if (window.scrollY > 400) {
      bttBtn.style.opacity       = '1';
      bttBtn.style.transform     = 'translateY(0)';
      bttBtn.style.pointerEvents = 'all';
    } else {
      bttBtn.style.opacity       = '0';
      bttBtn.style.transform     = 'translateY(10px)';
      bttBtn.style.pointerEvents = 'none';
    }
  }, { passive: true });

  bttBtn.addEventListener('click', function () {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });

  // Mark body as reveal-ready after JS loads
  document.body.classList.add('reveal-ready');

})();