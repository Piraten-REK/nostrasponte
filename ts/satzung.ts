const load = window.location.pathname.indexOf('satzung') >= 0 ? 'getSatzung.php' : 'getGO.php';
fetch(`/wp-content/themes/nostrasponte/${load}`).then(r => r.text()).then(s => (new DOMParser()).parseFromString(s, 'text/xml'))
    .then(xml => {
        const lastEdited = new Date((<Element> xml.documentElement.querySelector('page revision timestamp')).innerHTML);
        const content = (<Element> xml.documentElement.querySelector('page revision text')).innerHTML;

        function wikiParser(input: string) {
            let data = input.replace(/&lt;span id="[\w\.]+"&gt;|&lt;\/span&gt;|&lt;noinclude&gt;[\s\S]*?&lt;\/noinclude&gt;|&lt;br\s?\/?&gt;|\[\[Kategorie:.*?\]\]/g, '');

            // Filter empty lines
            data = data.split('\n').filter(it => !/^\s*$/.test(it)).join('\n');

            // Create headings
            Array.from(data.matchAll(/^(=+)([\w-–§\s,ÄÖÜäöüß:\(\)]+)\1$/gm))
                .forEach(([search, type, replacement]) => data = data.replace(search, `<h${type.length + 1}>${replacement}</h${type.length + 1}>`));

            // Create List Items
            data = data.replace(/^\* (.+)$/gm, '<li>$1</li>');
            data = data.replace(/^\*\* (.+)$/gm, '<li class="indent">$1</li>')

            // Create paragraphs
            data = data.replace(/^([^<].*[^>])$/gm, '<p>$1</p>');

            // Create Lists
            data = data.replace(/(<\/p>|<\/h\d>)\n(<li>[\s\S]*?)\n(<p>|<h\d>)/g, '$1\n<ul>$2</ul>\n$3')
                .replace(/(<\/p>|<\/h\d>)\n(<li>[\s\S]*?)$/g, '$1\n<ul>$2</ul>');

            // bold & italic
            data = data.replace(/'''''(.*?)'''''/g, '<strong><em>$1</em></strong>').replace(/'''(.*?)'''/g, '<strong>$1</strong>').replace(/''(.*?)''/g, '<em>$1</em>');

            // Indetations
            data = data.replace(/^<p>:/gm, '<p class="indent">');

            return data;
        }

        const main = document.createElement('main');
        main.innerHTML = wikiParser(content);
        const foot = document.createElement('footer');
        foot.classList.add('wikiFooter');
        foot.innerHTML = `<p>Quelle: <a class="external-link-img-wrapper" href="https://wiki.piratenpartei.de/NRW:Rhein-Erft-Kreis/Kreisverband/Satzung" target="_blank" rel="external">Piratenwiki</a></p><p>Letzte Bearbeitung: <time datetime="${lastEdited.toISOString()}">${lastEdited.toLocaleString()}</time></p>`
        main.appendChild(foot);
        (<HTMLDivElement> document.getElementById('container')).prepend(main);
    })
    .catch(e => console.error(e));