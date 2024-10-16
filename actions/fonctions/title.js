let pageTitle = document.title;
let pageTitleTimeout;

const startPageTitleFlashing = () => {
    pageTitleTimeout = setInterval(function () {
        document.title = document.title === pageTitle ? "Bookfind" : pageTitle;
    }, 1000);
};

window.addEventListener("load",
startPageTitleFlashing);