import { Selector } from "testcafe";

const createTabAusstellungen = (t) => {
    return {
        /**
         * Check, if the exhibition with the given name is present on screen
         * @param {*} name e.g. "Bilder 2018"
         */
        async checkAusstellungWirdAngezeigt(name) {
            const text = await Selector("#exhibition_table_body").innerText;
            await t.expect(text).contains(name)
        },
        /**
         * Clicks the button to create a new exhibition (which will show a dialog)
         * @returns Promise for the Page-Object of the 'Neue Ausstellung hinzufügen'-Dialog
         */
        async clickNeueAustellung() {
            await t.click("button.open_category_dialog");
            return {
                async setTitel(value) {
                    await t.typeText("#category_name", value);
                },
                async setBeschreibung(value) {
                    await t.typeText("#category_description", value);
                },
                async clickAnlegen() {
                    await t.click("#dialog-save-ausstellung-btn");
                },
                async clickAbbrechen() {
                    throw new Error("nicht implementiert");
                }
            }
        }
    }
};

export default function (t) {
    return {
        /**
         * use the navbar to visit the 'Backend'-Page.
         * @returns Promise for the Page-Object of 'Backend'-Page
         */
        async navigateGemaeldeHinzufuegenNavbar() {
            await t
                .click("#nav_pictures > a")
                .click("#nav_pictures_create > a")
        }
    };
};


