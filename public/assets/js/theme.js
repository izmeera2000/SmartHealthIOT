 

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
      // Ignore storage errors (e.g., privacy mode)
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
    // Default to DARK
    return document.documentElement.getAttribute('data-theme') || DARK_THEME;
  }

  function initTheme() {
    const savedTheme = getStoredTheme();

    if (savedTheme) {
      setTheme(savedTheme);
    } else {
      // Default to dark instead of using system preference
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