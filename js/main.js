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

ready(() => {
    console.log(hello())
    initShareButtons()
})