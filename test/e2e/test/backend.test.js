
import { SERVER_URL } from "../config.js";
import { DEMO_USER, GUEST } from "../roles.js";
import PageBackend from "../page-objects/PageBackend.js";

fixture("Teste die Seite 'Backend'")
    .page(SERVER_URL);


test('erstelle eine neue Ausstellung', async t => {
    const uniqueName = "Ausstellung_" + (new Date().getTime());

    await t.useRole(DEMO_USER);
    let page = await PageBackend(t).navigateToViaNavbar();
    let tabAustellungen = await page.tabs.chooseAusstellungen();
    let dialog = await tabAustellungen.clickNeueAustellung();
    await dialog.setTitel(uniqueName);
    //await t.debug();
    await dialog.setBeschreibung("Ein paar Worte zur Ausstellung...");
    await dialog.clickAnlegen();
    await tabAustellungen.checkAusstellungWirdAngezeigt(uniqueName);
});