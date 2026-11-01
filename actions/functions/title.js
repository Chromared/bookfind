//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared


// Optional title flashing helper — no longer auto-started so tab titles stay stable.
// Call startPageTitleFlashing() from a page to alternate between its title and "BookFind".
let pageTitle = document.title;
let pageTitleTimeout;

const startPageTitleFlashing = () => {
    pageTitleTimeout = setInterval(function () {
        document.title = document.title === pageTitle ? "BookFind" : pageTitle;
    }, 1500);
};