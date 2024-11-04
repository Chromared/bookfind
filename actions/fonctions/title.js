let pageTitle = document.title;
let pageTitleTimeout;

const startPageTitleFlashing = () => {
    pageTitleTimeout = setInterval(function () {
        document.title = document.title === pageTitle ? "Bookfind" : pageTitle;
    }, 1500);
};

window.addEventListener("load",
startPageTitleFlashing);