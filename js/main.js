/**
 * @file Main JavaScript/TypeScript file for the Nostra Sponte Wordpress-Theme
 * @author Mike Kühnapfel <mike.kuehnapfel@piraten-rek.de>
 * @version 0.0.1
 */
var __extends = (this && this.__extends) || (function () {
    var extendStatics = function (d, b) {
        extendStatics = Object.setPrototypeOf ||
            ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
            function (d, b) { for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p]; };
        return extendStatics(d, b);
    };
    return function (d, b) {
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
var CopyTextError = /** @class */ (function (_super) {
    __extends(CopyTextError, _super);
    /**
     * Constructor for CopyTextError class
     * @param message String that explains the error
     * @param originalErr Error that caused this Error
     */
    function CopyTextError(message, originalErr) {
        if (message === void 0) { message = undefined; }
        if (originalErr === void 0) { originalErr = null; }
        var _this = _super.call(this, message) || this;
        _this.originalErr = originalErr;
        return _this;
    }
    return CopyTextError;
}(Error));
var Toast = /** @class */ (function () {
    /**
     * Constructor for Toast class
     * @param text Text to be shown
     * @param title Title (if any) to be shown
     * @param html Determines whether to render text as HTML or plain text
     */
    function Toast(text, title, html) {
        if (html === void 0) { html = false; }
        this.title = null;
        this.text = text;
        if (title)
            this.title = title;
        this.html = html;
        this.elem = this.createElement();
    }
    /** Creates the HTMLElement for this toast */
    Toast.prototype.createElement = function () {
        var e = document.createElement('article');
        e.classList.add('toast');
        if (this.title) {
            var t = document.createElement('h5');
            t.innerHTML = this.title;
            e.appendChild(t);
        }
        var c = document.createElement('p');
        if (this.html)
            c.innerHTML = this.text;
        else
            c.innerText = this.text;
        e.appendChild(c);
        return e;
    };
    /** Closes this toast */
    Toast.prototype.close = function () {
        var e = document.querySelector('article.toast');
        e.classList.add('close');
        setTimeout(function () {
            try {
                document.body.removeChild(e);
            }
            catch (e) {
                console.error(e);
            }
        }, 2 * 1e3);
    };
    /** Closes all toasts */
    Toast.prototype.closeAllOther = function () {
        document.querySelectorAll('article.toast').forEach(function (it) { return it.remove(); });
    };
    Toast.prototype.show = function () {
        this.closeAllOther();
        document.body.appendChild(this.elem);
        this.elem.addEventListener('click', this.close);
        setTimeout(this.close, 8 * 1e3);
    };
    return Toast;
}());
/** Initializes touch functionality for dropdown menus in navbar */
function initNavButtons() {
    document.querySelectorAll('#site_nav > ul > li').forEach(function (it) {
        // @ts-ignore 2322
        var children = Array.from(it.children);
        var dropdown = children.some(function (e) { return e.tagName.match(/button/i); });
        var open = it.classList.contains('open');
        var closeAllOthers = function () { return Array.from(document.querySelectorAll('#site_nav > ul > li.open')).filter(function (e) { return e !== it; }).forEach(function (e) { return e.classList.remove('open'); }); };
        function close() {
            closeAllOthers();
            it.classList.remove('open');
            document.removeEventListener('touchend', close);
        }
        if (dropdown) {
            // @ts-ignore
            children.find(function (e) { return e.tagName.match(/button/i); }).addEventListener('touchend', function (event) {
                if (open)
                    it.classList.remove('open');
                else {
                    closeAllOthers();
                    it.classList.add('open');
                    setTimeout(document.addEventListener, 200, 'touchend', close);
                }
            });
        }
    });
}
/** Initialize mobile nav toggle */
function initNavToggle() {
    document.querySelectorAll('#site_nav_toggle, #nav_helper').forEach(function (it) { return it.addEventListener('click', function () { return document.querySelector('#site_nav_toggle').classList.toggle('open'); }); });
}
/**
 * Asynchronous function that copies a given text to clipboard
 * @param text Text to be copied
 * @returns Promise which either resolves to the copied string or rejects while returning a CopyTextError
 * @throws CopyTextError
 * @async
 */
function copyTextToClipboard(text) {
    return new Promise(function (resolve, reject) {
        // Fallback
        if (!navigator.clipboard) {
            var textArea = document.createElement('textarea');
            textArea.value = text;
            textArea.style.display = 'none';
            document.body.appendChild(textArea);
            var lastFocus = document.activeElement;
            textArea.focus();
            textArea.select();
            try {
                var successfull = document.execCommand('copy');
                if (successfull) {
                    resolve(text);
                }
                else {
                    reject(new CopyTextError('Unable to copy text to clipboard using fallback method'));
                }
            }
            catch (err) {
                reject(new CopyTextError('Unable to copy text to clipboard using fallback method', err));
            }
            document.body.removeChild(textArea);
        }
        else {
            // Clipboard API
            navigator.clipboard.writeText(text).then(function () { return resolve(text); }).catch(function (err) { return reject(new CopyTextError('Unable to asynchronously copy text top clipboard', err)); });
        }
    });
}
function backToTopVisibility() {
    function scroll() {
        if (window.scrollY > 200 || (window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
            document.getElementById('btn_up').classList.add('show');
        }
        else {
            document.getElementById('btn_up').classList.remove('show');
        }
    }
    window.addEventListener('scroll', scroll);
    scroll();
}
function links() {
    /** Regular Expression that defines a link that should be considered as NOT external */
    var notExternal = /^(?:[#\/]|(?:https?:\/\/(?:www\.)?(?:piraten-rek\.de|piratenpartei-rhein-erft\.de|127\.0\.0\.\d{1,3}|.*localhost(?:\/|$))|mailto:|tel:|fax:))/i;
    /** Regular Expression that defines a link that should be considered a mail address */
    var mail = /^mailto:/;
    var links = Array.from(document.getElementsByTagName('a'));
    links.filter(function (it) { return !notExternal.test(it.href) && !it.classList.contains('no_img'); })
        .forEach(function (it) {
        if (!it.hasAttribute('rel') || it.getAttribute('rel') !== 'external')
            it.setAttribute('rel', 'external');
        if (/\S+\s\S+/.test(it.innerText))
            it.innerHTML = it.innerText.replace(/(\s)([^\s]+)$/, '$1<span class="external-link-img-wrapper">$2</span>');
        else
            it.classList.add('external-link-img-wrapper');
    });
    // links.filter(it => !notExternal.test(it.href) && !it.classList.contains('no_img'))
    //     .forEach(it => it.innerHTML = it.innerText.replace(/(\s)([^\s]+)$/, '$1<span class="external-link-img-wrapper">$2</span>'));
    links.filter(function (it) { return mail.test(it.href) && !it.classList.contains('no_img'); })
        .forEach(function (it) { return it.innerHTML = it.innerText.replace(/(\s)([^\s]+)$/, '$1<span class="mail-link-img-wrapper">$2</span>'); });
}
// Load all functions
initNavButtons();
initNavToggle();
backToTopVisibility();
links();
