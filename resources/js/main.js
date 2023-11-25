/**
 * Main
 */

'use strict';
import { Menu } from './menu';
import { Helpers } from './helpers';

let menu, animate;


(function () {
  // Initialize menu
  //-----------------

  let layoutMenuEl = document.querySelectorAll('#layout-menu');
  layoutMenuEl.forEach(function (element) {
    menu = new Menu(element, {
      orientation: 'vertical',
      closeChildren: false
    });
    // Change parameter to true if you want scroll animation
    Helpers.scrollToActive((animate = false));
    Helpers.mainMenu = menu;
  });

  // Initialize menu togglers and bind click on each
  let menuToggler = document.querySelectorAll('.layout-menu-toggle');
  menuToggler.forEach(item => {
    item.addEventListener('click', event => {
      event.preventDefault();
      Helpers.toggleCollapsed();
    });
  });

  // Display menu toggle (layout-menu-toggle) on hover with delay
  let delay = function (elem, callback) {
    let timeout = null;
    elem.onmouseenter = function () {
      // Set timeout to be a timer which will invoke callback after 300ms (not for small screen)
      if (!Helpers.isSmallScreen()) {
        timeout = setTimeout(callback, 300);
      } else {
        timeout = setTimeout(callback, 0);
      }
    };

    elem.onmouseleave = function () {
      // Clear any timers set to timeout
      document.querySelector('.layout-menu-toggle').classList.remove('d-block');
      clearTimeout(timeout);
    };
  };
  if (document.getElementById('layout-menu')) {
    delay(document.getElementById('layout-menu'), function () {
      // not for small screen
      if (!Helpers.isSmallScreen()) {
        document.querySelector('.layout-menu-toggle').classList.add('d-block');
      }
    });
  }

  // Display in main menu when menu scrolls
  let menuInnerContainer = document.getElementsByClassName('menu-inner'),
    menuInnerShadow = document.getElementsByClassName('menu-inner-shadow')[0];
  if (menuInnerContainer.length > 0 && menuInnerShadow) {
    menuInnerContainer[0].addEventListener('ps-scroll-y', function () {
      if (this.querySelector('.ps__thumb-y').offsetTop) {
        menuInnerShadow.style.display = 'block';
      } else {
        menuInnerShadow.style.display = 'none';
      }
    });
  }

  // Migrate to PHP auto nav active
  // Add active to selected link  
  // const navActiveLink = () => {
  //   let current_location = window.location.pathname;
  //   if (current_location === "") return;
  //   let menu_items = document.querySelector("#sidebar-nav").getElementsByTagName("a");

  //   for (let i = 0, len = menu_items.length; i < len; i++) {

  //     // if (menu_items[i].getAttribute("href").indexOf(current_location) !== -1) {
  //     if (current_location.indexOf(menu_items[i].getAttribute("href")) !== -1) {

  //       if(menu_items[i].parentNode.parentNode.className === "menu-sub") {
          
  //         // if sub menu
  //         menu_items[i].parentNode.parentNode.parentNode.classList.add("active");
  //         menu_items[i].parentNode.parentNode.parentNode.classList.add("open");

  //         // self active          
  //         menu_items[i].parentNode.classList.add("active");
  //       }else {
  //         // if menu
  //         menu_items[i].parentNode.classList.add("active");
  //       }
  //     }
  //   }
  // }

  // navActiveLink();
  

  // Theme Switcher
  let coreCss = document.getElementById('theme-core');
  let themeTheme = document.getElementById('theme-theme');
  let lightModeButton = document.getElementById('theme-light');
  let darkModeButton = document.getElementById('theme-dark');
  let systemModeButton = document.getElementById('theme-system');
  let themeIcon = document.getElementById('theme-icon');

  function setTheme(theme) {
    let core = "core";
    let themeCss = "theme-default";

    themeIcon.className = "bx bx-sm bx-sun";

    if(theme === 'dark') {
      core = "core-dark";
      themeCss = "theme-dark";
      
      themeIcon.className = "bx bx-sm bx-moon";
    }

    coreCss.href = `/css/${core}.css`;
    themeTheme.href = `/css/${themeCss}.css`;
    localStorage.setItem('theme', theme);
  }

  function setSystemTheme() {
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    setTheme(prefersDark ? 'dark' : 'light');
    
    themeIcon.className = "bx bx-sm bx-desktop";
  }

  lightModeButton.addEventListener('click', () => setTheme('light'));
  darkModeButton.addEventListener('click', () => setTheme('dark'));
  systemModeButton.addEventListener('click', setSystemTheme);

  // Check if the user has a previously selected theme in local storage
  const savedTheme = localStorage.getItem('theme');
  if (savedTheme) {
      setTheme(savedTheme);
  } else {
      setSystemTheme();
  }

  // Init helpers & misc
  // --------------------

  // Init BS Tooltip
  // const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  // tooltipTriggerList.map(function (tooltipTriggerEl) {
  //   return new bootstrap.Tooltip(tooltipTriggerEl);
  // });

  // Accordion active class
  const accordionActiveFunction = function (e) {
    if (e.type == 'show.bs.collapse' || e.type == 'show.bs.collapse') {
      e.target.closest('.accordion-item').classList.add('active');
    } else {
      e.target.closest('.accordion-item').classList.remove('active');
    }
  };

  const accordionTriggerList = [].slice.call(document.querySelectorAll('.accordion'));
  const accordionList = accordionTriggerList.map(function (accordionTriggerEl) {
    accordionTriggerEl.addEventListener('show.bs.collapse', accordionActiveFunction);
    accordionTriggerEl.addEventListener('hide.bs.collapse', accordionActiveFunction);
  });

  // Auto update layout based on screen size
  Helpers.setAutoUpdate(true);

  // Toggle Password Visibility
  Helpers.initPasswordToggle();

  // Speech To Text
  Helpers.initSpeechToText();

  // Manage menu expanded/collapsed with templateCustomizer & local storage
  //------------------------------------------------------------------

  // If current layout is horizontal OR current window screen is small (overlay menu) than return from here
  if (Helpers.isSmallScreen()) {
    return;
  }

  // If current layout is vertical and current window screen is > small

  // Auto update menu collapsed/expanded based on the themeConfig
  Helpers.setCollapsed(true, false);
})();
