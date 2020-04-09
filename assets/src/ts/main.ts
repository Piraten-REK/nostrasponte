/**
 * @file Main JavaScript/TypeScript file for the Nostra Sponte Wordpress-Theme
 * @author Mike Kühnapfel <mike.kuehnapfel@piraten-rek.de>
 * @version 0.0.1
 */

class CopyTextError extends Error {
    public readonly originalErr: Error|null

    /**
     * Constructor for CopyTextError class
     * @param message String that explains the error
     * @param originalErr Error that caused this Error
     */
    constructor(message: string|undefined = undefined, originalErr: Error|null = null) {
        super(message);
        this.originalErr = originalErr;
    }
}

class Toast {
    public readonly text: string;
    public readonly title: string|null = null;
    public readonly html: boolean;
    private elem: HTMLElement;

    /**
     * Constructor for Toast class
     * @param text Text to be shown
     * @param title Title (if any) to be shown
     * @param html Determines whether to render text as HTML or plain text
     */
    constructor(text: string, title?: string, html: boolean = false) {
        this.text = text;
        if (title) this.title = title;
        this.html = html;
        this.elem = this.createElement();
    }

    /** Creates the HTMLElement for this toast */
    private createElement() {
        const e = document.createElement('article');
        e.classList.add('toast');
        if (this.title) {
            const t = document.createElement('h5');
            t.innerHTML = this.title;
            e.appendChild(t);
        }
        const c = document.createElement('p');
        if (this.html) c.innerHTML = this.text;
        else c.innerText = this.text;
        e.appendChild(c);
        return e;
    }

    /** Closes this toast */
    close() {
        const e = document.querySelector('article.toast') as HTMLElement;
        e.classList.add('close');
        setTimeout(() => {
            try {
                document.body.removeChild(e);
            } catch(e) {
                console.error(e);
            }
        }, 2 * 1e3);
    }

    /** Closes all toasts */
    private closeAllOther() {
        document.querySelectorAll('article.toast').forEach(it => it.remove());
    }

    show() {
        this.closeAllOther();
        document.body.appendChild(this.elem);
        this.elem.addEventListener('click', this.close);
        setTimeout(this.close, 8 * 1e3);
    }
}

/** Initializes touch functionality for dropdown menus in navbar */
function initNavButtons() {
    document.querySelectorAll('#site_nav > ul > li').forEach(it => {
        // @ts-ignore 2322
        const children: Array<HTMLElement> = Array.from(it.children);
        const dropdown = children.some(e => e.tagName.match(/button/i));
        const open = it.classList.contains('open');
        const closeAllOthers = () => Array.from(document.querySelectorAll('#site_nav > ul > li.open')).filter(e => e !== it).forEach(e => e.classList.remove('open'));
        function close() {
            closeAllOthers();
            it.classList.remove('open');
            document.removeEventListener('touchend', close);
        }
        if (dropdown) {
            // @ts-ignore
            children.find(e => e.tagName.match(/button/i)).addEventListener('touchend', event => {
                if (open) it.classList.remove('open');
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
    document.querySelectorAll('#site_nav_toggle, #nav_helper').forEach(it => it.addEventListener('click', () => (document.querySelector('#site_nav_toggle') as HTMLElement).classList.toggle('open')));
}

function initShareButtons() {
    // @ts-ignore
    document.querySelectorAll('[id^="ns_share_buttons_widget"] a').forEach((it: HTMLAnchorElement) => {
        if (!it.href.match(/^(?:mailto:)|(?:https:\/\/telegram.me\/)|(?:whatsapp:\/\/)/)) {
            it.addEventListener('click', event => {
                event.preventDefault();
                window.open(it.href, undefined, 'width=600,height=400,resizable=no,menubar=no,status=no,scrollbars=yes');
            });
        }
    });
    // @ts-ignore
    const link: HTMLAnchorElement|undefined = document.querySelector('[id^="ns_share_buttons_widget"] button.link');
    if (link) link.addEventListener('click', () => {
        copyTextToClipboard(<string> link.dataset.link).then(() => {
            (new Toast('Link wurde in Zwischenanlage kopiert!').show())
        }).catch((e: Error) => {
            console.error(e);
            (new Toast('Link konnte nicht kopiert werden', 'Fehler')).show();
        });
    });
}

/**
 * Asynchronous function that copies a given text to clipboard
 * @param text Text to be copied
 * @returns Promise which either resolves to the copied string or rejects while returning a CopyTextError
 * @throws CopyTextError
 * @async
 */
function copyTextToClipboard(text: string): Promise<string> {
    return new Promise((resolve, reject) => {
        // Fallback
        if (!navigator.clipboard) {
            const textArea = document.createElement('textarea');
            textArea.value = text;
            textArea.style.display = 'none';
            document.body.appendChild(textArea);
            const lastFocus = document.activeElement;
            textArea.focus();
            textArea.select();

            try {
                const successfull = document.execCommand('copy');
                if (successfull) {
                    resolve(text);
                } else {
                    reject(new CopyTextError('Unable to copy text to clipboard using fallback method'));
                }
            } catch(err) {
                reject(new CopyTextError('Unable to copy text to clipboard using fallback method', err));
            }

            document.body.removeChild(textArea);
        } else {
            // Clipboard API
            navigator.clipboard.writeText(text).then(() => resolve(text)).catch(err => reject(new CopyTextError('Unable to asynchronously copy text top clipboard', err)));
        }
    });
}

function backToTopVisibility() {
    function scroll() {
        if (window.scrollY > 200) {
            (document.getElementById('btn_up') as HTMLButtonElement).classList.add('show');
        } else {
            (document.getElementById('btn_up') as HTMLButtonElement).classList.remove('show');
        }
    }
    window.addEventListener('scroll', scroll);
    scroll();
}

function links() {
    /** Regular Expression that defines a link that should be considered as NOT external */
    const notExternal = /^(?:[#\/]|(?:https?:\/\/(?:www\.)?(?:piraten-rek\.de|piratenpartei-rhein-erft\.de|127\.0\.0\.\d{1,3}|.*localhost(?:\/|$))|mailto:|tel:|fax:|^$))/i;
    /** Regular Expression that defines a link that should be considered a mail address */
    const mail = /^mailto:/;
    const links = Array.from(document.getElementsByTagName('a'));
    links.filter(it => !notExternal.test(it.href) && !it.classList.contains('no_img'))
        .forEach(it => {
            if (!it.hasAttribute('rel') || it.getAttribute('rel') !== 'external') it.setAttribute('rel', 'external');
            if (/\S+\s\S+/.test(it.innerText)) it.innerHTML = it.innerText.replace(/(\s)([^\s]+)$/, '$1<span class="external-link-img-wrapper">$2</span>');
            else it.classList.add('external-link-img-wrapper');
        });
    links.filter(it => mail.test(it.href) && !it.classList.contains('no_img'))
        .forEach(it => it.innerHTML = it.innerText.replace(/(\s)([^\s]+)$/, '$1<span class="mail-link-img-wrapper">$2</span>'));
}

// Load all functions
initNavButtons();
initNavToggle();
initShareButtons();
backToTopVisibility();
links();
