document.addEventListener("DOMContentLoaded", () => {
    const server = document.querySelector('.serverInformation')

    fetch(`https://api.mcsrvstat.us/3/${serverIP}`).then(async res => {
        try {
            const response = await res.json()

            const motd = response.info ?? response.motd

            server.innerHTML = `
                <div class="serverHeader">
                    <div>${serverIP}</div>
                </div>
                <div class="serverBody">
                    <div class="serverMotd">
                        <div><img class="serverIcon" src="${response.icon}" alt="serverImage" /></div>
                        <div>${Array.isArray(motd.html) ? motd.html.join("<br/>") : motd.html}</div>
                    </div>
                    <div>
                        ${response.players.online}/${response.players.max}
                    </div>
                </div>
            `
        } catch (err) {
            console.error(err)
        }
    }).catch(err => {
        console.error(err)
    })
})
