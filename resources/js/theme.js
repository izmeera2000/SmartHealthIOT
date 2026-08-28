/**
 * =======================================================
 * Template Name: EasyAdmin - Bootstrap Admin Template
 * Template URL: https://bootstrapmade.com/easy-admin-bootstrap-admin-html-template/
 * Updated: Mar 4, 2026
 * Author: BootstrapMade.com
 * License: https://bootstrapmade.com/license/
 * =======================================================
 */

/**
 * Theme JavaScript - Dark mode toggle and persistence
 * Default theme: DARK
 */
(function() {
  'use strict';

  const THEME_KEY = 'theme';
  const DARK_THEME = 'dark';
  const LIGHT_THEME = 'light';

  initTheme();
  document.addEventListener('DOMContentLoaded', initThemeToggle);

  function getStoredTheme() {
    try {
      return localStorage.getItem(THEME_KEY);
    } catch (_) {
      return null;
    }
  }

  function setStoredTheme(theme) {
    try {
      localStorage.setItem(THEME_KEY, theme);
    } catch (_) {
      // Ignore storage errors
    }
  }

  function setTheme(theme) {
    if (theme === DARK_THEME) {
      document.documentElement.setAttribute('data-theme', DARK_THEME);
    } else {
      document.documentElement.removeAttribute('data-theme');
    }
  }

  function getTheme() {
    return document.documentElement.getAttribute('data-theme') || DARK_THEME;
  }

  function initTheme() {
    const savedTheme = getStoredTheme();

    // Default to DARK mode when no preference has been saved
    if (savedTheme) {
      setTheme(savedTheme);
    } else {
      setTheme(DARK_THEME);
    }
  }

  function initThemeToggle() {
    document.querySelectorAll('.theme-toggle').forEach(function(toggle) {
      toggle.addEventListener('click', function(e) {
        e.preventDefault();

        const newTheme =
          getTheme() === DARK_THEME
            ? LIGHT_THEME
            : DARK_THEME;

        setTheme(newTheme);
        setStoredTheme(newTheme);
      });
    });
  }

  window.Theme = {
    toggle: function() {
      const newTheme =
        getTheme() === DARK_THEME
          ? LIGHT_THEME
          : DARK_THEME;

      setTheme(newTheme);
      setStoredTheme(newTheme);
    },

    setDark: function() {
      setTheme(DARK_THEME);
      setStoredTheme(DARK_THEME);
    },

    setLight: function() {
      setTheme(LIGHT_THEME);
      setStoredTheme(LIGHT_THEME);
    },

    isDark: function() {
      return getTheme() === DARK_THEME;
    },

    getTheme
  };

})();
