
let articleBox = document.querySelector('.article-box');
let articleId = articleBox.id.slice(8);

function Article (id) {
    this.id = id;
}

Article.prototype.viewSource = function () {
    location.href = articleBox.dataset.source;
}

Article.prototype.increaseFontSize = function (e) {
    e.preventDefault();
    let articleBody = document.querySelector('.box-content');
    let currentFontSize = parseFloat(window.getComputedStyle(articleBody, null).getPropertyValue('font-size'));
    articleBody.style.fontSize = (currentFontSize + 1) + 'px';
}

Article.prototype.decreaseFontSize = function (e) {
    e.preventDefault();
    let articleBody = document.querySelector('.box-content');
    let currentFontSize = parseFloat(window.getComputedStyle(articleBody, null).getPropertyValue('font-size'));
    articleBody.style.fontSize = (currentFontSize - 1) + 'px';
}

Article.prototype.displaySaveForLaterNotif = function () {
    let notif = document.querySelector('.notif');
    let notifText = document.querySelector('.notif-text');
    notif.style.display = "block";
    notifText.innerHTML = Lang.notifSuccess;
}

Article.prototype.displayAlreadySavedNotif = function () {
    let notif = document.querySelector('.notif');
    let notifText = document.querySelector('.notif-text');
    notif.style.display = "block";
    notif.className += " notif-warning";
    notifText.innerHTML = Lang.notifFailed;
}

Article.prototype.notifClose = function () {
    let notif = document.querySelector('.notif');
    notif.style.display = "none";
    notif.className = "notif";
}

Article.prototype.saveForLater = function (e) {
    e.preventDefault();
    if (typeof Laravel.apiToken !== 'undefined') {
        fetch('/api/article/' + articleId + '/save-for-later', {
            method: 'POST',
            body: JSON.stringify({
                api_token: Laravel.apiToken
            }),
            headers: {"Content-Type": "application/json"}
        }) 
        .then((res) => {
            return res.json();
        })
        .then((j) => {
            if (j == "Already added") {
                Article.prototype.displayAlreadySavedNotif();
            } else {
                Article.prototype.displaySaveForLaterNotif();
            }
        })
        .catch(function (err) {
            console.log(err)
        });
    }
}

let article = new Article(articleId);

let viewSourceLink = document.querySelector('#view-source-link');
let increaseFontSizeLink = document.querySelector('#increase-font-size-link');
let decreaseFontSizeLink = document.querySelector('#decrease-font-size-link');
let saveForLaterLink = document.querySelector('#save-for-later');
let notifClose = document.querySelector('#notif-close');

viewSourceLink.addEventListener('click', article.viewSource);
increaseFontSizeLink.addEventListener('click', article.increaseFontSize);
decreaseFontSizeLink.addEventListener('click', article.decreaseFontSize);
saveForLaterLink.addEventListener('click', article.saveForLater);
notifClose.addEventListener('click', Article.prototype.notifClose);