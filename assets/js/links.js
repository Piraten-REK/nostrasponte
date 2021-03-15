/**
 * @param {NodeListOf<HTMLAnchorElement>} el
 */
export function markExternalLinks (el = document.querySelectorAll('a')) {
  const regEx = /^(?:https?:)\/\/(?:www\.)?(?:piraten-rek\.de|piratenpartei-rhein-erft\.de|127\.0\.0\.\d|wordpress\.localhost)|^\/[^\/]?|^#|javascript:|mailto:/

  el.forEach(it => {
    if (regEx.test(it.getAttribute('href')) || it.classList.contains('link--no-mark')) return
    /** @type {HTMLSpanElement} */
    const insert = document.createElement('span')
    insert.classList.add('external-link__insert')

    const match = it.innerText.match(/([\s-/])(\w+)$/)
    if (match) {
      insert.innerText = match[1] + match[2]
      it.innerText = it.innerText.slice(0, match.index)
      // Add Zero Width Space when triggered by / or -
      if (['/', '-'].some(e => e === match[1])) it.innerText += String.fromCharCode(0x200b)
    } else {
      insert.innerHTML = it.innerHTML
      it.innerHTML = ''
    }
    it.appendChild(insert)
  })
}

export function markMailLinks () {
  document.querySelectorAll('a[href^="mailto:"]').forEach(it => {
    if (it.classList.contains('link--no-mark')) return
    const insert = document.createElement('span')
    insert.classList.add('mail-link__insert')
    if (it.innerText.indexOf('@') === -1) {
      insert.innerHTML = it.innerHTML
      it.innerHTML = ''
    } else {
      const p = it.innerText.indexOf('@')
      insert.innerText = it.innerText.slice(p)
      it.innerText = it.innerText.slice(0, p)
    }
    it.appendChild(insert)
  })
}
