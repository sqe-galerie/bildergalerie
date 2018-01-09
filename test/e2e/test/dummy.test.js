import { Selector } from 'testcafe';

import {SERVER_URL} from "../config.js";

fixture("Dummy tests here")
    .page(SERVER_URL);
    

test('navigate to legalnotice works', async t => { 
    // navigate to legalnotice by clicking the navbar link
    await t
        .click(Selector("#nav_legalnotice > a"));
    
    // check the location changed
    const location = await t.eval(() => window.location);
    await t.expect(location.pathname).eql('/legalnotice');
    
    // check legalnotice is shown 
    const contentText = await Selector("body > div.container.main-content").innerText; 
    await t
        .expect(contentText).contains("Impressum")
        .expect(contentText).contains("Haftungsausschluss");
});
