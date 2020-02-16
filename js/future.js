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