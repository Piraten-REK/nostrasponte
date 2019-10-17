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

ready(() => {
    console.log(hello())
    initShareButtons()
    initNavBarButtons()
})