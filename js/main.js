function ready(fn) {
    if (document.attachEvent ? document.readyState === "complete" : document.readyState !== "loading") {
        fn()
    } else {
        document.addEventListener("DOMContentLoaded", fn)
    }
}

function hello() {
    return `Hello World ${new Date().getTime()/1000|0}`
}

function initShareButtons() {
    document.querySelectorAll("#share a").forEach(it => {
        if (!it.href.match(/^(?:mailto:)|(?:https:\/\/telegram.me\/)|(?:whatsapp:\/\/)/)) {
            it.addEventListener("click", event => {
                event.preventDefault()
                window.open(it.href, null, "width=600,height=400")
            })
        }
    })
    if (document.querySelector("#share button.link")) document.querySelector("#share button.link").addEventListener("click", function() {
        copyTextToClipboard(this.dataset.link).then(() => new Toast("Link wurde in Zwischenablage kopiert!").show()).catch(e => { console.error(e); new Toast("Link konnte nicht kopiert werden", "Fehler").show() })
    })
}

function initNavBarButtons() {
    document.querySelectorAll("#site_nav > ul > li").forEach(it => {
        /** @type Array<Element> */
        const children = [...it.children];
        /** @type boolean */
        const dropdown = children.filter(e => e.tagName.match(/button/i)).length > 0;
        /** @type boolean */
        const open = children.filter(e => e.tagName.match(/button/i)).filter(e => e.parentElement.classList.contains("open")).length > 0;
        const closeAllOthers = () => {
            [...document.querySelectorAll("#site_nav > ul > li.open")].filter(e => e !== it).forEach(e => e.classList.remove("open"));
        }
        it.addEventListener("mouseover", closeAllOthers);
        if (dropdown) {
            children.filter(e => e.tagName.match(/button/i))[0].addEventListener("click", () => {
                if (open) {
                    it.classList.remove("open");
                } else {
                    closeAllOthers();
                    it.classList.add("open");
                }
            });
        }
    });
}

function initNavToggle() {
    document.querySelectorAll("#site_nav_toggle, #nav_helper").forEach(it => { it.addEventListener("click", () => {
        const a = document.querySelector("#site_nav_toggle")
        if (a.classList.contains("open")) a.classList.remove("open")
        else a.classList.add("open")
    })})
}

/**
 * Class which represents an Error which occured trying to copy a text
 * @param {string} message String which explains the error
 * @param {Error} originalErr Error which caused this Error
 */
class CopyTextError extends Error {
    constructor(message = "", originalErr = null) {
        super(message)
        this.originalErr = originalErr
    }
}

/**
 * Asynchronous function which copies a given text to the clipboard
 * @param {string} text Text to be copied
 * @returns {Promise<[string, string]>} Promise which either resolves to the copied string or rejects while returning a CopyTextError
 */
function copyTextToClipboard(text) {
    return new Promise((resolve, reject) => {
        if (!navigator.clipboard) { // Fallback
            const textArea = document.createElement("textarea")
            textArea.value = text
            textArea.style.display = "none"
            document.body.appendChild(textArea)
            const lastFocus = document.activeElement
            textArea.focus()
            textArea.select()

            try {
                const successfull = document.execCommand("copy")
                if (successfull) {
                    resolve(text)
                } else {
                    reject(new CopyTextError("Unable to copy text to clipbaord using fallback method"))
                }
            } catch(err) {
                reject(new CopyTextError("Unable to copy text to clipboard using fallback method", err))
            }

            document.body.removeChild(textArea)
            lastFocus.focus()
        } else { // Clipbaord API
            navigator.clipboard.writeText(text).then(() => resolve(text)).catch(err => reject(new CopyTextError("Unable to asynchronously copy text to clipboard", err)))
        }
    })
}

/**
 * Class which represents a toast
 */
class Toast {
    /**
     * Constructor for class Toast
     * @param {string} text The text which sholud be shown
     * @param {string} title The title (if any) which shoul be shown
     */
    constructor(text, title) {
        this.text = text
        this.title = title ? title : false
        this.elem = this.createElement()
    }

    show() {
        this.closeAllOthers()
        document.body.appendChild(this.elem)

        this.elem.addEventListener("click", this.close)
        setTimeout(this.close, 8 * 1e3)
    }

    close() {
        const e = document.querySelector(`article.toast`)
        e.classList.add("close")
        setTimeout(() => {
            try {
                document.body.removeChild(e)
            } catch(e) {
                console.error(e)
            }
        }, 2 * 1e3)
    }

    closeAllOthers() {
        document.querySelectorAll("article.toast").forEach(it => { it.remove() })
    }

    createElement() {
        const e = document.createElement("article")
        e.classList.add("toast")
        if (this.title) {
            const t = document.createElement("h5")
            t.innerHTML = this.title
            e.appendChild(t)
        }
        const c = document.createElement("p")
        c.innerHTML = this.text
        e.appendChild(c)
        return e
    }
}

function getAntrag(antragsNummer) {
    return new Promise((resolve, reject) => {
        fetch(`https://redmine.piratenpartei-rhein-erft.de/issues.json?limit=1&cf_8=${encodeURIComponent(antragsNummer)}`).then(r => r.json()).then(j => resolve(j)).catch(e => reject(e))
    })
}

class Antrag {
    constructor(obj) {
        if (!obj) throw new ReferenceError()
        this.obj = obj.issues[0]
        this.author = this.obj.author.name
        this.category = this.obj.category.name
        this.created = new Date(this.obj.created_on)
        this.rawDescription = this.obj.description
        this.description = this.renderDescription(this.rawDescription)
        this.doneRatio = this.obj.done_ratio
        this.redmineID = this.obj.id
        this.priority = this.obj.priority.name
        this.project = this.obj.project.name
        this.start = new Date(this.obj.start_date)
        this.status = this.obj.status.name
        this.title = this.obj.subject
        this.updated = new Date(this.obj.updated_on)
        this.nummer = this.obj.custom_fields.find(it => it.id === 8).value
        this.antragssteller = this.obj.custom_fields.find(it => it.id === 2).value
        this.umsetzungsverantwortlich = this.obj.custom_fields.find(it => it.id === 4).value
        this.umlaufbeschluss = this.obj.custom_fields.find(it => it.id === 5).value > 0
        this.kosten = isNaN(this.obj.custom_fields.find(it => it.id === 7).value) || this.obj.custom_fields.find(it => it.id === 7).value === "" ? 0 : parseFloat(this.obj.custom_fields.find(it => it.id === 7).value)
        this.rt = this.obj.custom_fields.find(it => it.id === 21).value
        this.abstimmung = new Map(this.obj.custom_fields.filter(it => it.name.substring(0, 10) === "Abstimmung").map(it => [it.name, it.value]))
    }

    renderDescription(raw) {
        let res = ""
        raw.replace(/\r/g, "").split("\n").forEach((it, id) => {
            const a = it.match(/^(\w.\.\s)(.*)$/)
            if (a) res += `<${a[1].slice(0, -2)}>${a[2]}</${a[1].slice(0, -2)}>`
            else res += it
        })
        return res
    }

    render() {
        // TODO
    }
}

ready(() => {
    console.log(hello())
    initShareButtons()
    initNavBarButtons()
    initNavToggle()
})