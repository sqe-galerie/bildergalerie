import { Selector } from 'testcafe';

import { SERVER_URL } from "../config.js";
import { DEMO_USER, GUEST } from "../roles.js";
import PageBackend from "../page-objects/PageBackend";
import PagePictureCreate from "../page-objects/PagePictureCreate";

fixture("Test Upload new Picture via Create form")
    .page(SERVER_URL);


test('navigate to picture/create', async t => {
    // navigate to legalnotice by clicking the navbar link

    await t
        .useRole(DEMO_USER)
        .expect(Selector("#nav_pictures").exists).ok()
    let page = await PagePictureCreate(t).navigateGemaeldeHinzufuegenNavbar();
    const location = await t.eval(() => window.location);
    await t.
        expect(location.pathname).eql('/pictures/create');


    /** await t
     let page = await PageBackend(t).navigateToViaNavbar();
     let tabAustellungen = await page.tabs.choose;
     let dialog = await tabAustellungen.clickNeueAustellung();
     await dialog.setTitel(uniqueName);
     await dialog.setBeschreibung("Ein paar Worte zur Ausstellung...");
     await dialog.clickAnlegen();
     .click(Selector("#nav_legalnotice > a"));

     // check the location changed
     const location = await t.eval(() => window.location);
     await t.expect(location.pathname).eql('/legalnotice');

     // check legalnotice is shown
     const contentText = await Selector("body > div.container.main-content").innerText;
     await t
     .expect(contentText).contains("Impressum")
     .expect(contentText).contains("Haftungsausschluss");**/
});

/**test('login and logout works', async t => {
    await t
        .useRole(GUEST)
        .expect(Selector("#nav_backend").exists).notOk() // Navigations-Punkt "Backend" wird nicht angezeigt
        .useRole(DEMO_USER)
        .expect(Selector("#nav_backend").exists).ok() // ... jetzt schon
        .useRole(GUEST)
        .expect(Selector("#nav_backend").exists).notOk()
});**/