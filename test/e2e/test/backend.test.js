
import { SERVER_URL } from "../config.js";
import { DEMO_USER } from "../roles.js";
import PageBackend from "../page-objects/PageBackend.js";

fixture("Teste die Seite 'Backend'")
    .page(SERVER_URL);


test('erstelle eine neue Ausstellung', async t => {
    // step 1 - generate values
    const uniqueName = "Ausstellung_" + (new Date().getTime());

    // step 2 - perform steps
    await t.useRole(DEMO_USER);
    let page = await PageBackend(t).navigateToViaNavbar();
    let tabAustellungen = await page.tabs.chooseAusstellungen();
    let dialog = await tabAustellungen.clickNeueAustellung();
    await dialog.setTitel(uniqueName);
    await dialog.setBeschreibung("Ein paar Worte zur Ausstellung...");
    await dialog.clickAnlegen(); 
    
    // step 3 - validate results
    await tabAustellungen.checkAusstellungWirdAngezeigt(uniqueName);
});

test('update von Ausstellungs Daten', async t => {
    // step 1 - generate values
	const uniqueName = "Ausstellung_" + (new Date().getTime());

    // step 2 - perform steps
    await t.useRole(DEMO_USER);
    let page = await PageBackend(t).navigateToViaNavbar();
    let tabAustellungen = await page.tabs.chooseAusstellungen();
    let dialog = await tabAustellungen.clickNeueAustellung();
    await dialog.setTitel(uniqueName);
    await dialog.setBeschreibung("Beschreibung vor Aenderung");
    await dialog.clickAnlegen();
	let changeDialog = await tabAustellungen.clickEditAusstellung(uniqueName);
	await changeDialog.setTitel(uniqueName + '_changed');
	await dialog.setBeschreibung("Beschreibung nach Aenderung");
	await dialog.clickAnlegen();
	
    
    // step 3 - validate results
    await tabAustellungen.checkAusstellungWirdAngezeigt(uniqueName + '_changed');
});
