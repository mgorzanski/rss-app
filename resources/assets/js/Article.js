
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

Article.prototype.addToPocket = function (e) {
    e.preventDefault();
    
}

let article = new Article(articleId);

let viewSourceLink = document.querySelector('#view-source-link');
let increaseFontSizeLink = document.querySelector('#increase-font-size-link');
let decreaseFontSizeLink = document.querySelector('#decrease-font-size-link');
let addToPocket = document.querySelector('#add-to-pocket-link');

viewSourceLink.addEventListener('click', article.viewSource);
increaseFontSizeLink.addEventListener('click', article.increaseFontSize);
decreaseFontSizeLink.addEventListener('click', article.decreaseFontSize);
addToPocket.addEventListener('click', article.addToPocket);