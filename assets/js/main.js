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
    const dotsWrap = slider.querySelector(".slider-dots");
    let index = 0;
    const show = (next) => {
      index = (next + slides.length) % slides.length;
      slides.forEach((s, i) => s.classList.toggle("is-active", i === index));
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
});
