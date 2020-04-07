var load = window.location.pathname.indexOf('satzung') >= 0 ? 'satzung' : 'go';
fetch("/wp-content/themes/nostrasponte/wiki.php?p=" + load).then(function (r) { return r.text(); }).then(function (s) { return (new DOMParser()).parseFromString(s, 'text/xml'); })
    .then(function (xml) {
    var lastEdited = new Date(xml.documentElement.querySelector('page revision timestamp').innerHTML);
    var content = xml.documentElement.querySelector('page revision text').innerHTML;
    function wikiParser(input) {
        var data = input.replace(/&lt;span id="[\w\.]+"&gt;|&lt;\/span&gt;|&lt;noinclude&gt;[\s\S]*?&lt;\/noinclude&gt;|&lt;br\s?\/?&gt;|\[\[Kategorie:.*?\]\]/g, '');
        // Filter empty lines
        data = data.split('\n').filter(function (it) { return !/^\s*$/.test(it); }).join('\n');
        // Create headings
        Array.from(data.matchAll(/^(=+)([\w-–§\s,ÄÖÜäöüß:\(\)]+)\1$/gm))
            .forEach(function (_a) {
            var search = _a[0], type = _a[1], replacement = _a[2];
            return data = data.replace(search, "<h" + (type.length + 1) + ">" + replacement + "</h" + (type.length + 1) + ">");
        });
        // Create List Items
        data = data.replace(/^\* (.+)$/gm, '<li>$1</li>');
        data = data.replace(/^\*\* (.+)$/gm, '<li class="indent">$1</li>');
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
    var main = document.createElement('main');
    main.innerHTML = wikiParser(content);
    var foot = document.createElement('footer');
    foot.classList.add('wikiFooter');
    foot.innerHTML = "<p>Quelle: <a class=\"external-link-img-wrapper\" href=\"https://wiki.piratenpartei.de/NRW:Rhein-Erft-Kreis/Kreisverband/Satzung\" target=\"_blank\" rel=\"external\">Piratenwiki</a></p><p>Letzte Bearbeitung: <time datetime=\"" + lastEdited.toISOString() + "\">" + lastEdited.toLocaleString() + "</time></p>";
    main.appendChild(foot);
    document.getElementById('container').prepend(main);
})
    .catch(function (e) { return console.error(e); });
