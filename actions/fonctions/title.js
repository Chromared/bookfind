// This file belongs to the Bookfind project.
//
// Bookfind is distributed under the terms of the MIT software license.
//
// Copyright (C) 2024 Chromared


let pageTitle = document.title;
let pageTitleTimeout;

const startPageTitleFlashing = () => {
    pageTitleTimeout = setInterval(function () {
        document.title = document.title === pageTitle ? "Bookfind" : pageTitle;
    }, 1500);
};

window.addEventListener("load",
startPageTitleFlashing);