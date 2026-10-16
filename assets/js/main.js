document.addEventListener("DOMContentLoaded", () => {
  const toggle = document.querySelector(".nav-toggle");
  const nav = document.querySelector(".nav-main");
  if (toggle && nav) {
    toggle.addEventListener("click", () => nav.classList.toggle("is-open"));
  }

  document.querySelectorAll(".faq-item button").forEach((btn) => {
    btn.addEventListener("click", () => {
      btn.parentElement.classList.toggle("is-open");
    });
  });

  document.querySelectorAll("[data-amounts]").forEach((group) => {
    const buttons = group.querySelectorAll(".amount-btn");
    const hidden = group.querySelector("input[name='montant']");
    const custom = group.querySelector("input[name='montant_libre']");
    buttons.forEach((btn) => {
      btn.addEventListener("click", () => {
        buttons.forEach((b) => b.classList.remove("is-selected"));
        btn.classList.add("is-selected");
        if (hidden) hidden.value = btn.dataset.amount;
        if (custom) custom.value = "";
      });
    });
    if (custom) {
      custom.addEventListener("input", () => {
        buttons.forEach((b) => b.classList.remove("is-selected"));
        if (hidden) hidden.value = custom.value;
      });
    }
  });

  document.querySelectorAll("[data-continue]").forEach((btn) => {
    btn.addEventListener("click", (event) => {
      const target = document.querySelector(btn.dataset.continue);
      if (target && !target.classList.contains("is-open")) {
        event.preventDefault();
        target.classList.add("is-open");
        btn.textContent = btn.dataset.label || "Envoyer";
        btn.setAttribute("type", "submit");
      }
    });
  });

  const slider = document.querySelector(".hero-slider");
  if (slider) {
    const slides = [...slider.querySelectorAll(".slide")];
    const texts = [...slider.querySelectorAll("[data-slide-text]")];
    const dotsWrap = slider.querySelector(".slider-dots");
    let index = 0;
    const show = (next) => {
      index = (next + slides.length) % slides.length;
      slides.forEach((s, i) => s.classList.toggle("is-active", i === index));
      texts.forEach((t, i) => t.classList.toggle("is-active", i === index));
      dotsWrap?.querySelectorAll("button").forEach((d, i) => d.classList.toggle("is-active", i === index));
    };
    if (dotsWrap) {
      slides.forEach((_, i) => {
        const b = document.createElement("button");
        b.type = "button";
        b.setAttribute("aria-label", "Slide " + (i + 1));
        if (i === 0) b.classList.add("is-active");
        b.addEventListener("click", () => show(i));
        dotsWrap.appendChild(b);
      });
    }
    slider.querySelector(".slider-btn.prev")?.addEventListener("click", () => show(index - 1));
    slider.querySelector(".slider-btn.next")?.addEventListener("click", () => show(index + 1));
    setInterval(() => show(index + 1), 6500);
  }

  const alignProgramPhoto = () => {
    const photo = document.querySelector("#programmes .programs-photo");
    const cards = document.querySelectorAll("#programmes .program-item");
    if (!photo || cards.length < 2 || window.innerWidth <= 980) {
      if (photo) photo.style.height = "";
      return;
    }
    const target = cards[cards.length - 2];
    const top = photo.getBoundingClientRect().top + window.scrollY;
    const bottom = target.getBoundingClientRect().bottom + window.scrollY;
    photo.style.height = Math.max(280, Math.round(bottom - top)) + "px";
  };
  alignProgramPhoto();
  window.addEventListener("resize", alignProgramPhoto);
  window.addEventListener("load", alignProgramPhoto);

  const counters = document.querySelectorAll("[data-count]");
  if (counters.length) {
    const play = (el) => {
      const end = parseInt(el.dataset.count, 10);
      const suffix = el.dataset.suffix || "";
      const duration = 1100;
      const start = performance.now();
      const tick = (now) => {
        const p = Math.min(1, (now - start) / duration);
        const eased = 1 - Math.pow(1 - p, 3);
        el.textContent = Math.round(end * eased) + suffix;
        if (p < 1) requestAnimationFrame(tick);
      };
      requestAnimationFrame(tick);
    };
    const io = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          play(entry.target);
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.4 });
    counters.forEach((el) => io.observe(el));
  }

  document.querySelectorAll("[data-filter-group]").forEach((group) => {
    const buttons = group.querySelectorAll("[data-filter]");
    const scope = group.closest("section") || document;
    const cards = scope.querySelectorAll("[data-category]");
    buttons.forEach((btn) => {
      btn.addEventListener("click", () => {
        buttons.forEach((b) => b.classList.remove("is-active"));
        btn.classList.add("is-active");
        const value = btn.dataset.filter;
        cards.forEach((card) => {
          card.style.display = value === "all" || card.dataset.category === value ? "" : "none";
        });
      });
    });
  });

  document.querySelectorAll("[data-accordion]").forEach((accordion) => {
    const items = [...accordion.querySelectorAll(".ab-acc-item")];
    const images = accordion.closest("section")?.querySelectorAll(".ab-mission-img") || [];
    items.forEach((item, i) => {
      item.querySelector(".ab-acc-btn").addEventListener("click", () => {
        items.forEach((other, j) => {
          other.classList.toggle("is-active", i === j);
          other.querySelector(".ab-acc-btn").setAttribute("aria-expanded", String(i === j));
        });
        images.forEach((img, j) => img.classList.toggle("is-active", i === j));
      });
    });
  });

  document.querySelectorAll("[data-phases]").forEach((wrap) => {
    const phases = [...wrap.querySelectorAll(".ab-phase")];
    const images = [...wrap.querySelectorAll(".ab-phase-bg")];
    const activate = (i) => {
      phases.forEach((p, j) => p.classList.toggle("is-active", i === j));
      images.forEach((img, j) => img.classList.toggle("is-active", i === j));
    };
    phases.forEach((phase, i) => {
      phase.addEventListener("mouseenter", () => activate(i));
      phase.addEventListener("focus", () => activate(i));
      phase.addEventListener("click", () => activate(i));
    });
  });

  document.querySelectorAll("[data-slider]").forEach((slider) => {
    const track = slider.querySelector(".ab-slider-track");
    const count = track ? track.children.length : 0;
    if (!count) return;
    let index = 0;
    const go = (next) => {
      index = (next + count) % count;
      track.style.transform = `translateX(-${index * 100}%)`;
    };
    slider.querySelector("[data-prev]")?.addEventListener("click", () => go(index - 1));
    slider.querySelector("[data-next]")?.addEventListener("click", () => go(index + 1));
  });

  document.querySelectorAll("[data-carousel]").forEach((track) => {
    const wrap = track.parentElement;
    const step = () => {
      const card = track.firstElementChild;
      const gap = parseFloat(getComputedStyle(track).columnGap) || 0;
      return card ? card.getBoundingClientRect().width + gap : track.clientWidth;
    };
    wrap.querySelector("[data-carousel-prev]")?.addEventListener("click", () => track.scrollBy({ left: -step(), behavior: "smooth" }));
    wrap.querySelector("[data-carousel-next]")?.addEventListener("click", () => track.scrollBy({ left: step(), behavior: "smooth" }));
  });

  const reveals = document.querySelectorAll("[data-reveal]");
  if (reveals.length) {
    if (!("IntersectionObserver" in window)) {
      reveals.forEach((el) => el.classList.add("is-visible"));
    } else {
      const revealIo = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add("is-visible");
            revealIo.unobserve(entry.target);
          }
        });
      }, { threshold: 0.15, rootMargin: "0px 0px -40px 0px" });
      reveals.forEach((el) => revealIo.observe(el));
    }
  }
});
