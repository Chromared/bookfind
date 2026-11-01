// BookFind — lightweight UI behaviors (no framework).
// Event delegation on document so it works regardless of load order.
(function () {
  "use strict";

  function closeOtherDropdowns(current) {
    document.querySelectorAll(".dropdown.is-open").forEach(function (dd) {
      if (dd !== current) dd.classList.remove("is-open");
    });
  }

  // Global click handling: nav toggle, dropdowns, tabs, modals.
  document.addEventListener("click", function (e) {
    // --- Navbar / sidebar mobile toggle ---
    var navToggle = e.target.closest("[data-nav-toggle]");
    if (navToggle) {
      var target = document.getElementById(navToggle.getAttribute("data-nav-toggle"));
      if (target) {
        var open = target.classList.toggle("is-open");
        navToggle.setAttribute("aria-expanded", open ? "true" : "false");
        var backdrop = document.querySelector(".sidebar__backdrop");
        if (backdrop) backdrop.classList.toggle("is-open", open);
        document.body.classList.toggle("nav-open", open);
      }
      return;
    }

    // --- Sidebar backdrop click closes it ---
    if (e.target.closest("[data-sidebar-close]")) {
      var sb = document.getElementById("sidebar");
      if (sb) sb.classList.remove("is-open");
      var bd = document.querySelector(".sidebar__backdrop");
      if (bd) bd.classList.remove("is-open");
      document.body.classList.remove("nav-open");
      return;
    }

    // --- Dropdowns ---
    var ddToggle = e.target.closest("[data-dropdown-toggle]");
    if (ddToggle) {
      e.preventDefault();
      var dd = ddToggle.closest(".dropdown");
      if (dd) {
        var isOpen = dd.classList.toggle("is-open");
        closeOtherDropdowns(dd);
        ddToggle.setAttribute("aria-expanded", isOpen ? "true" : "false");
      }
      return;
    }

    // --- Tabs ---
    var tab = e.target.closest("[data-tab]");
    if (tab) {
      if (tab.disabled) return;
      var group = tab.closest(".tabs");
      var pane = document.getElementById(tab.getAttribute("data-tab"));
      if (!group || !pane) return;
      group.querySelectorAll("[data-tab]").forEach(function (t) {
        t.classList.toggle("is-active", t === tab);
        t.setAttribute("aria-selected", t === tab ? "true" : "false");
      });
      var block = group.closest(".tabs-block");
      if (block) {
        block.querySelectorAll(".tab-pane").forEach(function (p) {
          p.classList.toggle("is-active", p === pane);
        });
      }
      return;
    }

    // --- Modals ---
    var opener = e.target.closest("[data-modal-open]");
    if (opener) {
      var modal = document.getElementById(opener.getAttribute("data-modal-open"));
      if (modal) openModal(modal);
      return;
    }
    var closer = e.target.closest("[data-modal-close]");
    if (closer) {
      var m = closer.closest(".modal");
      if (m) closeModal(m);
      return;
    }
    var backdrop = e.target.closest(".modal__backdrop");
    if (backdrop && e.target === backdrop) {
      closeModal(backdrop.closest(".modal"));
      return;
    }

    // Close dropdowns when clicking elsewhere
    closeOtherDropdowns(null);
  });

  function openModal(m) {
    m.classList.add("is-open");
    document.body.classList.add("modal-open");
    var focusEl = m.querySelector("[data-autofocus]") || m.querySelector("button, input, a");
    if (focusEl) focusEl.focus();
  }
  function closeModal(m) {
    if (!m) return;
    m.classList.remove("is-open");
    document.body.classList.remove("modal-open");
  }

  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") {
      document.querySelectorAll(".modal.is-open").forEach(closeModal);
      closeOtherDropdowns(null);
    }
  });

  // --- Searchable select (input filters the options of a sibling select) ---
  document.addEventListener("input", function (e) {
    var input = e.target.closest("[data-select-search]");
    if (!input) return;
    var wrap = input.closest(".select-search");
    if (!wrap) return;
    var select = wrap.querySelector("select");
    if (!select) return;
    var q = input.value.trim().toLowerCase();
    Array.prototype.forEach.call(select.options, function (opt) {
      if (opt.value === "") return; // keep the placeholder option visible
      opt.hidden = opt.textContent.toLowerCase().indexOf(q) === -1;
    });
  });
})();
